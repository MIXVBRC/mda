<?php


namespace MDA\Medusa;


use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Application;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Sale\Fuser;
use CModule;
use MDA\Medusa\Tables\MultiShopTable;

class MultiShop
{
    private static array $user = [];
    private static array $userData = [];
    private static array $userShop = [];
    private static array $shop = [];
    private static array $shops = [];
    private static array $shopsStocks = [];
    private static array $hl = [];
    private static array $productStocks = [];
    private static array $offerLink = [];

    private static function getHL($id)
    {
        if (empty(self::$hl[$id])) {
            CModule::IncludeModule("highloadblock");
            self::$hl[$id] = HighloadBlockTable::compileEntity(HighloadBlockTable::getById($id)->fetch())->getDataClass();
        }

        return self::$hl[$id];
    }

    public static function getShop(string $shopXmlId): array
    {
        if (empty(self::$shop)) {

            foreach (self::getShops() as $shop) {
                if ($shop['XML_ID'] !== $shopXmlId) continue;
                self::$shop = $shop;
                break;
            }

            if (empty(self::$shop)) {
                $hl = self::getHL(Core::getShopHlBlockId());

                self::$shop = $hl::getRow([
                    'filter' => ['UF_XML_ID' => $shopXmlId],
                ])?:[];

                self::$shop = self::getShopRows(self::$shop);
            }
        }

        return self::$shop?:[];
    }

    public static function getShops(): array
    {
        if (empty(self::$shops)) {

            $hl = self::getHL(Core::getShopHlBlockId());

            self::$shops = $hl::getList()->fetchAll();

            foreach (self::$shops as &$shop) {
                $shop = self::getShopRows($shop);
            }
        }

        return self::$shops?:[];
    }

    private static function getShopRows(array $shop): array
    {
        return [
            'ID' => $shop['ID'],
            'NAME' => $shop['UF_NAME'],
            'DESCRIPTION' => $shop['UF_DESCRIPTION'],
            'XML_ID' => $shop['UF_XML_ID'],
        ];
    }

    /**
     *
     * Fields:
     * <ul>
     * <li> ID int
     * <li> STOCK int
     * <li> PRODUCT string
     * <li> OFFER string
     * </ul>
     *
     * @param string $shopXmlId
     * @return array
     */
    public static function getShopStocks(string $shopXmlId): array
    {
        if (empty(self::$shopsStocks[$shopXmlId])) {
            $hl = self::getHL(Core::getStockHlBlockId());

            self::$shopsStocks[$shopXmlId] = $hl::getList([
                'filter' => [
                    '>UF_KOLICHESTVO' => 0,
                    'UF_MAGAZIN' => $shopXmlId,
                ],
                'select' => [
                    'ID',
                    'UF_KOLICHESTVO',
                    'UF_NOMENKLATURA',
                    'UF_NAME',
                ]
            ])->fetchAll();

            foreach (self::$shopsStocks[$shopXmlId] as &$stock) {

                $explode = explode('#', $stock['UF_NAME']);
                $product = $explode[0];
                $offer = $explode[1];

                $stock = [
                    'ID' => (int) $stock['ID'],
                    'STOCK' => (int) $stock['UF_KOLICHESTVO'],
                    'PRODUCT' => $product?: $stock['UF_NOMENKLATURA'],
                    'OFFER' => $offer,
                ];
            }
        }

        return self::$shopsStocks[$shopXmlId]?:[];
    }

    private static function getUser(): array
    {
        if (empty(self::$user)) {
            CModule::IncludeModule("sale");
            self::$user['fid'] = Fuser::getId();
            self::$user['id'] = CurrentUser::get()->getId();
        }
        return self::$user;
    }

    public static function getUserData(): array
    {
        if (empty(self::$userData)) {
            $user = self::getUser();

            self::$userData = MultiShopTable::getRow([
                'filter' => [
                    [
                        'LOGIC' => 'OR',
                        ['FUSER_ID' => $user['fid']],
                        ['USER_ID' => $user['id']],
                    ]
                ]
            ])?:[];
        }

        return self::$userData;
    }

    public static function getUserShop(): array
    {
        if (empty(self::$userShop)) {
            if (!$userData = self::getUserData()) return [];
            self::$userShop = self::getShop($userData['XML_ID']);
        }

        return self::$userShop?:[];
    }

    public static function setUserShop(string $shopXmlId): bool
    {
        if ($id = self::getUserData()['ID']) {
            $fields = [
                'XML_ID' => $shopXmlId,
            ];
            $result = MultiShopTable::update($id, $fields);
            if (!$result->isSuccess()) return false;
            self::$userData = array_merge(self::$userData, $fields);
        } else {
            $user = self::getUser();
            $fields = [
                'FUSER_ID' => $user['fid'],
                'USER_ID' => $user['id'],
                'XML_ID' => $shopXmlId,
            ];
            $result = MultiShopTable::add($fields);
            if (!$result->isSuccess()) return false;
            self::$userData = array_merge(self::$userData, $fields);
        }

        return true;
    }

    public static function getFiltersByShop(string $shopXmlId): array
    {
        $products = [];

        $stocks = self::getShopStocks($shopXmlId);
        foreach ($stocks as $stock) {
            $products[] = $stock['PRODUCT'];
        }

        if (empty($products)) return [];

        $elements = ElementTable::getList([
            'filter' => [
                'XML_ID' => $products,
                'IBLOCK_ID' => Core::getProductIblockId(),
            ],
            'select' => [
                'ID',
                'IBLOCK_SECTION_ID',
                'IBLOCK_ADDITIONAL_SECTION_ID' => 'SECTION.IBLOCK_SECTION_ID',
            ],
            'runtime' => [
                'SECTION' => [
                    'data_type' => SectionElementTable::class,
                    'reference' => [
                        '=this.ID' => 'ref.IBLOCK_ELEMENT_ID',
                    ],
                    'join_type' => 'left'
                ],
            ],
        ]);

        while ($element = $elements->fetch()) {
            $productIds[] = $element['ID'];
            $sectionIds[] = $element['IBLOCK_SECTION_ID'];
            $sectionIds[] = $element['IBLOCK_ADDITIONAL_SECTION_ID'];
        }

        $sections = SectionTable::getList([
            'filter' => [
                'IBLOCK_ID' => Core::getProductIblockId(),
                'ID' => array_unique($sectionIds),
            ],
            'select' => [
                'SECTION_ID' => 'SECTION.ID',
            ],
            'runtime' => [
                'SECTION' => [
                    'data_type' => SectionTable::class,
                    'reference' => [
                        '=this.IBLOCK_ID' => 'ref.IBLOCK_ID',
                        '>=this.LEFT_MARGIN' => 'ref.LEFT_MARGIN',
                        '<=this.RIGHT_MARGIN' => 'ref.RIGHT_MARGIN',
                    ],
                    'join_type' => 'inner'
                ],
            ],
        ])->fetchAll();

        $sectionIds = array_map(function ($section) { return $section['SECTION_ID']; },$sections);

        return [
            'FILTER_PRODUCTS' => [
                'ID' => array_unique($productIds),
            ],
            'FILTER_SECTIONS' => [
                'ID' => array_unique($sectionIds),
            ],
        ];
    }

    public static function getProductStocks(string $xmlId): int
    {
        $userShop = self::getUserShop();

        if (empty(self::$productStocks)) {
            $stocks = self::getShopStocks($userShop['XML_ID']);
            foreach ($stocks as $stock) {
                if ($stock['OFFER']) {
                    $productXmlId = implode('#', [$stock['PRODUCT'],$stock['OFFER']]);
                } else {
                    $productXmlId = $stock['PRODUCT'];
                }

                self::$productStocks[$userShop['XML_ID']][$productXmlId] = $stock['STOCK'];
            }
        }

        return self::$productStocks[$userShop['XML_ID']][$xmlId]?:0;
    }

    public static function getOffers()
    {
        $result = [];
        $userShop = self::getUserShop();
        $stocks = self::getShopStocks($userShop['XML_ID']);
        foreach ($stocks as $stock) {
            if (!$stock['OFFER']) continue;
            $result[] = implode('#', [$stock['PRODUCT'],$stock['OFFER']]);
        }

        return $result;
    }
}
<?

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
use MDA\Medusa\MultiShop;

Class Comments extends CBitrixComponent
{
    public function executeComponent()
    {

        if (!$this->arResult['SHOPS'] = MultiShop::getShops()) {
            return;
        }
        
        if (!$this->arResult['SHOP'] = MultiShop::getUserShop()) {
            $this->arResult['SHOW_QUESTION'] = true;
            $this->arResult['SHOP'] = $this->arResult['SHOPS'][array_key_first($this->arResult['SHOPS'])];
        }

        pre($this->arResult['SHOP']);

        pre($this->arResult['SHOP']['NAME']);

//        $this->setFilter();

        $this->includeComponentTemplate();
        die;

    }

    /*private function setFilter()
    {
        $stocks = $this->getStocks();

        $products = [];
        $productIds = [];
        $sectionIds = [];
        $offers = [];

        foreach ($stocks as $stock) {

            $explode = explode('#', $stock['OFFER']);
            $product = $explode[0];
            $offer = $explode[1];

            $products[] = $stock['PRODUCT'];
            $products[] = $product;
        }

        $products = array_unique($products);

        $productst = ElementTable::getList([
            'filter' => [
                'XML_ID' => $products,
                'IBLOCK_ID' => $this->arParams['PRODUCT_IBLOCK_ID'],
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
        ])->fetchAll();

        foreach ($productst as $product) {
            $productIds[] = $product['ID'];
            $sectionIds[] = $product['IBLOCK_SECTION_ID'];
            $sectionIds[] = $product['IBLOCK_ADDITIONAL_SECTION_ID'];
        }
        $sectionIds = array_unique($sectionIds);

        $sectionIds = SectionTable::getList([
            'filter' => [
                'IBLOCK_ID' => $this->arParams['PRODUCT_IBLOCK_ID'],
                'ID' => $sectionIds,
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

        $sectionIds = array_unique(array_map(function ($section) { return $section['SECTION_ID']; },$sectionIds));

        $GLOBALS[$this->arParams['PRODUCTS_FILTER_NAME']] = [
            'XML_ID' => $products,
        ];

        $GLOBALS[$this->arParams['SECTIONS_FILTER_NAME']] = [
            'ID' => $sectionIds,
        ];
    }*/
}
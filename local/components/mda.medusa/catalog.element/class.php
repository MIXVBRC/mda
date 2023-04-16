<?

use Bitrix\Main\Localization\Loc,
    Bitrix\Main,
    Bitrix\Main\Loader,
    Bitrix\Iblock\Component\Element,
    Bitrix\Catalog;
use MDA\Medusa\MultiShop;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

if (!\Bitrix\Main\Loader::includeModule('iblock'))
{
	ShowError(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
	return;
}

class CatalogElementComponent extends Element
{
    public function __construct($component = null)
    {
        parent::__construct($component);
        $this->setExtendedMode(false);
    }

    private static function haveOffers($id): bool
    {
        return (bool) CCatalogSKU::getExistOffers($id)[$id];
    }

    protected function getIblockElements($elementIterator)
    {
        $iblockElements = array();

        /** @var \CIBlockResult $elementIterator */
        if (!empty($elementIterator) && ($elementObject = $elementIterator->GetNextElement()))
        {
            $element = $elementObject->GetFields();
            
            // TODO: MDA MEDUSA
            $element['HAVE_OFFERS'] = self::haveOffers($element['ID']);
            if ($element['XML_ID'] && !$element['HAVE_OFFERS']) {
                $element['STOCK'] = MultiShop::getProductStocks($element['XML_ID']);
            }

            $this->processElement($element);
            $iblockElements[$element['ID']] = $element;
        }
        else
        {
            $this->abortResultCache();
            $this->errorCollection->setError(new \Bitrix\Main\Error(Loc::getMessage('CATALOG_ELEMENT_NOT_FOUND'), self::ERROR_404));
        }

        return $iblockElements;
    }

    protected function getIblockOffers($iblockId)
    {
        $offers = array();
        $iblockParams = $this->storage['IBLOCK_PARAMS'][$iblockId];

        $enableCompatible = $this->isEnableCompatible();

        if (
            $this->useCatalog
            && $this->offerIblockExist($iblockId)
            && !empty($this->productWithOffers[$iblockId])
        )
        {
            $catalog = $this->storage['CATALOGS'][$iblockId];

            $productProperty = 'PROPERTY_'.$catalog['SKU_PROPERTY_ID'];
            $productPropertyValue = $productProperty.'_VALUE';

            $offersFilter = $this->getOffersFilter($catalog['IBLOCK_ID']);
            $offersFilter[$productProperty] = $this->productWithOffers[$iblockId];

            $offersSelect = array(
                'ID' => 1,
                'XML_ID' => 1, // TODO: MDA MEDUSA
                'IBLOCK_ID' => 1,
                $productProperty => 1,
                'PREVIEW_PICTURE' => 1,
                'DETAIL_PICTURE' => 1,
            );

            if ($this->arParams['SHOW_SKU_DESCRIPTION'] === 'Y')
            {
                $offersSelect['PREVIEW_TEXT'] = 1;
                $offersSelect['DETAIL_TEXT'] = 1;
                $offersSelect['PREVIEW_TEXT_TYPE'] = 1;
                $offersSelect['DETAIL_TEXT_TYPE'] = 1;
            }

            if (!empty($iblockParams['OFFERS_FIELD_CODE']))
            {
                foreach ($iblockParams['OFFERS_FIELD_CODE'] as $code)
                    $offersSelect[$code] = 1;
                unset($code);
            }

            $offersSelect = $this->getProductSelect($iblockId, array_keys($offersSelect));

            $getListParams = $this->prepareQueryFields($offersSelect, $offersFilter, $this->getOffersSort());
            $offersSelect = $getListParams['SELECT'];
            $offersFilter = $getListParams['FILTER'];

            // TODO: MDA MEDUSA
            $offersXmlIds = MultiShop::getOffers();
            if (!empty($offersXmlIds)) {
                $offersFilter = array_merge(['XML_ID'=>$offersXmlIds],$offersFilter);
            }

            $offersOrder = $getListParams['ORDER'];
            unset($getListParams);

            $checkFields = array();
            foreach (array_keys($offersOrder) as $code)
            {
                $code = mb_strtoupper($code);
                if ($code == 'ID' || $code == 'AVAILABLE')
                    continue;
                $checkFields[] = $code;
            }
            unset($code);

            $productFields = $this->getProductFields($iblockId);
            $translateFields = $this->getCompatibleProductFields();

            $offersId = array();
            $offersCount = array();
            $iterator = \CIBlockElement::GetList(
                $offersOrder,
                $offersFilter,
                false,
                false,
                $offersSelect
            );
            while($row = $iterator->GetNext())
            {
                $row['STOCK'] = MultiShop::getProductStocks($row['XML_ID']);
                $row['ID'] = (int)$row['ID'];
                $row['IBLOCK_ID'] = (int)$row['IBLOCK_ID'];
                $productId = (int)$row[$productPropertyValue];

                if ($productId <= 0)
                    continue;

                if ($enableCompatible && $this->arParams['OFFERS_LIMIT'] > 0)
                {
                    $offersCount[$productId]++;
                    if($offersCount[$productId] > $this->arParams['OFFERS_LIMIT'])
                        continue;
                }

                $row['SORT_HASH'] = 'ID';
                if (!empty($checkFields))
                {
                    $checkValues = '';
                    foreach ($checkFields as $code)
                        $checkValues .= ($row[$code] ?? '').'|';
                    unset($code);
                    if ($checkValues != '')
                        $row['SORT_HASH'] = md5($checkValues);
                    unset($checkValues);
                }
                $row['LINK_ELEMENT_ID'] = $productId;
                $row['PROPERTIES'] = array();
                $row['DISPLAY_PROPERTIES'] = array();

                $row['PRODUCT'] = array(
                    'TYPE' => (int)$row['~TYPE'],
                    'AVAILABLE' => $row['~AVAILABLE'],
                    'BUNDLE' => $row['~BUNDLE'],
                    'QUANTITY' => $row['~QUANTITY'],
                    'QUANTITY_TRACE' => $row['~QUANTITY_TRACE'],
                    'CAN_BUY_ZERO' => $row['~CAN_BUY_ZERO'],
                    'MEASURE' => (int)$row['~MEASURE'],
                    'SUBSCRIBE' => $row['~SUBSCRIBE'],
                    'VAT_ID' => (int)$row['~VAT_ID'],
                    'VAT_RATE' => 0,
                    'VAT_INCLUDED' => $row['~VAT_INCLUDED'],
                    'WEIGHT' => (float)$row['~WEIGHT'],
                    'WIDTH' => (float)$row['~WIDTH'],
                    'LENGTH' => (float)$row['~LENGTH'],
                    'HEIGHT' => (float)$row['~HEIGHT'],
                    'PAYMENT_TYPE' => $row['~PAYMENT_TYPE'],
                    'RECUR_SCHEME_TYPE' => $row['~RECUR_SCHEME_TYPE'],
                    'RECUR_SCHEME_LENGTH' => (int)$row['~RECUR_SCHEME_LENGTH'],
                    'TRIAL_PRICE_ID' => (int)$row['~TRIAL_PRICE_ID']
                );

                $vatId = 0;
                $vatRate = 0;
                if ($row['PRODUCT']['VAT_ID'] > 0)
                    $vatId = $row['PRODUCT']['VAT_ID'];
                elseif ($this->storage['IBLOCKS_VAT'][$catalog['IBLOCK_ID']] > 0)
                    $vatId = $this->storage['IBLOCKS_VAT'][$catalog['IBLOCK_ID']];
                if ($vatId > 0 && isset($this->storage['VATS'][$vatId]))
                    $vatRate = $this->storage['VATS'][$vatId];
                $row['PRODUCT']['VAT_RATE'] = $vatRate;
                unset($vatRate, $vatId);

                if ($enableCompatible)
                {
                    foreach ($translateFields as $currentKey => $oldKey)
                        $row[$oldKey] = $row[$currentKey];
                    unset($currentKey, $oldKey);
                    $row['~CATALOG_VAT'] = $row['PRODUCT']['VAT_RATE'];
                    $row['CATALOG_VAT'] = $row['PRODUCT']['VAT_RATE'];
                }
                else
                {
                    // temporary (compatibility custom templates)
                    $row['~CATALOG_TYPE'] = $row['PRODUCT']['TYPE'];
                    $row['CATALOG_TYPE'] = $row['PRODUCT']['TYPE'];
                    $row['~CATALOG_QUANTITY'] = $row['PRODUCT']['QUANTITY'];
                    $row['CATALOG_QUANTITY'] = $row['PRODUCT']['QUANTITY'];
                    $row['~CATALOG_QUANTITY_TRACE'] = $row['PRODUCT']['QUANTITY_TRACE'];
                    $row['CATALOG_QUANTITY_TRACE'] = $row['PRODUCT']['QUANTITY_TRACE'];
                    $row['~CATALOG_CAN_BUY_ZERO'] = $row['PRODUCT']['CAN_BUY_ZERO'];
                    $row['CATALOG_CAN_BUY_ZERO'] = $row['PRODUCT']['CAN_BUY_ZERO'];
                    $row['~CATALOG_SUBSCRIBE'] = $row['PRODUCT']['SUBSCRIBE'];
                    $row['CATALOG_SUBSCRIBE'] = $row['PRODUCT']['SUBSCRIBE'];
                }

                foreach ($productFields as $field)
                    unset($row[$field], $row['~'.$field]);
                unset($field);

                if ($row['PRODUCT']['TYPE'] == Catalog\ProductTable::TYPE_OFFER)
                    $this->calculatePrices[$row['ID']] = $row['ID'];

                $row['ITEM_PRICE_MODE'] = null;
                $row['ITEM_PRICES'] = array();
                $row['ITEM_QUANTITY_RANGES'] = array();
                $row['ITEM_MEASURE_RATIOS'] = array();
                $row['ITEM_MEASURE'] = array();
                $row['ITEM_MEASURE_RATIO_SELECTED'] = null;
                $row['ITEM_QUANTITY_RANGE_SELECTED'] = null;
                $row['ITEM_PRICE_SELECTED'] = null;
                $row['CHECK_QUANTITY'] = $this->isNeedCheckQuantity($row['PRODUCT']);

                if ($row['PRODUCT']['MEASURE'] > 0)
                {
                    $row['ITEM_MEASURE'] = array(
                        'ID' => $row['PRODUCT']['MEASURE'],
                        'TITLE' => '',
                        '~TITLE' => ''
                    );
                }
                else
                {
                    $row['ITEM_MEASURE'] = array(
                        'ID' => null,
                        'TITLE' => $this->storage['DEFAULT_MEASURE']['SYMBOL_RUS'],
                        '~TITLE' => $this->storage['DEFAULT_MEASURE']['~SYMBOL_RUS']
                    );
                }
                if ($enableCompatible)
                {
                    $row['CATALOG_MEASURE'] = $row['ITEM_MEASURE']['ID'];
                    $row['CATALOG_MEASURE_NAME'] = $row['ITEM_MEASURE']['TITLE'];
                    $row['~CATALOG_MEASURE_NAME'] = $row['ITEM_MEASURE']['~TITLE'];
                }

                $row['PROPERTIES'] = array();
                $row['DISPLAY_PROPERTIES'] = array();

                \Bitrix\Iblock\Component\Tools::getFieldImageData(
                    $row,
                    array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
                    \Bitrix\Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
                    ''
                );

                $offersId[$row['ID']] = $row['ID'];
                $offers[$row['ID']] = $row;
            }
            unset($row, $iterator);

            if (!empty($offersId))
            {
                $loadPropertyCodes = ($iblockParams['OFFERS_PROPERTY_CODE'] ?? []);
                if ( \Bitrix\Iblock\Model\PropertyFeature::isEnabledFeatures())
                {
                    $loadPropertyCodes = array_merge($loadPropertyCodes, $iblockParams['OFFERS_TREE_PROPS']);
                }

                $propertyList = $this->getPropertyList($catalog['IBLOCK_ID'], $loadPropertyCodes);
                unset($loadPropertyCodes);

                if (!empty($propertyList) || $this->useDiscountCache)
                {
                    \CIBlockElement::GetPropertyValuesArray($offers, $catalog['IBLOCK_ID'], $offersFilter);
                    foreach ($offers as &$row)
                    {
                        if ($this->useDiscountCache)
                        {
                            if ($this->storage['USE_SALE_DISCOUNTS'])
                                Catalog\Discount\DiscountManager::setProductPropertiesCache($row['ID'], $row["PROPERTIES"]);
                            else
                                \CCatalogDiscount::SetProductPropertiesCache($row['ID'], $row["PROPERTIES"]);
                        }

                        if (!empty($propertyList))
                        {
                            foreach ($propertyList as $pid)
                            {
                                if (!isset($row["PROPERTIES"][$pid]))
                                    continue;
                                $prop = &$row["PROPERTIES"][$pid];
                                $boolArr = is_array($prop["VALUE"]);
                                if (
                                    ($boolArr && !empty($prop["VALUE"])) ||
                                    (!$boolArr && (string)$prop["VALUE"] !== '')
                                )
                                {
                                    $row["DISPLAY_PROPERTIES"][$pid] = \CIBlockFormatProperties::GetDisplayValue($row, $prop, "catalog_out");
                                }
                                unset($boolArr, $prop);
                            }
                            unset($pid);
                        }
                    }
                    unset($row);
                }

                if ($this->useDiscountCache)
                {
                    if ($this->storage['USE_SALE_DISCOUNTS'])
                    {
                        Catalog\Discount\DiscountManager::preloadPriceData($offersId, $this->storage['PRICES_ALLOW']);
                        Catalog\Discount\DiscountManager::preloadProductDataToExtendOrder($offersId, $this->getUserGroups());
                    }
                    else
                    {
                        \CCatalogDiscount::SetProductSectionsCache($offersId);
                        \CCatalogDiscount::SetDiscountProductCache($offersId, array('IBLOCK_ID' => $catalog['IBLOCK_ID'], 'GET_BY_ID' => 'Y'));
                    }
                }
            }
            unset($offersId);
        }

        return $offers;
    }

    protected function editTemplateJsOffers(&$item, $offerSet)
    {
        $matrix = [];
        $intSelected = -1;

        foreach ($item['OFFERS'] as $keyOffer => $offer)
        {
            if ($item['OFFER_ID_SELECTED'] > 0)
            {
                $foundOffer = ($item['OFFER_ID_SELECTED'] == $offer['ID']);
            }
            else
            {
                $foundOffer = $offer['CAN_BUY'];
            }

            if ($foundOffer && $intSelected == -1)
            {
                $intSelected = $keyOffer;
            }
            unset($foundOffer);

            $skuProps = false;
            if (!empty($offer['DISPLAY_PROPERTIES']))
            {
                $skuProps = [];
                foreach ($offer['DISPLAY_PROPERTIES'] as $oneProp)
                {
                    if ($oneProp['PROPERTY_TYPE'] === Iblock\PropertyTable::TYPE_FILE)
                    {
                        continue;
                    }

                    $skuProps[] = [
                        'CODE' => $oneProp['CODE'],
                        'NAME' => $oneProp['NAME'],
                        'VALUE' => $oneProp['DISPLAY_VALUE'],
                    ];
                }
                unset($oneProp);
            }

            if (isset($offerSet[$offer['ID']]))
            {
                $offer['OFFER_GROUP'] = true;
                $item['OFFERS'][$keyOffer]['OFFER_GROUP'] = true;
            }

            $ratioSelectedIndex = $offer['ITEM_MEASURE_RATIO_SELECTED'];
            $firstPhoto = reset($offer['MORE_PHOTO']);
            $oneRow = [
                'ID' => $offer['ID'],
                'CODE' => $offer['CODE'],
                'STOCK' => $offer['STOCK'], // TODO: MDA MEDUSA
                'NAME' => $offer['~NAME'],
                'TREE' => $offer['TREE'],
                'DISPLAY_PROPERTIES' => $skuProps,
                'PREVIEW_TEXT' => $offer['PREVIEW_TEXT'],
                'PREVIEW_TEXT_TYPE' => $offer['PREVIEW_TEXT_TYPE'],
                'DETAIL_TEXT' => $offer['DETAIL_TEXT'],
                'DETAIL_TEXT_TYPE' => $offer['DETAIL_TEXT_TYPE'],
                'ITEM_PRICE_MODE' => $offer['ITEM_PRICE_MODE'],
                'ITEM_PRICES' => $offer['ITEM_PRICES'],
                'ITEM_PRICE_SELECTED' => $offer['ITEM_PRICE_SELECTED'],
                'ITEM_QUANTITY_RANGES' => $offer['ITEM_QUANTITY_RANGES'],
                'ITEM_QUANTITY_RANGE_SELECTED' => $offer['ITEM_QUANTITY_RANGE_SELECTED'],
                'ITEM_MEASURE_RATIOS' => $offer['ITEM_MEASURE_RATIOS'],
                'ITEM_MEASURE_RATIO_SELECTED' => $ratioSelectedIndex,
                'PREVIEW_PICTURE' => $firstPhoto,
                'DETAIL_PICTURE' => $firstPhoto,
                'CHECK_QUANTITY' => $offer['CHECK_QUANTITY'],
                'MAX_QUANTITY' => $offer['PRODUCT']['QUANTITY'],
                'STEP_QUANTITY' => $offer['ITEM_MEASURE_RATIOS'][$ratioSelectedIndex]['RATIO'], // deprecated
                'QUANTITY_FLOAT' => is_float($offer['ITEM_MEASURE_RATIOS'][$ratioSelectedIndex]['RATIO']), // deprecated
                'MEASURE' => $offer['ITEM_MEASURE']['TITLE'],
                'OFFER_GROUP' => (isset($offerSet[$offer['ID']]) && $offerSet[$offer['ID']]),
                'CAN_BUY' => $offer['CAN_BUY'],
                'CATALOG_SUBSCRIBE' => $offer['PRODUCT']['SUBSCRIBE'],
                'SLIDER' => $offer['MORE_PHOTO'],
                'SLIDER_COUNT' => $offer['MORE_PHOTO_COUNT'],
            ];
            unset($ratioSelectedIndex);

            $matrix[$keyOffer] = $oneRow;
        }

        if ($intSelected == -1)
        {
            $intSelected = 0;
        }

        $item['JS_OFFERS'] = $matrix;
        $item['OFFERS_SELECTED'] = $intSelected;

        if ($matrix[$intSelected]['SLIDER_COUNT'] > 0)
        {
            $item['MORE_PHOTO'] = $matrix[$intSelected]['SLIDER'];
            $item['MORE_PHOTO_COUNT'] = $matrix[$intSelected]['SLIDER_COUNT'];
        }

        $item['OFFERS_IBLOCK'] = $this->storage['SKU_IBLOCK_INFO']['IBLOCK_ID'];
    }

    /**
     * Processing parameters unique to catalog.element component.
     *
     * @param array $params		Component parameters.
     * @return array
     */
    public function onPrepareComponentParams($params)
    {
        $params = parent::onPrepareComponentParams($params);

        $params['COMPATIBLE_MODE'] = (isset($params['COMPATIBLE_MODE']) && $params['COMPATIBLE_MODE'] === 'N' ? 'N' : 'Y');
        if ($params['COMPATIBLE_MODE'] === 'N')
        {
            $params['SET_VIEWED_IN_COMPONENT'] = 'N';
            $params['DISABLE_INIT_JS_IN_COMPONENT'] = 'Y';
            $params['OFFERS_LIMIT'] = 0;
        }

        $this->setCompatibleMode($params['COMPATIBLE_MODE'] === 'Y');

        $params['SET_VIEWED_IN_COMPONENT'] = isset($params['SET_VIEWED_IN_COMPONENT']) && $params['SET_VIEWED_IN_COMPONENT'] === 'Y' ? 'Y' : 'N';

        $params['DISABLE_INIT_JS_IN_COMPONENT'] = isset($params['DISABLE_INIT_JS_IN_COMPONENT']) && $params['DISABLE_INIT_JS_IN_COMPONENT'] === 'Y' ? 'Y' : 'N';
        if ($params['DISABLE_INIT_JS_IN_COMPONENT'] !== 'Y')
        {
            \CJSCore::Init(array('popup'));
        }

        return $params;
    }

    /**
     * Fill additional keys for component cache.
     *
     * @param array &$resultCacheKeys		Cached result keys.
     * @return void
     */
    protected function initAdditionalCacheKeys(&$resultCacheKeys)
    {
        parent::initAdditionalCacheKeys($resultCacheKeys);

        if (
            $this->useCatalog
            && !empty($this->storage['CATALOGS'][$this->arParams['IBLOCK_ID']])
            && is_array($this->storage['CATALOGS'][$this->arParams['IBLOCK_ID']])
        )
        {
            $element =& $this->elements[0];

            // catalog hit stats
            $productTitle = !empty($element['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
                ? $element['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
                : $element['NAME'];

            $categoryId = '';
            $categoryPath = array();

            if (isset($element['SECTION']['ID']))
            {
                $categoryId = $element['SECTION']['ID'];
            }

            if (isset($element['SECTION']['PATH']))
            {
                foreach ($element['SECTION']['PATH'] as $cat)
                {
                    $categoryPath[$cat['ID']] = $cat['NAME'];
                }
            }

            $this->arResult['CATEGORY_PATH'] = implode('/', $categoryPath);

            $counterData = array(
                'product_id' => $element['ID'],
                'iblock_id' => $this->arParams['IBLOCK_ID'],
                'product_title' => $productTitle,
                'category_id' => $categoryId,
                'category' => $categoryPath
            );

            if (empty($element['OFFERS']))
            {
                $priceProductId = $element['ID'];
            }
            else
            {
                $offer = reset($element['OFFERS']);
                $priceProductId = $offer['ID'];
                unset($offer);
            }

            // price for anonymous
            if ($this->useDiscountCache)
            {
                if ($this->storage['USE_SALE_DISCOUNTS'])
                {
                    $priceTypes = array();
                    $priceIterator = Catalog\GroupAccessTable::getList(array(
                        'select' => array('CATALOG_GROUP_ID'),
                        'filter' => array('GROUP_ID' => 2, '=ACCESS' => Catalog\GroupAccessTable::ACCESS_BUY),
                        'order' => array('CATALOG_GROUP_ID' => 'ASC')
                    ));
                    while ($priceType = $priceIterator->fetch())
                    {
                        $priceTypeId = (int)$priceType['CATALOG_GROUP_ID'];
                        $priceTypes[$priceTypeId] = $priceTypeId;
                        unset($priceTypeId);
                    }
                    Catalog\Discount\DiscountManager::preloadPriceData(array($priceProductId), $priceTypes);
                    Catalog\Product\Price::loadRoundRules($priceTypes);
                }
            }
            $optimalPrice = \CCatalogProduct::GetOptimalPrice($priceProductId, 1, array(2), 'N', array(), $this->getSiteId(), array());
            $counterData['price'] = $optimalPrice['RESULT_PRICE']['DISCOUNT_PRICE'];
            $counterData['currency'] = $optimalPrice['RESULT_PRICE']['CURRENCY'];

            // make sure it is in utf8
            $counterData = Main\Text\Encoding::convertEncoding($counterData, SITE_CHARSET, 'UTF-8');

            // pack value and protocol version
            $rcmLogCookieName = Main\Config\Option::get('main', 'cookie_name', 'BITRIX_SM') . '_' . Main\Analytics\Catalog::getCookieLogName();

            $this->arResult['counterData'] = array(
                'item' => base64_encode(json_encode($counterData)),
                'user_id' => new Main\Text\JsExpression(
                    'function(){return BX.message("USER_ID") ? BX.message("USER_ID") : 0;}'
                ),
                'recommendation' => new Main\Text\JsExpression(
                    'function() {
							var rcmId = "";
							var cookieValue = BX.getCookie("' . $rcmLogCookieName . '");
							var productId = ' . $element["ID"] . ';
							var cItems = [];
							var cItem;

							if (cookieValue)
							{
								cItems = cookieValue.split(".");
							}

							var i = cItems.length;
							while (i--)
							{
								cItem = cItems[i].split("-");
								if (cItem[0] == productId)
								{
									rcmId = cItem[1];
									break;
								}
							}

							return rcmId;
						}'
                ),
                'v' => '2'
            );
            $resultCacheKeys[] = 'counterData';

            if ($this->arParams['SET_VIEWED_IN_COMPONENT'] === 'Y')
            {
                $viewedProduct = array(
                    'PRODUCT_ID' => $element['ID'],
                    'OFFER_ID' => $element['ID']
                );

                if (!empty($element['OFFERS']))
                {
                    $viewedProduct['OFFER_ID'] = $element['OFFER_ID_SELECTED'] > 0
                        ? $element['OFFER_ID_SELECTED']
                        : $element['OFFERS'][0]['ID'];
                }

                $this->arResult['VIEWED_PRODUCT'] = $viewedProduct;
                $resultCacheKeys[] = 'VIEWED_PRODUCT';
                unset($viewedProduct);
            }
            unset($element);
        }
    }

    /**
     * Save compatible viewed product in catalog.element only.
     *
     * @return void
     */
    protected function saveViewedProduct()
    {
        if ($this->isEnableCompatible())
        {
            if ((string)Main\Config\Option::get('sale', 'product_viewed_save') === 'Y')
            {
                if (
                    !isset($_SESSION['VIEWED_ENABLE'])
                    && isset($_SESSION['VIEWED_PRODUCT'])
                    && $_SESSION['VIEWED_PRODUCT'] != $this->arResult['ID']
                    && Loader::includeModule('sale')
                )
                {
                    $_SESSION['VIEWED_ENABLE'] = 'Y';
                    $fields = array(
                        'PRODUCT_ID' => (int)$_SESSION['VIEWED_PRODUCT'],
                        'MODULE' => 'catalog',
                        'LID' => $this->getSiteId()
                    );
                    /** @noinspection PhpDeprecationInspection */
                    \CSaleViewedProduct::Add($fields);
                }

                if (
                    isset($_SESSION['VIEWED_ENABLE'])
                    && $_SESSION['VIEWED_ENABLE'] === 'Y'
                    && $_SESSION['VIEWED_PRODUCT'] != $this->arResult['ID']
                    && Loader::includeModule('sale')
                )
                {
                    $fields = array(
                        'PRODUCT_ID' => $this->arResult['ID'],
                        'MODULE' => 'catalog',
                        'LID' => $this->getSiteId(),
                        'IBLOCK_ID' => $this->arResult['IBLOCK_ID']
                    );
                    /** @noinspection PhpDeprecationInspection */
                    \CSaleViewedProduct::Add($fields);
                }

                $_SESSION['VIEWED_PRODUCT'] = $this->arResult['ID'];
            }

            if ($this->arParams['SET_VIEWED_IN_COMPONENT'] === 'Y' && !empty($this->arResult['VIEWED_PRODUCT']))
            {
                if (Loader::includeModule('catalog') && Loader::includeModule('sale'))
                {
                    if ((string)Main\Config\Option::get('catalog', 'enable_viewed_products') !== 'N')
                    {
                        Catalog\CatalogViewedProductTable::refresh(
                            $this->arResult['VIEWED_PRODUCT']['OFFER_ID'],
                            \CSaleBasket::GetBasketUserID(),
                            $this->getSiteId(),
                            $this->arResult['VIEWED_PRODUCT']['PRODUCT_ID']
                        );
                    }
                }
            }
        }
    }

    /**
     * Save bigdata analytics for catalog.element only.
     *
     * @return void
     */
    protected function sendCounters()
    {
        parent::sendCounters();
        if (isset($this->arResult['counterData']) && Main\Analytics\Catalog::isOn())
        {
            Main\Analytics\Counter::sendData('ct', $this->arResult['counterData']);
        }
    }
}
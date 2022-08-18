<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 * @var array $arResult
 * @var array $arParams
 */


//pre($arResult['ORIGINAL_PARAMETERS']['LINK_IBLOCK_ID']);

// Проверяем наличие офферов
if ($arResult['PRODUCT']['USE_OFFERS']) {

    // Формируем список свойств
    $offersProperties = array_diff($arResult['ORIGINAL_PARAMETERS']['OFFERS_FIELD_CODE'],['']);
    $offerPropertyList = [];
    foreach ($offersProperties as $offerProperty) {
        $offerPropertyList[] = 'PROPERTY_' . $offerProperty;
    }
    $dbProperties = CIBlockProperty::GetList([],
        [
            'IBLOCK_ID' => $arResult['ORIGINAL_PARAMETERS']['LINK_IBLOCK_ID'],
            'PROPERTY_TYPE' => 'L'
        ]
    );
    while ($arProperty = $dbProperties->GetNext()) {
        if (in_array($arProperty['CODE'], $offersProperties)) {
            $arResult['PRODUCT_OFFERS_PROPERTY'][$arProperty['CODE']] = $arProperty;
        }
    }

    // Формируем список id торговых предложений
    // Формируем список ссылок для покупки
    $offerIDList = [];
    $add2Basket = [];
    $price = [];
    foreach ($arResult['OFFERS'] as $offer) {
        $offerIDList[] = $offer['ID'];
        $add2Basket[$offer['ID']] = $offer['ADD_URL'];
        $price[$offer['ID']] = $offer['PRICES'][$arParams['PRICE_CODE'][0]]['PRINT_VALUE'];
    }

    $dbOffers = CIBlockElement::GetList(
        [],
        ['ID' => $offerIDList],
        false,
        false,
        array_merge($offerPropertyList,[
            'ID',
            'NAME',
            'AVAILABLE'
        ])
    );
    while($arOffer = $dbOffers->GetNext())
    {
        $properties = [];
        foreach ($offersProperties as $offerProperty) {
            $properties[$offerProperty] = $arOffer['PROPERTY_'.$offerProperty.'_VALUE'];
        }

        $arResult['PRODUCT_OFFERS'][] = [
            'ID' => $arOffer['ID'],
            'NAME' => $arOffer['NAME'],
            'AVAILABLE' => $arOffer['AVAILABLE'],
            'ADD_URL' => $add2Basket[$arOffer['ID']],
            'PRICE' => $price[$arOffer['ID']],
            'PROPERTIES' => $properties
        ];
    }
    pre($arResult['PRODUCT_OFFERS']);
}

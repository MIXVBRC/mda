<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 * @var array $arResult
 * @var array $arParams
 */

$userShop = \MDA\Medusa\MultiShop::getUserShop();

$item = [];
foreach($arResult["ITEMS"] as $key => &$arItem) {
    $arItem['PROPERTIES']['WHATSAPP']['VALUE_PREG'] = preg_replace("/[^,.0-9]/", '', $arItem['PROPERTIES']['WHATSAPP']['VALUE']);
    $arItem['PROPERTIES']['MAP']['VALUE'] = htmlspecialchars_decode($arItem['PROPERTIES']['MAP']['VALUE']);
    if ($userShop['XML_ID'] == $arItem['PROPERTIES']['SHOP']['VALUE']) {
        $item = $arItem;
        unset($arResult["ITEMS"][$key]);
    }
}
if ($item) {
    array_unshift($arResult["ITEMS"], $item);
}


<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 * @var array $arResult
 * @var array $arParams
 */

foreach($arResult["ITEMS"] as &$arItem) {
    $arItem['PROPERTIES']['WHATSAPP']['VALUE_PREG'] = preg_replace("/[^,.0-9]/", '', $arItem['PROPERTIES']['WHATSAPP']['VALUE']);
    $arItem['PROPERTIES']['MAP']['VALUE'] = htmlspecialchars_decode($arItem['PROPERTIES']['MAP']['VALUE']);
}



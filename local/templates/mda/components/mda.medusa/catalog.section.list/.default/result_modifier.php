<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

foreach ($arResult['SECTIONS'] as $key => $arSection) {
    if ($arSection['ELEMENT_CNT'] <= 0) {
        unset($arResult['SECTIONS'][$key]);
    }
}
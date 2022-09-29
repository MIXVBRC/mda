<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 * @var array $arResult
 * @var array $arParams
 */

// Вывод изображений справа
if ($arParams['IMAGE'] > 0) {
    $item = \Bitrix\Iblock\ElementTable::getList([
        'select' => ['PREVIEW_PICTURE'],
        'filter' => [
            'ID' => $arParams['IMAGE'],
            'ACTIVE' => 'Y'
        ],
    ])->fetch()['PREVIEW_PICTURE'];
    $arResult['IMAGE'] = CFile::GetPath($item);
}

$sectionList = [];
foreach ($arResult['SECTIONS'] as $arSection) {

    if (!$arSection['UF_RECOMMEND']) continue;

    if (($arParams['ELEMENT_COUNT'] -= 1) < 0) break;

    $sectionList[] = $arSection;
}
$arResult['SECTIONS'] = $sectionList;




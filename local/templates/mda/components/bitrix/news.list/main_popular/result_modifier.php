<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 * @var array $arResult
 * @var array $arParams
 */


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

$itemList = [];
foreach ($arResult['ITEMS'] as $item) {

    if ($item['PROPERTIES']['POPULAR']['VALUE_XML_ID'] !== 'Y') continue;

    if (--$arParams['NEWS_COUNT'] < 0) break;

    $itemList[] = $item;
}
$arResult['ITEMS'] = $itemList;

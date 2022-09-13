<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var array $arParams
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */


$sectionKeyCode = [];
foreach ($arResult as $key => $section) {
    $pageList = array_diff(explode('/', $section['LINK']), ['']);
    if (count($pageList) > 1) continue;
    $code = array_shift($pageList);
    $sectionKeyCode[$code] = $key;
}

\Bitrix\Main\Loader::includeModule('iblock');

$iBlockList = \Bitrix\Iblock\IblockTable::getList([
    'filter' => [
        'CODE' => $arParams['IBLOCK_SECTIONS'],
        'ACTIVE' => 'Y'
    ],
    'select' => ['ID', 'CODE']
])->fetchAll();

$iBlockCodeList = [];
$iBlockIDList = [];
foreach ($iBlockList as $iBlock) {
    $iBlockIDList[] = $iBlock['ID'];
    $iBlockCodeList[$iBlock['ID']] = $iBlock['CODE'];
}

$sectionList = \Bitrix\Iblock\SectionTable::getList([
    'filter' => [
        'IBLOCK_ID' => $iBlockIDList,
        'ACTIVE' => 'Y'
    ],
    'select' => [
        'ID',
        'CODE',
        'NAME',
        'LEFT_MARGIN',
        'RIGHT_MARGIN',
        'DEPTH_LEVEL',
        'IBLOCK_ID',
        'SECTION_PAGE_URL_RAW' => 'IBLOCK.SECTION_PAGE_URL'
    ],
    'order' => ['LEFT_MARGIN' => 'DESC']
])->fetchAll();

$sectionIBlockList = [];
foreach ($sectionList as &$section) {
    $section['LINK'] = '/' . $iBlockCodeList[$section['IBLOCK_ID']] . \CIBlock::ReplaceDetailUrl($section['SECTION_PAGE_URL_RAW'], $section, true, 'S');
    unset($section['SECTION_PAGE_URL_RAW']);
    $sectionIBlockList[$iBlockCodeList[$section['IBLOCK_ID']]][] = $section;
}

foreach ($sectionIBlockList as &$iBlockSectionList) {
    $unset = [];
    foreach ($iBlockSectionList as $key => &$section) {

        if ($section['DEPTH_LEVEL'] > 1) {
            $unset[] = $key;
        }

        if ($section['LEFT_MARGIN'] + 1 >= $section['RIGHT_MARGIN']) continue;

        foreach ($iBlockSectionList as &$subsection) {
            if ($subsection['DEPTH_LEVEL'] != $section['DEPTH_LEVEL'] + 1) continue;
            if ($subsection['LEFT_MARGIN'] > $section['RIGHT_MARGIN']) continue;

            $section['SECTIONS'][] = $subsection;
        }

    }

    foreach ($unset as $key) {
        unset($iBlockSectionList[$key]);
    }
}

foreach ($sectionIBlockList as $key => $sections) {
    $arResult[$sectionKeyCode[$key]]['SECTIONS'] = $sections;
}

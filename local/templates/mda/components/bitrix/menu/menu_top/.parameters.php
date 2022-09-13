<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arCurrentValues */

if (!\Bitrix\Main\Loader::includeModule('iblock')) return;

$IBLOCK_SECTIONS = [];
$iBlockList = \Bitrix\Iblock\IblockTable::getList([
    'filter' => [
        'ACTIVE' => 'Y'
    ],
    'select' => ['ID', 'CODE', 'NAME']
])->fetchAll();
foreach ($iBlockList as $iBlock) {
    $IBLOCK_SECTIONS[$iBlock['CODE']] = "[{$iBlock['ID']}] {$iBlock['NAME']} ({$iBlock['CODE']})";
}

$arTemplateParameters['IBLOCK_SECTIONS'] = [
    'PARENT' => 'BASE',
    'NAME' => 'Выводить разделы из инфоблоков',
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'VALUES' => $IBLOCK_SECTIONS,
    'DEFAULT' => '',
];
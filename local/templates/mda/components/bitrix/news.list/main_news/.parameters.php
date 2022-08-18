<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!\Bitrix\Main\Loader::includeModule('iblock'))
    return;

$arValues = [
    '0' => 'Нет'
];
$itemList = \Bitrix\Iblock\ElementTable::getList([
    'select' => ['ID', 'NAME', 'DETAIL_PICTURE'],
    'filter' => [
        'IBLOCK_ID' => 8,
    ],
])->fetchAll();
foreach ($itemList as $item) {
    $arValues[$item['ID']] = '['.$item['ID'].'] '.$item['NAME'];
}

$arTemplateParameters['IMAGE'] = array(
    'PARENT' => 'ADDITIONAL_SETTINGS',
    'NAME' => 'Картинка',
    'TYPE' => 'LIST',
    'MULTIPLE' => 'N',
    'VALUES' => $arValues,
);
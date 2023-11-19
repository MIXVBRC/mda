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
        'IBLOCK_ID' => MDA_IBLOCK_ID_IMAGES,
    ],
])->fetchAll();
foreach ($itemList as $item) {
    $arValues[$item['ID']] = '['.$item['ID'].'] '.$item['NAME'];
}

$arTemplateParameters['IMAGE'] = [
    'PARENT' => 'ADDITIONAL_SETTINGS',
    'NAME' => 'Картинка',
    'TYPE' => 'LIST',
    'MULTIPLE' => 'N',
    'VALUES' => $arValues,
];
$arTemplateParameters['ELEMENT_COUNT'] = [
    'PARENT' => 'ADDITIONAL_SETTINGS',
    'NAME' => 'Количество выводимых элементов',
    'TYPE' => 'STRING',
    'MULTIPLE' => 'N',
    'VALUE' => '4',
];
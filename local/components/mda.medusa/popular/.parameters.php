<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arCurrentValues */

use Bitrix\Main\UserConsent\Agreement;

$query = \Bitrix\Iblock\IblockTable::query();
$query->setSelect([
    'ID',
    'NAME',
    'CODE',
]);
$iblocks = [];
foreach ($query->fetchAll() as $iblock) {
    $iblocks[$iblock['ID']] = "[{$iblock['ID']}] {$iblock['NAME']} ({$iblock['CODE']})";
}

$images = [
    '0' => 'Нет'
];
$itemList = \Bitrix\Iblock\ElementTable::getList([
    'select' => ['ID', 'NAME', 'DETAIL_PICTURE'],
    'filter' => [
        'IBLOCK_ID' => MDA_IBLOCK_ID_IMAGES,
    ],
])->fetchAll();
foreach ($itemList as $item) {
    $images[$item['ID']] = '['.$item['ID'].'] '.$item['NAME'];
}

$arComponentParameters = [
    'GROUPS' => [
        'ADDITIONAL' => [
            'NAME' => 'Дополнительные параметры',
            'SORT' => 200
        ],
    ],
    'PARAMETERS' => [
        'IBLOCK_ID' => [
            'PARENT' => 'BASE',
            'NAME' => 'Инфоблок',
            'TYPE' => 'LIST',
            'VALUES' => $iblocks,
            'MULTIPLE' => 'N',
            'DEFAULT' => '',
            'REFRESH' => 'Y',
            'SORT' => 100,
        ],
        'LIMIT' => [
            'PARENT' => 'ADDITIONAL',
            'NAME' => 'Макксимальное количество элементов',
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            'DEFAULT' => 4,
            'SORT' => 300,
        ],
        'TITLE' => [
            'PARENT' => 'ADDITIONAL',
            'NAME' => 'Название заголовка',
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            'DEFAULT' => 'Популярное',
            'SORT' => 400,
        ],
        'IMAGE' => [
            'PARENT' => 'ADDITIONAL',
            'NAME' => 'Картинка справа',
            'TYPE' => 'LIST',
            'MULTIPLE' => 'N',
            'VALUES' => $images,
            'SORT' => 500,
        ],
        'CACHE_TIME' => [],
    ],
];

$properties = [];
if (!empty($arCurrentValues['IBLOCK_ID'])) {
    $query = \Bitrix\Iblock\PropertyTable::query();
    $query->setFilter([
        'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID']
    ]);
    $query->setSelect([
        'NAME',
        'CODE',
    ]);
    foreach ($query->fetchAll() as $property) {
        $properties[$property['CODE']] = $property['NAME'];
    }

    $arComponentParameters['PARAMETERS']['POPULAR_FIELD'] = [
        'PARENT' => 'BASE',
        'NAME' => 'Свойство',
        'TYPE' => 'LIST',
        'VALUES' => $properties,
        'MULTIPLE' => 'N',
        'DEFAULT' => '',
        'SORT' => 200,
    ];
}
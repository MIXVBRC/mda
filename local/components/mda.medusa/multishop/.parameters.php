<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = [
	'GROUPS' => [
        'DATA' => [
            'NAME' => 'Источний данных',
        ],
        'PROPERTIES' => [
            'NAME' => 'Свойства',
        ],
	],
	'PARAMETERS' => [

        // SETTINGS
        'PRODUCTS_FILTER_NAME' => [
            'PARENT' => 'PROPERTIES',
            'NAME' => 'Название фильтра товаров',
            'TYPE' => 'STRING',
            'DEFAULT' => 'multiShopProducts',
        ],

        'SECTIONS_FILTER_NAME' => [
            'PARENT' => 'PROPERTIES',
            'NAME' => 'Название фильтра разделов',
            'TYPE' => 'STRING',
            'DEFAULT' => 'multiShopSections',
        ],

        'COOKIE_NAME' => [
            'PARENT' => 'PROPERTIES',
            'NAME' => 'Название cookie',
            'TYPE' => 'STRING',
            'DEFAULT' => 'MDA_MULTI_SHOP',
        ],

//        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
    ],
];
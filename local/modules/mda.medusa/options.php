<?php

/** @global CMain $APPLICATION */

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

// получаем идентификатор модуля
$request = HttpApplication::getInstance()->getContext()->getRequest();
$module_id = htmlspecialchars($request['mid'] != '' ? $request['mid'] : $request['id']);

// подключаем наш модуль
Loader::includeModule($module_id);

CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');
$iBlockList = [
    0 => 'Не выбрано'
];
$iBlockTable = \Bitrix\Iblock\IblockTable::getList([
    'select' => ['ID','CODE','NAME'],
])->fetchAll();
foreach ($iBlockTable as $iBlock) {
    $iBlockList[$iBlock['ID']] = '['.$iBlock['ID'].'] '.$iBlock['NAME'];
}
$iBlockList[0] = 'Не выбрано';
ksort($iBlockList);

$hlBlocks = [
    0 => 'Не выбрано'
];
$hlBlockTable = HighloadBlockTable::getList([
    'select' => ['ID', 'NAME'],
])->fetchAll();
foreach ($hlBlockTable as $hlBlock) {
    $hlBlocks[$hlBlock['ID']] = '['.$hlBlock['ID'].'] '.$hlBlock['NAME'];
}
ksort($hlBlocks);

// Параметры модуля со значениями по умолчанию
$aTabs = array(

    [ // Multi Shop
        'DIV'     => 'multishop',
        'TAB'     => Loc::getMessage('MDA_MEDUSA_OPTIONS_MULTI_SHOP_TAB_NAME'),
        'TITLE'   => Loc::getMessage('MDA_MEDUSA_OPTIONS_MULTI_SHOP_TAB_NAME'),
        'OPTIONS' => [
            [
                'product_iblock_id',
                Loc::getMessage('MDA_MEDUSA_OPTIONS_MULTI_SHOP_OPTION_PRODUCT_IBLOCK_ID'),
                '0',
                [
                    'selectbox',
                    $iBlockList
                ]
            ],
            [
                'offer_iblock_id',
                Loc::getMessage('MDA_MEDUSA_OPTIONS_MULTI_SHOP_OPTION_OFFER_IBLOCK_ID'),
                '0',
                [
                    'selectbox',
                    $iBlockList
                ]
            ],
            [
                'shop_hl_block_id',
                Loc::getMessage('MDA_MEDUSA_OPTIONS_MULTI_SHOP_OPTION_SHOP_HL_BLOCK_ID'),
                '0',
                [
                    'selectbox',
                    $hlBlocks
                ]
            ],
            [
                'stock_hl_block_id',
                Loc::getMessage('MDA_MEDUSA_OPTIONS_MULTI_SHOP_OPTION_STOCK_HL_BLOCK_ID'),
                '0',
                [
                    'selectbox',
                    $hlBlocks
                ]
            ],
            [
                'elements_filter_name',
                Loc::getMessage('MDA_MEDUSA_OPTIONS_MULTI_SHOP_OPTION_ELEMENTS_FILTER_NAME'),
                'multiShopProducts',
                ['text', 32]
            ],
            [
                'sections_filter_name',
                Loc::getMessage('MDA_MEDUSA_OPTIONS_MULTI_SHOP_OPTION_SECTIONS_FILTER_NAME'),
                'multiShopSections',
                ['text', 32]
            ],
            [
                'user_data_lifetime',
                Loc::getMessage('MDA_MEDUSA_OPTIONS_MULTI_SHOP_OPTION_USER_DATA_LIFETIME'),
                '84600',
                ['text', 32]
            ],
        ]
    ],

);

// Создаем форму для редактирвания параметров модуля
$tabControl = new CAdminTabControl(
    'tabControl',
    $aTabs
);

$tabControl->begin();
?>
    <form action="<?= $APPLICATION->getCurPage(); ?>?mid=<?=$module_id; ?>&lang=<?= LANGUAGE_ID; ?>" method="post">
        <?= bitrix_sessid_post(); ?>
        <?php
        foreach ($aTabs as $aTab) { // цикл по вкладкам
            if ($aTab['OPTIONS']) {
                $tabControl->beginNextTab();
                __AdmSettingsDrawList($module_id, $aTab['OPTIONS']);
            }
        }
        $tabControl->buttons();
        ?>
        <input type="submit" name="apply" value="<?= Loc::GetMessage('MDA_MEDUSA_OPTIONS_INPUT_APPLY'); ?>" class="adm-btn-save" />
        <input type="submit" name="default" value="<?= Loc::GetMessage('MDA_MEDUSA_OPTIONS_INPUT_DEFAULT'); ?>" />
    </form>

<?php
$tabControl->end();

// Обрабатываем данные после отправки формы
if ($request->isPost() && check_bitrix_sessid()) {

    foreach ($aTabs as $aTab) { // цикл по вкладкам
        foreach ($aTab['OPTIONS'] as $arOption) {
            if (!is_array($arOption)) { // если это название секции
                continue;
            }
            if ($arOption['note']) { // если это примечание
                continue;
            }
            if ($request['apply']) { // сохраняем введенные настройки
                $optionValue = $request->getPost($arOption[0]);
                if ($arOption[0] == 'user_data_lifetime') {
                    $optionValue = (int) $optionValue;
                    if ($optionValue <= 0) {
                        $optionValue = 1;
                    }
                }
                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(',', $optionValue) : $optionValue);
            } else if ($request['default']) { // устанавливаем по умолчанию
                Option::set($module_id, $arOption[0], $arOption[2]);
            }
        }
    }

    LocalRedirect($APPLICATION->getCurPage().'?mid='.$module_id.'&lang='.LANGUAGE_ID);

}
?>
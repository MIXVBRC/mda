<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $paymentChangeData
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

use Bitrix\Main,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");

CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);
?>

<? if (!empty($arResult['ERRORS']['FATAL'])): ?>

    <?
    /*
	foreach($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}
    */
    ?>
    <?
    $component = $this->__component;
    if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
        $APPLICATION->AuthForm('', false, false, 'N', false);
    }
    ?>

<? else: ?>

    <div class="order-list">

        <?
        if (!empty($arResult['ERRORS']['NONFATAL'])):
            foreach ($arResult['ERRORS']['NONFATAL'] as $error):
                ShowError($error);
            endforeach;
        endif;
        ?>

        <div class="order-list__top-headers">

            <?/** Отмененных заказов нет */?>
            <?/** История заказов отсутствует */?>
            <?/** Текущие заказы не найдены */?>
            <?if (!count($arResult['ORDERS'])): ?>
                <? if ($_REQUEST["filter_history"] == 'Y'): ?>
                    <? if ($_REQUEST["show_canceled"] == 'Y'): ?>
                        <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER') ?></h3>
                    <? else: ?>
                        <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST') ?></h3>
                    <? endif; ?>
                <? else: ?>
                    <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST') ?></h3>
                <? endif; ?>
            <? endif; ?>

        </div>

        <?
        $nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
        $clearFromLink = array("filter_history", "filter_status", "show_all", "show_canceled");
        ?>

        <div class="order-list__top-buttons">

            <?/** Посмотреть историю заказов */?>
            <?if ($nothing || $_REQUEST["filter_history"] == 'N'):?>
                <a class="button back-button"
                   href="<?= $APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false) ?>">
                    <?= Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY") ?>
                </a>
            <?endif;?>

            <?/** Посмотреть текущие заказы */?>
            <?/** Посмотреть историю заказов */?>
            <?/** Посмотреть историю отмененных заказов */?>
            <? if ($_REQUEST["filter_history"] == 'Y'): ?>
                <a class="button back-button"
                   href="<?= $APPLICATION->GetCurPageParam("", $clearFromLink, false) ?>">
                    <?= Loc::getMessage("SPOL_TPL_CUR_ORDERS") ?>
                </a>
                <? if ($_REQUEST["show_canceled"] == 'Y'): ?>
                    <a class="button back-button"
                       href="<?= $APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false) ?>">
                        <?= Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY") ?>
                    </a>
                <? else: ?>
                    <a class="button back-button"
                       href="<?= $APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false) ?>">
                        <?= Loc::getMessage("SPOL_TPL_VIEW_ORDERS_CANCELED") ?>
                    </a>
                <? endif;?>
            <? endif; ?>

            <?/** Перейти в каталог */?>
            <?if (!count($arResult['ORDERS'])):?>
                <a class="button back-button"
                   href="<?= htmlspecialcharsbx($arParams['PATH_TO_CATALOG']) ?>">
                    <?= Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG') ?>
                </a>
            <?endif;?>

        </div>


        <? require __DIR__ . '/include/list.php'; ?>

        <?/*

        <? if ($_REQUEST["filter_history"] !== 'Y'): ?>

            <? require __DIR__ . '/include/list.php'; ?>

        <? else: ?>

            <?$orderHeaderStatus = null;?>
            <?if ($_REQUEST["show_canceled"] === 'Y' && count($arResult['ORDERS'])):?>
                <h1 class="sale-order-title">
                    <?= Loc::getMessage('SPOL_TPL_ORDERS_CANCELED_HEADER') ?>
                </h1>
            <?endif;?>

            <?foreach ($arResult['ORDERS'] as $key => $order):?>

                <?if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $_REQUEST["show_canceled"] !== 'Y'):?>

                    <?$orderHeaderStatus = $order['ORDER']['STATUS_ID']; ?>

                    <h1 class="sale-order-title">
                        <?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?>
                        &laquo;<?= htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']) ?>&raquo;
                    </h1>

                <?endif;?>

                <div class="col-md-12 col-sm-12 sale-order-list-container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 sale-order-list-accomplished-title-container">
                            <div class="row">
                                <div class="col-md-8 col-sm-12 sale-order-list-accomplished-title-container">
                                    <h2 class="sale-order-list-accomplished-title">
                                        <?= Loc::getMessage('SPOL_TPL_ORDER') ?>
                                        <?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') ?>
                                        <?= htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']) ?>
                                        <?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
                                        <?= $order['ORDER']['DATE_INSERT'] ?>,
                                        <?= count($order['BASKET_ITEMS']); ?>
                                        <?
                                        $count = mb_substr(count($order['BASKET_ITEMS']), -1);
                                        if ($count == '1') {
                                            echo Loc::getMessage('SPOL_TPL_GOOD');
                                        } elseif ($count >= '2' || $count <= '4') {
                                            echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
                                        } else {
                                            echo Loc::getMessage('SPOL_TPL_GOODS');
                                        }
                                        ?>
                                        <?= Loc::getMessage('SPOL_TPL_SUMOF') ?>
                                        <?= $order['ORDER']['FORMATED_PRICE'] ?>
                                    </h2>
                                </div>
                                <div class="col-md-4 col-sm-12 sale-order-list-accomplished-date-container">
                                    <? if ($_REQUEST["show_canceled"] !== 'Y'):?>
                                        <span class="sale-order-list-accomplished-date">
                                            <?= Loc::getMessage('SPOL_TPL_ORDER_FINISHED') ?>
                                        </span>
                                    <?else:?>
                                        <span class="sale-order-list-accomplished-date canceled-order">
                                            <?= Loc::getMessage('SPOL_TPL_ORDER_CANCELED') ?>
                                        </span>
                                    <?endif;?>
                                    <span class="sale-order-list-accomplished-date-number"><?= $order['ORDER']['DATE_STATUS_FORMATED'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 sale-order-list-inner-accomplished">
                            <div class="row sale-order-list-inner-row">
                                <div class="col-md-3 col-sm-12 sale-order-list-about-accomplished">
                                    <a class="sale-order-list-about-link"
                                       href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"]) ?>">
                                        <?= Loc::getMessage('SPOL_TPL_MORE_ON_ORDER') ?>
                                    </a>
                                </div>
                                <div class="col-md-3 col-md-offset-6 col-sm-12 sale-order-list-repeat-accomplished">
                                    <a class="sale-order-list-repeat-link sale-order-link-accomplished"
                                       href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"]) ?>">
                                        <?= Loc::getMessage('SPOL_TPL_REPEAT_ORDER') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?endforeach?>

        <? endif ?>

        */?>

        <div class="clearfix"></div>

        <?= $arResult["NAV_STRING"];?>

        <? if ($_REQUEST["filter_history"] !== 'Y'): ?>
            <?
            $javascriptParams = array(
                "url" => CUtil::JSEscape($this->__component->GetPath() . '/ajax.php'),
                "templateFolder" => CUtil::JSEscape($templateFolder),
                "templateName" => $this->__component->GetTemplateName(),
                "paymentList" => $paymentChangeData,
                "returnUrl" => CUtil::JSEscape($arResult["RETURN_URL"]),
            );
            $javascriptParams = CUtil::PhpToJSObject($javascriptParams);
            ?>
            <script>
                BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
            </script>
        <? endif; ?>

    </div>

<? endif; ?>

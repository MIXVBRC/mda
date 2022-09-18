<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

if ($arParams['GUEST_MODE'] !== 'Y')
{
	Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
	Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
}
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");

/**
 * clipboard - копирование при нажатии на иконку
 * fx - подгрузка платежных систем в "Сменить способ оплаты"
 */
CJSCore::Init(array('clipboard', 'fx'));

$APPLICATION->SetTitle(Loc::getMessage('SPOD_LIST_MY_ORDER', [
    '#ACCOUNT_NUMBER#' => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
    '#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"]
]));

if (!empty($arResult['ERRORS']['FATAL'])) {

	foreach ($arResult['ERRORS']['FATAL'] as $error) {
		ShowError($error);
	}

	$component = $this->__component;

	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}
} else {

    /** Ошибки */
	if (!empty($arResult['ERRORS']['NONFATAL'])) {
		foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
			ShowError($error);
		}
	}
?>
    <div class="order-detail">

        <?/** Навигаторы */?>
        <? if ($arParams['GUEST_MODE'] !== 'Y'):?>
            <a class="button back-button" href="<?= htmlspecialcharsbx($arResult["URL_TO_LIST"]) ?>"><?= Loc::getMessage('SPOD_RETURN_LIST_ORDERS') ?></a>
        <?endif;?>

        <?/** Тело */?>
        <div class="order-detail__body">

            <?/** Подзаголовок */?>
            <div class="order-detail__item">
                <div class="order-detail__title">
                    <h2>
                        <?= Loc::getMessage('SPOD_SUB_ORDER_TITLE', array(
                            "#ACCOUNT_NUMBER#"=> htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
                            "#DATE_ORDER_CREATE#"=> $arResult["DATE_INSERT_FORMATED"]
                        ))?>

                        <?= count($arResult['BASKET']);?>

                        <?
                        $count = count($arResult['BASKET']) % 10;
                        if ($count == '1') {
                            echo Loc::getMessage('SPOD_TPL_GOOD');
                        } else if ($count >= '2' && $count <= '4') {
                            echo Loc::getMessage('SPOD_TPL_TWO_GOODS');
                        } else {
                            echo Loc::getMessage('SPOD_TPL_GOODS');
                        }
                        ?>

                        <?=Loc::getMessage('SPOD_TPL_SUMOF')?>

                        <?=$arResult["PRICE_FORMATED"]?>
                    </h2>
                </div>
            </div>

            <?/** Информация о заказе */?>
            <div class="order-detail__item">

                <?/** Заголовок */?>
                <div class="order-detail__title"><h3><?= Loc::getMessage('SPOD_LIST_ORDER_INFO') ?></h3></div>

                <div class="order-detail__item-body">

                    <div class="order-detail__item-info">
                        <table class="order-detail__item-table">

                            <?/** ФИО */?>
                            <tr class="order-detail__item-table-tr">
                                <td class="order-detail__item-table-tr-td">
                                    <?
                                    $userName = $arResult["USER_NAME"];
                                    if (mb_strlen($userName) || mb_strlen($arResult['FIO'])) {
                                        echo Loc::getMessage('SPOD_LIST_FIO').':';
                                    } else {
                                        echo Loc::getMessage('SPOD_LOGIN').':';
                                    }
                                    ?>
                                </td>
                                <td class="order-detail__item-table-tr-td">
                                    <?
                                    if($userName <> '') {
                                        echo htmlspecialcharsbx($userName);
                                    } elseif(mb_strlen($arResult['FIO'])) {
                                        echo htmlspecialcharsbx($arResult['FIO']);
                                    } else {
                                        echo htmlspecialcharsbx($arResult["USER"]['LOGIN']);
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?/** Статус заказа */?>
                            <tr class="order-detail__item-table-tr">
                                <td class="order-detail__item-table-tr-td">
                                    <?= Loc::getMessage('SPOD_LIST_CURRENT_STATUS_DATE', array(
                                        '#DATE_STATUS#' => $arResult["DATE_STATUS_FORMATED"]
                                    )) ?>
                                </td>
                                <td class="order-detail__item-table-tr-td">
                                    <?
                                    if ($arResult['CANCELED'] !== 'Y') {
                                        echo htmlspecialcharsbx($arResult["STATUS"]["NAME"]);
                                    } else {
                                        echo Loc::getMessage('SPOD_ORDER_CANCELED');
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?/** Сумма заказа */?>
                            <tr class="order-detail__item-table-tr">
                                <td class="order-detail__item-table-tr-td">
                                    <?= Loc::getMessage('SPOD_ORDER_PRICE')?>:
                                </td>
                                <td class="order-detail__item-table-tr-td">
                                    <?= $arResult["PRICE_FORMATED"]?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <?/** Информация о пользователе */?>
                    <div class="order-detail__item-show order-detail__info-box" style="display: none">

                        <div class="order-detail__item-title"><?= Loc::getMessage('SPOD_USER_INFORMATION') ?></div>

                        <table class="order-detail__item-table">

                            <?/** Логин */?>
                            <? if (mb_strlen($arResult["USER"]["LOGIN"]) && !in_array("LOGIN", $arParams['HIDE_USER_INFO'])):?>
                                <tr class="order-detail__item-table-tr">
                                    <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_LOGIN')?>:</td>
                                    <td class="order-detail__item-table-tr-td"><?= htmlspecialcharsbx($arResult["USER"]["LOGIN"]) ?></td>
                                </tr>
                            <?endif;?>

                            <?/** E-mail */?>
                            <?if (mb_strlen($arResult["USER"]["EMAIL"]) && !in_array("EMAIL", $arParams['HIDE_USER_INFO'])):?>
                                <tr class="order-detail__item-table-tr">
                                    <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_EMAIL')?>:</td>
                                    <td class="order-detail__item-table-tr-td">
                                        <a class="order-detail__link" href="mailto:<?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?>"><?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?></a>
                                    </td>
                                </tr>
                            <?endif;?>

                            <?/** Тип плательщика */?>
                            <?if (mb_strlen($arResult["USER"]["PERSON_TYPE_NAME"]) && !in_array("PERSON_TYPE_NAME", $arParams['HIDE_USER_INFO'])):?>
                                <tr class="order-detail__item-table-tr">
                                    <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_PERSON_TYPE_NAME') ?>:</td>
                                    <td class="order-detail__item-table-tr-td"><?= htmlspecialcharsbx($arResult["USER"]["PERSON_TYPE_NAME"]) ?></td>
                                </tr>
                            <?endif;?>

                            <?/** Свойства заказа */?>
                            <?if (isset($arResult["ORDER_PROPS"])):?>
                                <?foreach ($arResult["ORDER_PROPS"] as $property):?>
                                    <tr class="order-detail__item-table-tr">
                                        <?/** Название свойства */?>
                                        <td class="order-detail__item-table-tr-td"><?= htmlspecialcharsbx($property['NAME']) ?>:</td>

                                        <?/** Значение свойства */?>
                                        <td class="order-detail__item-table-tr-td">
                                            <?
                                            if ($property["TYPE"] == "Y/N") {
                                                echo Loc::getMessage('SPOD_' . ($property["VALUE"] == "Y" ? 'YES' : 'NO'));
                                            } else {
                                                if ($property['MULTIPLE'] == 'Y' && $property['TYPE'] !== 'FILE' && $property['TYPE'] !== 'LOCATION') {
                                                    $propertyList = unserialize($property["VALUE"], ['allowed_classes' => false]);
                                                    foreach ($propertyList as $propertyElement) {
                                                        echo $propertyElement . '</br>';
                                                    }
                                                } else if ($property['TYPE'] == 'FILE') {
                                                    echo $property["VALUE"];
                                                } else {
                                                    echo htmlspecialcharsbx($property["VALUE"]);
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?endforeach;?>
                            <?endif;?>

                            <?/** Комментарии к заказу */?>
                            <?if($arResult["USER_DESCRIPTION"] <> ''):?>
                                <tr class="order-detail__item-table-tr">
                                    <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_ORDER_DESC') ?>:</td>
                                    <td class="order-detail__item-table-tr-td"><?= nl2br(htmlspecialcharsbx($arResult["USER_DESCRIPTION"])) ?></td>
                                </tr>
                            <?endif;?>

                        </table>

                    </div>

                    <div class="order-detail__item-buttons">

                        <?/** Повторить заказ */?>
                        <a class="button__success" data-button href="<?=$arResult["URL_TO_COPY"]?>"><?= Loc::getMessage('SPOD_ORDER_REPEAT') ?></a>

                        <?/** Отменить заказ */?>
                        <a class="button__error" data-button href="<?=$arResult["URL_TO_CANCEL"]?>"><?= Loc::getMessage('SPOD_ORDER_CANCEL') ?></a>

                        <?/** Подробнее */?>
                        <a class="button__medium order-detail__info-show" data-button href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_MORE') ?></a>
                        <a class="button__medium order-detail__info-hide" style="display: none" data-button href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_LESS') ?></a>

                    </div>

                </div>
            </div>

            <?/** Параметры оплаты */?>
            <div class="order-detail__item">

                <div class="order-detail__title"><h3><?= Loc::getMessage('SPOD_ORDER_PAYMENT') ?></h3></div>

                <div class="order-detail__item-body">

                    <div class="order-detail__item-info">

                        <?/** Статус заказа */?>
                        <div class="order-detail__item-title">
                            <?= Loc::getMessage('SPOD_SUB_ORDER_TITLE', array(
                                "#ACCOUNT_NUMBER#"=> htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
                                "#DATE_ORDER_CREATE#"=> $arResult["DATE_INSERT_FORMATED"]
                            ))?>
                            <?
                            if ($arResult['CANCELED'] !== 'Y')
                            {
                                echo htmlspecialcharsbx($arResult["STATUS"]["NAME"]);
                            }
                            else
                            {
                                echo Loc::getMessage('SPOD_ORDER_CANCELED');
                            }
                            ?>
                        </div>

                        <table class="order-detail__item-table">
                            <?/** Сумма заказа */?>
                            <tr class="order-detail__item-table-tr">
                                <td class="order-detail__item-table-tr-td"><?=Loc::getMessage('SPOD_ORDER_PRICE_FULL')?>:</td>
                                <td class="order-detail__item-table-tr-td"><?=$arResult["PRICE_FORMATED"]?></td>
                            </tr>

                            <?/** Если заказ оплачен частично */?>
                            <?if (!empty($arResult["SUM_REST"]) && !empty($arResult["SUM_PAID"])):?>

                                <?/** Оплачено */?>
                                <tr class="order-detail__item-table-tr">
                                    <td class="order-detail__item-table-tr-td"><?=Loc::getMessage('SPOD_ORDER_SUM_PAID')?>:</td>
                                    <td class="order-detail__item-table-tr-td"><?=$arResult["SUM_PAID_FORMATED"]?></td>
                                </tr>

                                <?/** Сумма к оплате */?>
                                <tr class="order-detail__item-table-tr">
                                    <td class="order-detail__item-table-tr-td"><?=Loc::getMessage('SPOD_ORDER_SUM_REST')?>:</td>
                                    <td class="order-detail__item-table-tr-td"><?=$arResult["SUM_REST_FORMATED"]?></td>
                                </tr>

                            <?endif;?>

                        </table>

                        <?foreach ($arResult['PAYMENT'] as $payment):?>
                            <?/** Данные для JS */?>
                            <?
                            $paymentData[$payment['ACCOUNT_NUMBER']] = [
                                "payment" => $payment['ACCOUNT_NUMBER'],
                                "order" => $arResult['ACCOUNT_NUMBER'],
                                "allow_inner" => $arParams['ALLOW_INNER'],
                                "only_inner_full" => $arParams['ONLY_INNER_FULL'],
                                "refresh_prices" => $arParams['REFRESH_PRICES'],
                                "path_to_payment" => $arParams['PATH_TO_PAYMENT']
                            ];
                            ?>
                            <div class="order-detail__item-detail order-detail__payment-item">

                                <div class="order-detail__item-detail-body order-detail__payment-info">
                                    <?/** Картинка оплаты */?>
                                    <div class="order-detail__item-detail-image">
                                        <img src="<?= $payment['PAY_SYSTEM']["SRC_LOGOTIP"] <> ''? htmlspecialcharsbx($payment['PAY_SYSTEM']["SRC_LOGOTIP"]) : '/bitrix/images/sale/nopaysystem.gif'?>" alt="payment_image">
                                    </div>

                                    <div class="order-detail__item-detail-info">

                                        <?/** Название оплаты */?>
                                        <div class="order-detail__item-title">
                                            <?
                                            $paymentSubTitle = Loc::getMessage('SPOD_TPL_BILL')." ".Loc::getMessage('SPOD_NUM_SIGN').$payment['ACCOUNT_NUMBER'];
                                            if(isset($payment['DATE_BILL'])) {
                                                $paymentSubTitle .= " ".Loc::getMessage('SPOD_FROM')." ".$payment['DATE_BILL_FORMATED'];
                                            }
                                            $paymentSubTitle .= ", ";
                                            $paymentSubTitle = htmlspecialcharsbx($paymentSubTitle);
                                            $paymentSubTitle .= $payment['PAY_SYSTEM_NAME'];
                                            if ($payment['PAID'] === 'Y') {
                                                $paymentSubTitle .= '<span class="order-detail__payment-success">'.Loc::getMessage('SPOD_PAYMENT_PAID').'</span>';
                                            } elseif ($arResult['IS_ALLOW_PAY'] == 'N') {
                                                $paymentSubTitle .= '<span class="order-detail__payment-medium">'.Loc::getMessage('SPOD_TPL_RESTRICTED_PAID').'</span>';
                                            } else {
                                                $paymentSubTitle .= '<span class="order-detail__payment-error">'.Loc::getMessage('SPOD_PAYMENT_UNPAID').'</span>';
                                            }
                                            echo $paymentSubTitle;
                                            ?>
                                        </div>

                                        <table class="order-detail__item-table">

                                            <?/** Сумма к оплате по счету */?>
                                            <tr class="order-detail__item-table-tr">
                                                <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_ORDER_PRICE_BILL')?>:</td>
                                                <td class="order-detail__item-table-tr-td"><?=$payment['PRICE_FORMATED']?></td>
                                            </tr>

                                            <?/** Список чеков */?>
                                            <?if (!empty($payment['CHECK_DATA'])):?>
                                                <?
                                                $listCheckLinks = "";
                                                foreach ($payment['CHECK_DATA'] as $checkInfo) {
                                                    $title = Loc::getMessage('SPOD_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID']))." - ". htmlspecialcharsbx($checkInfo['TYPE_NAME']);
                                                    if ($checkInfo['LINK'] <> '') {
                                                        $link = $checkInfo['LINK'];
                                                        $listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
                                                    }
                                                }
                                                ?>

                                                <?if ($listCheckLinks <> ''):?>
                                                    <tr class="order-detail__item-table-tr">
                                                        <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_CHECK_TITLE')?>:</td>
                                                        <td class="order-detail__item-table-tr-td"><?=$listCheckLinks?></td>
                                                    </tr>
                                                <?endif;?>
                                            <?endif;?>

                                        </table>

                                        <?/** Обратите внимание: оплата заказа будет доступна после подтверждения менеджером */?>
                                        <?if ($arResult['IS_ALLOW_PAY'] === 'N' && $payment['PAID'] !== 'Y'):?>
                                            <div class="order-detail__item-title">
                                                <?=Loc::getMessage('SOPD_TPL_RESTRICTED_PAID_MESSAGE')?>
                                            </div>
                                        <?endif;?>
                                    </div>
                                </div>

                                <?/** Контейнер с оплатой при нажатии "Оплатить" */?>
                                <?if (
                                    $payment["PAID"] !== "Y"
                                    && $payment['PAY_SYSTEM']["IS_CASH"] !== "Y"
                                    && $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash'
                                    && $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y'
                                    && $arResult['CANCELED'] !== 'Y'
                                    && $arResult["IS_ALLOW_PAY"] !== "N"
                                ):?>

                                    <div class="order-detail__item-show order-detail__payment-box"><?=$payment['BUFFERED_OUTPUT']?></div>

                                <?endif;?>

                                <div class="order-detail__item-buttons order-detail__payment-buttons">

                                    <?/** Кнопка платить */?>
                                    <?if ($payment['PAY_SYSTEM']['IS_CASH'] !== 'Y' && $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash'):?>

                                        <?/** В новом окне */?>
                                        <?if ($payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] === 'Y' && $arResult["IS_ALLOW_PAY"] !== "N"):?>
                                            <a class="button__success order-detail__payment-pay"
                                               target="_blank"
                                               href="<?=htmlspecialcharsbx($payment['PAY_SYSTEM']['PSA_ACTION_FILE'])?>">
                                                <?= Loc::getMessage('SPOD_ORDER_PAY') ?>
                                            </a>
                                        <?else:?>

                                            <?/** Неактивная */?>
                                            <?if ($payment["PAID"] === "Y" || $arResult["CANCELED"] === "Y" || $arResult["IS_ALLOW_PAY"] === "N"):?>
                                                <a class="button__success" href="javascript:void(0);"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>

                                                <?/** Не в новом окне */?>
                                            <?else:?>
                                                <a class="button__success order-detail__payment-pay" href="javascript:void(0);"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>
                                            <?endif;?>
                                        <?endif;?>
                                    <?endif;?>

                                    <?/** Сменить способ оплаты" */?>
                                    <?/* if (
                                        $payment['PAID'] !== 'Y'
                                        && $arResult['CANCELED'] !== 'Y'
                                        && $arParams['GUEST_MODE'] !== 'Y'
                                        && $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'
                                    ):?>
                                        <a class="button__medium order-detail__payment-change" id="<?=$payment['ACCOUNT_NUMBER']?>" href="javascript:void(0);"><?=Loc::getMessage('SPOD_CHANGE_PAYMENT_TYPE')?></a>
                                    <?endif;*/?>

                                    <?/** Назад */?>
                                    <?/*
                                    <a class="button__error order-detail__payment-back" style="display: none;" href="javascript:void(0);"><?=Loc::getMessage('SPOD_CANCEL_PAYMENT')?></a>
                                    */?>

                                    <?/** Отменить оплату */?>
                                    <a class="button__error order-detail__payment-cancel" href="javascript:void(0);"><?=Loc::getMessage('SPOD_CANCEL_PAY')?></a>
                                </div>

                            </div>

                        <?endforeach;?>

                    </div>
                </div>
            </div>

            <?/** Параметры отгрузки */?>
            <?if (count($arResult['SHIPMENT'])):?>
                <div class="order-detail__item">

                    <?/** Заголовок */?>
                    <div class="order-detail__title"><h3><?= Loc::getMessage('SPOD_ORDER_SHIPMENT') ?></h3></div>

                    <div class="order-detail__item-body">

                        <?foreach ($arResult['SHIPMENT'] as $shipment):?>
                            <div class="order-detail__item-info order-detail__shipment-item">

                                <?/** Отгрузка №0 от 00.00.0000, стоимость доставки 0.00 ₽ */?>
                                <div class="order-detail__item-title">
                                    <?
                                    //change date
                                    if ($shipment['PRICE_DELIVERY_FORMATED'] == '') {
                                        $shipment['PRICE_DELIVERY_FORMATED'] = 0;
                                    }
                                    $shipmentRow = Loc::getMessage('SPOD_SUB_ORDER_SHIPMENT')." ".Loc::getMessage('SPOD_NUM_SIGN').$shipment["ACCOUNT_NUMBER"];
                                    if ($shipment["DATE_DEDUCTED"]) {
                                        $shipmentRow .= " ".Loc::getMessage('SPOD_FROM')." ".$shipment["DATE_DEDUCTED_FORMATED"];
                                    }
                                    $shipmentRow = htmlspecialcharsbx($shipmentRow);
                                    $shipmentRow .= ", ".Loc::getMessage('SPOD_SUB_PRICE_DELIVERY', array(
                                            '#PRICE_DELIVERY#' => $shipment['PRICE_DELIVERY_FORMATED']
                                        ));
                                    echo $shipmentRow;
                                    ?>
                                </div>

                                <div class="order-detail__item-detail">
                                    <div class="order-detail__item-detail-body">

                                        <?/** Изображение */?>
                                        <?if($shipment['DELIVERY']["SRC_LOGOTIP"] <> ''):?>
                                            <div class="order-detail__item-detail-image">
                                                <img src="<?= htmlspecialcharsbx($shipment['DELIVERY']["SRC_LOGOTIP"]) ?>" alt="shipment__image">
                                            </div>
                                        <?endif;?>

                                        <div class="order-detail__item-detail-info">

                                        <table class="order-detail__item-table">

                                            <?/** Служба доставки */?>
                                            <?if($shipment["DELIVERY_NAME"] <> ''):?>
                                                <tr class="order-detail__item-table-tr">
                                                    <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_ORDER_DELIVERY') ?>:</td>
                                                    <td class="order-detail__item-table-tr-td"><?= htmlspecialcharsbx($shipment["DELIVERY_NAME"]) ?></td>
                                                </tr>
                                            <?endif;?>

                                            <?/** Статус отгрузки */?>
                                            <tr class="order-detail__item-table-tr">
                                                <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_ORDER_SHIPMENT_STATUS')?>:</td>
                                                <td class="order-detail__item-table-tr-td"><?= htmlspecialcharsbx($shipment['STATUS_NAME'])?></td>
                                            </tr>

                                            <?/** Идентификатор отправления */?>
                                            <?if($shipment['TRACKING_NUMBER'] <> ''):?>
                                                <tr class="order-detail__item-table-tr">
                                                    <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER') ?>:</td>
                                                    <td class="order-detail__item-table-tr-td"><span class="order-detail__copy-box"><?=htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?></span><i class="order-detail__copy fa fa-copy"></i></td>
                                                </tr>
                                            <?endif;?>

                                            <!-- TEST -->
                                            <tr class="order-detail__item-table-tr">
                                                <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER') ?>:</td>
                                                <td class="order-detail__item-table-tr-td"><span class="order-detail__copy-box">1235467890</span><i class="order-detail__copy fa fa-copy"></i></td>
                                            </tr>

                                        </table>

                                    </div>

                                    </div>
                                </div>

                                <div class="order-detail__item-show order-detail__shipment-box" style="display: none;">
                                    <div class="order-detail__item-show-body">

                                        <?/** Склад самовывоза */?>
                                        <? $store = $arResult['DELIVERY']['STORE_LIST'][$shipment['STORE_ID']];?>
                                        <?if (isset($store)):?>
                                            <div class="order-detail__item-show-head">

                                                <?/** Склад самовывоза */?>
                                                <div class="order-detail__item-title"><?= Loc::getMessage('SPOD_SHIPMENT_STORE')?></div>

                                                <?/** Адрес */?>
                                                <?if($store['ADDRESS'] <> ''):?>
                                                    <table class="order-detail__item-table">
                                                        <tr class="order-detail__item-table-tr">
                                                            <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_STORE_ADDRESS') ?>:</td>
                                                            <td class="order-detail__item-table-tr-td"><?= htmlspecialcharsbx($store['ADDRESS']) ?></td>
                                                        </tr>
                                                    </table>
                                                <?endif;?>

                                            </div>
                                        <?endif;?>

                                        <div class="order-detail__item-show-products">
                                            <div class="order-detail__item-title"><?= Loc::getMessage('SPOD_ORDER_SHIPMENT_BASKET')?></div>
                                            <table class="order-detail__item-table order-detail__item-table-width">
                                                <tr class="order-detail__item-table-tr">

                                                    <?/** Наименование */?>
                                                    <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_NAME')?></td>

                                                    <?/** Количество */?>
                                                    <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_QUANTITY')?></td>
                                                </tr>

                                                <? foreach ($shipment['ITEMS'] as $item):?>
                                                    <?$basketItem = $arResult['BASKET'][$item['BASKET_ID']];?>
                                                    <tr class="order-detail__item-table-tr">
                                                        <td class="order-detail__item-table-tr-td">
                                                            <a class="order-detail__item-table-tr-td-product" href="<?=htmlspecialcharsbx($basketItem['DETAIL_PAGE_URL'])?>">
                                                                <?/** Картинка */?>
                                                                <div class="order-detail__item-table-tr-td-product-image">
                                                                    <?
                                                                    if($basketItem['PICTURE']['SRC'] <> '') {
                                                                        $imageSrc = htmlspecialcharsbx($basketItem['PICTURE']['SRC']);
                                                                    } else {
                                                                        $imageSrc = $this->GetFolder().'/images/no_photo.png';
                                                                    }
                                                                    ?>
                                                                    <img src="<?=$imageSrc?>" alt="product_image">
                                                                </div>

                                                                <div class="order-detail__item-table-tr-td-product-info">
                                                                    <?/** Название товара */?>
                                                                    <div class="order-detail__item-table-tr-td-product-title"><?=htmlspecialcharsbx($basketItem['NAME'])?></div>

                                                                    <?/** Свойства товара */?>
                                                                    <? if (isset($basketItem['PROPS']) && is_array($basketItem['PROPS'])):?>

                                                                        <?foreach ($basketItem['PROPS'] as $itemProps):?>
                                                                            <div class="order-detail__item-table-tr-td-product-property">
                                                                                <?= htmlspecialcharsbx($itemProps['NAME'] . ': ' . $itemProps['VALUE']) ?>
                                                                            </div>
                                                                        <?endforeach;?>
                                                                    <?endif;?>

                                                                </div>
                                                            </a>
                                                        </td>
                                                        <?/** Количество товара */?>
                                                        <td class="order-detail__item-table-tr-td"><?=$item['QUANTITY']?>&nbsp;<?=htmlspecialcharsbx($item['MEASURE_NAME'])?></td>
                                                    </tr>
                                                <?endforeach;?>

                                            </table>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        <?endforeach;?>

                        <div class="order-detail__item-buttons">

                            <?/** Проверить отправление */?>
                            <?if($shipment['TRACKING_URL'] <> ''):?>
                                <a class="button__medium" href="<?= $shipment['TRACKING_URL'] ?>"><?= Loc::getMessage('SPOD_ORDER_CHECK_TRACKING') ?></a>
                            <?endif;?>

                            <?/** Показать все / Свернуть */?>
                            <a class="button__medium order-detail__shipment-show" href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_SHOW_ALL')?></a>
                            <a class="button__medium order-detail__shipment-hide" style="display: none;" href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_LESS')?></a>

                        </div>

                    </div>
                </div>
            <?endif;?>

            <?/** Содержимое заказа */?>
            <div class="order-detail__item order-detail__item-product">

                <?/** Заголовок */?>
                <div class="order-detail__title"><h3><?= Loc::getMessage('SPOD_ORDER_BASKET')?></h3></div>

                <div class="order-detail__item-body">

                    <div class="order-detail__item-info ">

                        <table class="order-detail__item-table order-detail__item-table-width">
                            <tr class="order-detail__item-table-tr">

                                <?/** Наименование */?>
                                <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_NAME')?></td>

                                <?/** Цена */?>
                                <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_PRICE')?></td>

                                <?/** Скидка */?>
                                <? if($arResult["SHOW_DISCOUNT_TAB"] <> ''):?>
                                    <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_DISCOUNT') ?></td>
                                <?endif;?>

                                <?/** Количество */?>
                                <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_QUANTITY')?></td>

                                <?/** Сумма */?>
                                <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_ORDER_PRICE')?></td>

                            </tr>

                            <?/** Список товаров */?>
                            <? foreach ($arResult['BASKET'] as $basketItem):?>
                                <tr class="order-detail__item-table-tr">

                                    <?/** Информация о товаре */?>
                                    <td class="order-detail__item-table-tr-td">
                                        <a class="order-detail__item-table-tr-td-product" href="<?=$basketItem['DETAIL_PAGE_URL']?>">
                                            <?/** Изображение товара */?>
                                            <div class="order-detail__item-table-tr-td-product-image">
                                                <?
                                                if($basketItem['PICTURE']['SRC'] <> '') {
                                                    $imageSrc = $basketItem['PICTURE']['SRC'];
                                                } else {
                                                    $imageSrc = $this->GetFolder().'/images/no_photo.png';
                                                }
                                                ?>
                                                <img src="<?=$imageSrc?>" alt="product_image">
                                            </div>
                                            <div class="order-detail__item-table-tr-td-product-info">

                                                <?/** Название товара */?>
                                                <div class="order-detail__item-table-tr-td-product-title"><?=htmlspecialcharsbx($basketItem['NAME'])?></div>

                                                <?/** Свойства товара */?>
                                                <? if (isset($basketItem['PROPS']) && is_array($basketItem['PROPS'])):?>
                                                    <?foreach ($basketItem['PROPS'] as $itemProps):?>
                                                        <div class="order-detail__item-table-tr-td-product-property">
                                                            <?=htmlspecialcharsbx($itemProps['NAME']) . ': ' . htmlspecialcharsbx($itemProps['VALUE'])?>
                                                        </div>
                                                    <?endforeach;?>
                                                <?endif;?>

                                            </div>

                                        </a>
                                    </td>

                                    <?/** Цена товара */?>
                                    <td class="order-detail__item-table-tr-td"><?=$basketItem['BASE_PRICE_FORMATED']?></td>

                                    <?/** Скидка */?>
                                    <? if($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"] <> ''):?>
                                        <td class="order-detail__item-table-tr-td"><?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></td>
                                    <? elseif(mb_strlen($arResult["SHOW_DISCOUNT_TAB"])):?>
                                        <td class="order-detail__item-table-tr-td"></td>
                                    <?endif;?>

                                    <?/** Количество */?>
                                    <td class="order-detail__item-table-tr-td">
                                        <?
                                        if($basketItem['MEASURE_NAME'] <> '') {
                                            echo $basketItem['QUANTITY'] . ' ' . htmlspecialcharsbx($basketItem['MEASURE_NAME']);
                                        } else {
                                            echo $basketItem['QUANTITY'] . ' ' . Loc::getMessage('SPOD_DEFAULT_MEASURE');
                                        }
                                        ?>
                                    </td>

                                    <?/** Сумма */?>
                                    <td class="order-detail__item-table-tr-td"><?=$basketItem['FORMATED_SUM']?></td>

                                </tr>
                            <?endforeach;?>

                        </table>

                    </div>

                </div>
            </div>

            <?/** Итого */?>
            <div class="order-detail__item">

                <div class="order-detail__item-body">

                    <div class="order-detail__item-info">

                        <div class="order-detail__item-total">
                            <div class="order-detail__item-total-list">

                                <?/** Общий вес */?>
                                <? if (floatval($arResult["ORDER_WEIGHT"])): ?>
                                    <div class="order-detail__item-total-item">
                                        <div class="order-detail__item-total-item-td"><?= Loc::getMessage('SPOD_TOTAL_WEIGHT')?>:</div>
                                        <div class="order-detail__item-total-item-td"><?= $arResult['ORDER_WEIGHT_FORMATED'] ?></div>
                                    </div>
                                <?endif;?>

                                <?/** Товар на */?>
                                <?if ($arResult['PRODUCT_SUM_FORMATED'] != $arResult['PRICE_FORMATED'] && !empty($arResult['PRODUCT_SUM_FORMATED'])):?>
                                    <div class="order-detail__item-total-item">
                                        <div class="order-detail__item-total-item-td"><?= Loc::getMessage('SPOD_COMMON_SUM')?>:</div>
                                        <div class="order-detail__item-total-item-td"><?=$arResult['PRODUCT_SUM_FORMATED']?></div>
                                    </div>
                                <?endif;?>

                                <?/** Стоимость доставки */?>
                                <?if($arResult["PRICE_DELIVERY_FORMATED"] <> ''):?>
                                    <div class="order-detail__item-total-item">
                                        <div class="order-detail__item-total-item-td"><?= Loc::getMessage('SPOD_DELIVERY') ?>:</div>
                                        <div class="order-detail__item-total-item-td"><?= $arResult["PRICE_DELIVERY_FORMATED"] ?></div>
                                    </div>
                                <?endif;?>

                                <?/** НДС */?>
                                <?if ((float)$arResult["TAX_VALUE"] > 0):?>
                                    <div class="order-detail__item-total-item">
                                        <div class="order-detail__item-total-item-td"><?= Loc::getMessage('SPOD_TAX') ?>:</div>
                                        <div class="order-detail__item-total-item-td"><?= $arResult["TAX_VALUE_FORMATED"] ?></div>
                                    </div>
                                <?endif;?>

                                <?/** Итого */?>
                                <div class="order-detail__item-total-item">
                                    <div class="order-detail__item-total-item-td"><?= Loc::getMessage('SPOD_SUMMARY')?>:</div>
                                    <div class="order-detail__item-total-item-td"><?=$arResult['PRICE_FORMATED']?></div>
                                </div>

                            </div>

                        </div>



                    </div>

                </div>
            </div>

        </div>

        <?/** Навигаторы */?>
        <? if ($arParams['GUEST_MODE'] !== 'Y'):?>
            <a class="button back-button" href="<?= htmlspecialcharsbx($arResult["URL_TO_LIST"]) ?>"><?= Loc::getMessage('SPOD_RETURN_LIST_ORDERS') ?></a>
        <?endif;?>
    </div>


	<?
	$javascriptParams = array(
		"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
		"templateFolder" => CUtil::JSEscape($templateFolder),
		"templateName" => $this->__component->GetTemplateName(),
		"paymentList" => $paymentData,
		"returnUrl" => $arResult['RETURN_URL'],
	);
	$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>
	<script>
		BX.Sale.PersonalOrderComponent.PersonalOrderDetail.init(<?=$javascriptParams?>);
	</script>




<?
}
?>


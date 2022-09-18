<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

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

                    <div class="order-detail__item-detail-body">
                        <?/** Картинка оплаты */?>
                        <div class="order-detail__item-detail-image">
                            <img class="order-detail__payment-image" src="<?= $payment['PAY_SYSTEM']["SRC_LOGOTIP"] <> ''? htmlspecialcharsbx($payment['PAY_SYSTEM']["SRC_LOGOTIP"]) : '/bitrix/images/sale/nopaysystem.gif'?>" alt="payment_image">
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

                    <?/** Контейнер "Сменить способ оплаты" */?>
                    <?/*
                                <div class="order-detail__payment-info"></div>
                                */?>

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

                    <?if ($payment['PAID'] !== 'Y'):?>
                        <div class="order-detail__item-buttons order-detail__payment-buttons">

                            <?//pre($payment)?>
                            <?/** Кнопка оплатить */?>
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
                            <a class="button__error order-detail__payment-back" style="display: none;" href="javascript:void(0);"><?=Loc::getMessage('SPOD_CANCEL_PAYMENT')?></a>

                            <?/** Отменить оплату */?>
                            <a class="button__error order-detail__payment-cancel" href="javascript:void(0);"><?=Loc::getMessage('SPOD_CANCEL_PAY')?></a>
                        </div>
                    <?endif;?>

                </div>

            <?endforeach;?>

        </div>
    </div>
</div>


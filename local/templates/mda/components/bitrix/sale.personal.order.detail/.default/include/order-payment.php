<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>
<div class="order-detail__item" data-item data-hide>

    <div class="order-detail__item-header">
        <div class="order-detail__item-header-title"><h3><?= Loc::getMessage('SPOD_ORDER_PAYMENT') ?></h3></div>
        <span class="order-detail__item-header-arrow" data-opener></span>
    </div>

    <div class="order-detail__item-body" data-opener-box>

         <ul class="order-detail__item-list">

            <?/** Сумма заказа */?>
            <li>
                <span><?=Loc::getMessage('SPOD_ORDER_PRICE_FULL')?>:</span>
                <span></span>
                <span><?=$arResult["PRICE_FORMATED"]?></span>
            </li>

            <?/** Если заказ оплачен частично */?>
            <?if (!empty($arResult["SUM_REST"]) && !empty($arResult["SUM_PAID"])):?>

                <?/** Оплачено */?>
                <li>
                    <span><?=Loc::getMessage('SPOD_ORDER_SUM_PAID')?>:</span>
                    <span></span>
                    <span><?=$arResult["SUM_PAID_FORMATED"]?></span>
                </li>

                <?/** Сумма к оплате */?>
                <li>
                    <span><?=Loc::getMessage('SPOD_ORDER_SUM_REST')?>:</span>
                    <span></span>
                    <span><?=$arResult["SUM_REST_FORMATED"]?></span>
                </li>

            <?endif;?>

        </ul>


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

            <div class="order-detail__item-body-element payment-item">
                <div class="order-detail__item-text">

                    <?/** Название оплаты */?>
                    <div class="order-detail__item-title">
                        <?
                        $paymentSubTitle = Loc::getMessage('SPOD_TPL_BILL')." ".Loc::getMessage('SPOD_NUM_SIGN').$payment['ACCOUNT_NUMBER'];
                        if(isset($payment['DATE_BILL'])) {
                            $paymentSubTitle .= " ".Loc::getMessage('SPOD_FROM')." ".$payment['DATE_BILL_FORMATED'];
                        }
                        echo htmlspecialcharsbx($paymentSubTitle) . ", " . $payment['PAY_SYSTEM_NAME'];
                        ?>
                    </div>

                </div>

                <?/** Обратите внимание: оплата заказа будет доступна после подтверждения менеджером */?>
                <?if ($arResult['IS_ALLOW_PAY'] === 'N' && $payment['PAID'] !== 'Y'):?>
                    <div class="order-detail__item-text">
                        <?=Loc::getMessage('SOPD_TPL_RESTRICTED_PAID_MESSAGE')?>
                    </div>
                <?endif;?>

                <?/** Список чеков */?>
                <?/*if (!empty($payment['CHECK_DATA'])):?>
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
                        <tr>
                            <td><?= Loc::getMessage('SPOD_CHECK_TITLE')?>:</td>
                            <td><?=$listCheckLinks?></td>
                        </tr>
                    <?endif;?>
                <?endif;*/?>

                <ul class="order-detail__item-list">
                    <?/** Сумма к оплате по счету */?>
                    <li>
                        <span><?= Loc::getMessage('SPOD_ORDER_PRICE_BILL')?> <?=$payment['PRICE_FORMATED']?></span>
                        <span></span>
                        <span class="order-detail__item-<?=($payment['PAID']==='Y')?'success':'error'?>">
                            <?if ($payment['PAID'] === 'Y') {
                                echo Loc::getMessage('SPOD_PAYMENT_PAID');
                            } elseif ($arResult['IS_ALLOW_PAY'] == 'N') {
                                echo Loc::getMessage('SPOD_TPL_RESTRICTED_PAID');
                            } else {
                                echo Loc::getMessage('SPOD_PAYMENT_UNPAID');
                            }
                            ?>
                        </span>
                    </li>
                </ul>

                <?/** Контейнер "Сменить способ оплаты" */?>
                <div class="order-detail__item-text payment-change-box"></div>

                <?/** Контейнер с оплатой при нажатии "Оплатить" */?>
                <div class="order-detail__item-text payment-pay-box">
                    <?if (
                        $payment["PAID"] !== "Y"
                        && $payment['PAY_SYSTEM']["IS_CASH"] !== "Y"
                        && $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash'
                        && $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y'
                        && $arResult['CANCELED'] !== 'Y'
                        && $arResult["IS_ALLOW_PAY"] !== "N"
                    ):?>
                        <?=$payment['BUFFERED_OUTPUT']?>
                    <?endif;?>
                </div>

                <?if ($payment['PAID'] !== 'Y'):?>
                    <?/** Кнопка оплатить */?>
                    <?if ($payment['PAY_SYSTEM']['IS_CASH'] !== 'Y' && $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash'):?>

                        <?/** В новом окне */?>
                        <?if ($payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] === 'Y' && $arResult["IS_ALLOW_PAY"] !== "N"):?>
                            <a class="button payment-pay"
                               target="_blank"
                               href="<?=htmlspecialcharsbx($payment['PAY_SYSTEM']['PSA_ACTION_FILE'])?>">
                                <?= Loc::getMessage('SPOD_ORDER_PAY') ?>
                            </a>
                        <?else:?>

                            <?/** Неактивная */?>
                            <?if ($payment["PAID"] === "Y" || $arResult["CANCELED"] === "Y" || $arResult["IS_ALLOW_PAY"] === "N"):?>
                                <a class="button" href="javascript:void(0);"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>

                            <?/** Не в новом окне */?>
                            <?else:?>
                                <a class="button payment-pay" href="javascript:void(0);"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>
                            <?endif;?>
                        <?endif;?>
                    <?endif;?>

                    <?/** Сменить способ оплаты" */?>
                    <?/*if ($payment['PAID'] !== 'Y' && $arResult['CANCELED'] !== 'Y' && $arParams['GUEST_MODE'] !== 'Y' && $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'):?>
                        <a class="button payment-change" id="<?=$payment['ACCOUNT_NUMBER']?>" href="javascript:void(0);"><?=Loc::getMessage('SPOD_CHANGE_PAYMENT_TYPE')?></a>
                    <?endif;*/?>

                    <?/** Назад */?>
                    <a class="button payment-back" href="javascript:void(0);"><?=Loc::getMessage('SPOD_CANCEL_PAYMENT')?></a>

                    <?/** Отменить оплату */?>
                    <a class="button payment-cancel" href="javascript:void(0);"><?=Loc::getMessage('SPOD_CANCEL_PAY')?></a>
                <?endif;?>
            </div>

        <?endforeach;?>

    </div>
</div>

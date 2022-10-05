<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<?
$paymentChangeData = array();
$orderHeaderStatus = null;
?>


    <div class="order-list__body">

        <div class="order-list__status-list">

        <? foreach ($arResult['ORDERS'] as $key => $order):?>

            <?/** Статус - заголовок */?>
            <? if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS'):?>

                <?$orderHeaderStatus = $order['ORDER']['STATUS_ID'];?>

                <div class="order-list__status-header order-list__success-back">
                    <h2 class="order-list__status-header-title">
                        <?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?>
                        &laquo;<?= htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']) ?>&raquo;
                    </h2>
                </div>

            <? endif; ?>

            <div class="order-list__status">

                <div class="order-list__status-body">

                    <div class="order-list__status-item">

                            <?/** Заказ - заголовок */?>
                            <h3 class="order-list__status-item-title">
                                <?= Loc::getMessage('SPOL_TPL_ORDER') ?>
                                <?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') . $order['ORDER']['ACCOUNT_NUMBER'] ?>
                                <?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
                                <?= $order['ORDER']['DATE_INSERT_FORMATED'] ?>,
                                <?= count($order['BASKET_ITEMS']); ?>
                                <?
                                $count = count($order['BASKET_ITEMS']) % 10;
                                if ($count == '1') {
                                    echo Loc::getMessage('SPOL_TPL_GOOD');
                                } elseif ($count >= '2' && $count <= '4') {
                                    echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
                                } else {
                                    echo Loc::getMessage('SPOL_TPL_GOODS');
                                }
                                ?>
                                <?= Loc::getMessage('SPOL_TPL_SUMOF') ?>
                                <?= $order['ORDER']['FORMATED_PRICE'] ?>
                            </h3>

                            <div class="order-list__status-item-body">
                                <div class="order-list__status-item-body-list">

                                    <? foreach ($order['PAYMENT'] as $payment): ?>

                                        <? if ($payment['SUM'] <= 0) continue; ?>

                                        <?
                                        if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y') {
                                            $paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
                                                "order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
                                                "payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
                                                "allow_inner" => $arParams['ALLOW_INNER'],
                                                "refresh_prices" => $arParams['REFRESH_PRICES'],
                                                "path_to_payment" => $arParams['PATH_TO_PAYMENT'],
                                                "only_inner_full" => $arParams['ONLY_INNER_FULL'],
                                                "return_url" => $arResult['RETURN_URL'],
                                            );
                                        }
                                        ?>

                                        <div class="order-list__status-item-body-item" data-payment-reset>

                                            <h4 class="order-list__status-item-body-item-title">
                                                <?
                                                $paymentSubTitle = Loc::getMessage('SPOL_TPL_BILL') . " " . Loc::getMessage('SPOL_TPL_NUMBER_SIGN') . htmlspecialcharsbx($payment['ACCOUNT_NUMBER']);
                                                if (isset($payment['DATE_BILL'])) {
                                                    $paymentSubTitle .= " " . Loc::getMessage('SPOL_TPL_FROM_DATE') . " " . $payment['DATE_BILL_FORMATED'];
                                                }
                                                $paymentSubTitle .= ",";
                                                echo $paymentSubTitle;
                                                ?>
                                                <span><?= $payment['PAY_SYSTEM_NAME'] ?></span>
                                            </h4>

                                            <ul class="order-list__status-item-body-item-list">
                                                <li>
                                                    <span>
                                                        <?= Loc::getMessage('SPOL_TPL_SUM_TO_PAID') . ' ' . $payment['FORMATED_SUM'] ?>
                                                    </span>
                                                    <span></span>
                                                    <?if ($payment['PAID'] === 'Y'):?>
                                                        <span class="order-list__success-text"><?= Loc::getMessage('SPOL_TPL_PAID') ?></span>
                                                    <?elseif ($order['ORDER']['IS_ALLOW_PAY'] == 'N'):?>
                                                        <span><?= Loc::getMessage('SPOL_TPL_RESTRICTED_PAID') ?></span>
                                                    <?else:?>
                                                        <span class="order-list__error-text"><?= Loc::getMessage('SPOL_TPL_NOTPAID') ?></span>
                                                    <?endif;?>
                                                </li>

                                                <?if ($order['ORDER']['IS_ALLOW_PAY'] == 'N' && $payment['PAID'] !== 'Y'):?>
                                                    <li>
                                                        <span><?= Loc::getMessage('SOPL_TPL_RESTRICTED_PAID_MESSAGE') ?></span>
                                                    </li>
                                                <?endif;?>

                                            </ul>

                                            <div data-payment-box>
                                                <div data-payment-body></div>
                                                <a href="javascript:void(0)" class="button" data-payment-cancel><?= Loc::getMessage('SPOL_CANCEL_PAYMENT') ?></a>
                                            </div>

                                            <? if ($order['ORDER']['CANCELED'] !== 'Y'): ?>

                                                <?if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y' && $payment['ACTION_FILE'] !== 'cash'):?>
                                                    <?if ($order['ORDER']['IS_ALLOW_PAY'] == 'N'):?>
                                                        <a href="javascript:void(0)" class="button">
                                                            <?= Loc::getMessage('SPOL_TPL_PAY') ?>
                                                        </a>
                                                    <?elseif ($payment['NEW_WINDOW'] === 'Y'):?>
                                                        <a class="button" target="_blank"
                                                           href="<?= htmlspecialcharsbx($payment['PSA_ACTION_FILE']) ?>">
                                                            <?= Loc::getMessage('SPOL_TPL_PAY') ?>
                                                        </a>
                                                    <?else:?>
                                                        <a class="button ajax_reload" data-payment-button
                                                           href="<?= htmlspecialcharsbx($payment['PSA_ACTION_FILE']) ?>">
                                                            <?= Loc::getMessage('SPOL_TPL_PAY') ?>
                                                        </a>
                                                    <?endif;?>
                                                <?endif;?>

                                                <?if ($payment['PAID'] !== 'Y' && $order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'):?>
                                                    <a href="#" class="button payment_change" data-payment-change
                                                       id="<?= htmlspecialcharsbx($payment['ACCOUNT_NUMBER']) ?>">
                                                        <?= Loc::getMessage('SPOL_TPL_CHANGE_PAY_TYPE') ?>
                                                    </a>
                                                <?endif;?>

                                            <? endif; ?>

                                        </div>

                                    <?endforeach;?>

                                    <? foreach ($order['SHIPMENT'] as $shipment): ?>

                                        <?if (empty($shipment)) continue;?>

                                        <div class="order-list__status-item-body-item">
                                            <h4 class="order-list__status-item-body-item-title">
                                                <?= Loc::getMessage('SPOL_TPL_LOAD') ?>
                                                <?
                                                $shipmentSubTitle = Loc::getMessage('SPOL_TPL_NUMBER_SIGN') . htmlspecialcharsbx($shipment['ACCOUNT_NUMBER']);
                                                if ($shipment['DATE_DEDUCTED']) {
                                                    $shipmentSubTitle .= " " . Loc::getMessage('SPOL_TPL_FROM_DATE') . " " . $shipment['DATE_DEDUCTED_FORMATED'];
                                                }
                                                ?>
                                                <?=$shipmentSubTitle?>
                                            </h4>

                                            <?/** Отгружено / Не отгружено */?>
                                            <?/*
                                            <?if ($shipment['DEDUCTED'] == 'Y'):?>
                                                <?= Loc::getMessage('SPOL_TPL_LOADED'); ?>
                                            <?else:?>
                                                <?= Loc::getMessage('SPOL_TPL_NOTLOADED'); ?>
                                            <?endif;?>
                                            */?>

                                            <ul class="order-list__status-item-body-item-list">
                                                <li>
                                                    <span><?= Loc::getMessage('SPOL_ORDER_SHIPMENT_STATUS'); ?></span>
                                                    <span></span>
                                                    <span><?= htmlspecialcharsbx($shipment['DELIVERY_STATUS_NAME']) ?></span>
                                                </li>
                                                <?if (!empty($shipment['DELIVERY_ID'])):?>
                                                    <li>
                                                        <span><?= Loc::getMessage('SPOL_TPL_DELIVERY_SERVICE') ?></span>
                                                        <span></span>
                                                        <span><?= $arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME'] ?></span>
                                                    </li>
                                                <?endif;?>
                                                <?if ($shipment['FORMATED_DELIVERY_PRICE'] && $shipment['PRICE_DELIVERY'] > 0):?>
                                                    <li>
                                                        <span><?= Loc::getMessage('SPOL_TPL_DELIVERY_COST') ?></span>
                                                        <span></span>
                                                        <span><?= $shipment['FORMATED_DELIVERY_PRICE'] ?></span>
                                                    </li>
                                                <?endif;?>

                                                <?/** Идентификатор отправления */?>
                                                <?/*
                                                <?if (!empty($shipment['TRACKING_NUMBER'])):?>
                                                    <div class="sale-order-list-shipment-item">
                                                        <span class="sale-order-list-shipment-id-name"><?= Loc::getMessage('SPOL_TPL_POSTID') ?>:</span>
                                                        <span class="sale-order-list-shipment-id"><?= htmlspecialcharsbx($shipment['TRACKING_NUMBER']) ?></span>
                                                        <span class="sale-order-list-shipment-id-icon"></span>
                                                    </div>
                                                <?endif?>
                                                */?>
                                            </ul>

                                            <?/** Проверить идентификатор отправления */?>
                                            <?/*
                                            <?if ($shipment['TRACKING_URL'] <> ''):?>
                                                <a class="button" target="_blank"
                                                   href="<?= $shipment['TRACKING_URL'] ?>">
                                                    <?= Loc::getMessage('SPOL_TPL_CHECK_POSTID') ?>
                                                </a>
                                            <?endif;?>
                                            */?>
                                        </div>
                                    <?endforeach;?>

                                </div>

                                <a class="button"
                                   href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"]) ?>">
                                    <?= Loc::getMessage('SPOL_TPL_MORE_ON_ORDER') ?>
                                </a>

                                <a class="button"
                                   href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"]) ?>">
                                    <?= Loc::getMessage('SPOL_TPL_REPEAT_ORDER') ?>
                                </a>

                                <?if ($order['ORDER']['CAN_CANCEL'] !== 'N'):?>
                                    <a class="order-list__link"
                                       href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"]) ?>">
                                        <?= Loc::getMessage('SPOL_TPL_CANCEL_ORDER') ?>
                                    </a>
                                <?endif;?>

                            </div>
                        </div>

                </div>
            </div>

        <? endforeach; ?>

        </div>
    </div>


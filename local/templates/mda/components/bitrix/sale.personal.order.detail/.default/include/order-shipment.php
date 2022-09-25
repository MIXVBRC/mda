<?
/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 */

use Bitrix\Main\Localization\Loc;
?>

<?if (count($arResult['SHIPMENT'])):?>

    <div class="order-detail__item" data-item data-close>

        <?/** Заголовок */?>
        <div class="order-detail__item-header">
            <div class="order-detail__item-header-title"><h3><?= Loc::getMessage('SPOD_ORDER_SHIPMENT') ?></h3></div>
            <span class="order-detail__item-header-arrow" data-opener></span>
        </div>

        <div class="order-detail__item-body" data-opener-box>

            <?foreach ($arResult['SHIPMENT'] as $shipment):?>
                <div class="order-detail__item-body-element">

                    <?/** Отгрузка №0 от 00.00.0000, стоимость доставки 0.00 ₽ */?>
                    <div class="order-detail__item-text">
                        <?
                        if ($shipment['PRICE_DELIVERY_FORMATED'] == '') {
                            $shipment['PRICE_DELIVERY_FORMATED'] = 0;
                        }
                        $shipmentRow = Loc::getMessage('SPOD_SUB_ORDER_SHIPMENT')." ".Loc::getMessage('SPOD_NUM_SIGN').$shipment["ACCOUNT_NUMBER"];
                        if ($shipment["DATE_DEDUCTED"]) {
                            $shipmentRow .= " ".Loc::getMessage('SPOD_FROM')." ".$shipment["DATE_DEDUCTED_FORMATED"];
                        }
                        echo $shipmentRow;
                        ?>
                    </div>
                    <div class="order-detail__item-text">
                        <?= Loc::getMessage('SPOD_SUB_PRICE_DELIVERY', array(
                            '#PRICE_DELIVERY#' => ': ' . $shipment['PRICE_DELIVERY_FORMATED']
                        ));?>
                    </div>


                    <ul class="order-detail__item-list">

                        <?/** Служба доставки */?>
                        <?if($shipment["DELIVERY_NAME"] <> ''):?>
                            <li>
                                <span><?= Loc::getMessage('SPOD_ORDER_DELIVERY') ?>:</span>
                                <span></span>
                                <span><?= htmlspecialcharsbx($shipment["DELIVERY_NAME"]) ?></span>
                            </li>
                        <?endif;?>

                        <?/** Статус отгрузки */?>
                        <li>
                            <span><?= Loc::getMessage('SPOD_ORDER_SHIPMENT_STATUS')?>:</span>
                            <span></span>
                            <span><?= htmlspecialcharsbx($shipment['STATUS_NAME'])?></span>
                        </li>

                        <?/** Идентификатор отправления */?>
                        <?if($shipment['TRACKING_NUMBER'] <> ''):?>
                            <li>
                                <span><?= Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER') ?>:</span>
                                <span></span>
                                <span><?=htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?></span>
                            </li>
                        <?endif;?>

                    </ul>

                    <?/*
                    <div class="button">Показать все</div>
                    */?>

                </div>
            <?endforeach;?>

        </div>
    </div>
<?endif;?>



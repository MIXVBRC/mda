<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

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
                                        <td class="order-detail__item-table-tr-td"><span class="order-detail__copy-box"><?=$shipment['ID']?></span><i class="order-detail__copy fa fa-copy"></i></td>
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

                                <table class="order-detail__item-table order-detail__item-table-width mobile-table">

                                    <thead>
                                        <tr class="order-detail__item-table-tr">

                                            <?/** Наименование */?>
                                            <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_NAME')?></td>

                                            <?/** Количество */?>
                                            <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_QUANTITY')?></td>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <? foreach ($shipment['ITEMS'] as $item):?>
                                            <?$basketItem = $arResult['BASKET'][$item['BASKET_ID']];?>
                                            <tr class="order-detail__item-table-tr">
                                                <td class="order-detail__item-table-tr-td" data-label="<?= Loc::getMessage('SPOD_NAME')?>">
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

                                                            <div class="order-detail__item-table-tr-td-product-property">
                                                                <?='Говно' . ': ' . 'Пахнет'?>
                                                            </div>
                                                            <div class="order-detail__item-table-tr-td-product-property">
                                                                <?='ГовноГовно' . ': ' . 'ПахнетПахнет'?>
                                                            </div>
                                                            <div class="order-detail__item-table-tr-td-product-property">
                                                                <?='Говно Говно Говно' . ': ' . 'ПахнетПахнетПахнет'?>
                                                            </div>
                                                            <div class="order-detail__item-table-tr-td-product-property">
                                                                <?='Говно' . ': ' . 'Пахнет Пахнет Пахнет Пахнет'?>
                                                            </div>

                                                        </div>
                                                    </a>
                                                </td>
                                                <?/** Количество товара */?>
                                                <td class="order-detail__item-table-tr-td" data-label="<?= Loc::getMessage('SPOD_QUANTITY')?>"><?=$item['QUANTITY']?>&nbsp;<?=htmlspecialcharsbx($item['MEASURE_NAME'])?></td>
                                            </tr>
                                        <?endforeach;?>
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="order-detail__item-buttons order-detail__shipment-buttons">

                        <?/** Проверить отправление */?>
                        <?if($shipment['TRACKING_URL'] <> ''):?>
                            <a class="button__medium" href="<?= $shipment['TRACKING_URL'] ?>"><?= Loc::getMessage('SPOD_ORDER_CHECK_TRACKING') ?></a>
                        <?endif;?>

                        <?/** Показать все / Свернуть */?>
                        <a class="button__medium order-detail__shipment-show" href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_SHOW_ALL')?></a>
                        <a class="button__medium order-detail__shipment-hide" style="display: none;" href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_LESS')?></a>

                    </div>

                </div>
            <?endforeach;?>



        </div>
    </div>
<?endif;?>

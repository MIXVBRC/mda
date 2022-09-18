<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

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

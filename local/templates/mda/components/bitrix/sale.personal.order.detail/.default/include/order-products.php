<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

<div class="order-detail__item">

    <?/** Заголовок */?>
    <div class="order-detail__item-header">
        <div class="order-detail__item-header-title"><h3><?= Loc::getMessage('SPOD_ORDER_BASKET')?></h3></div>
    </div>

    <div class="order-detail__item-body">
        <table class="order-detail__item-body-table">

            <thead>
                <tr class="order-detail__item-body-table-tr">

                    <?/** Наименование */?>
                    <td class="order-detail__item-body-table-tr-td">
                        <div class="order-detail__item-body-table-tr-td-box">
                            <span><?= Loc::getMessage('SPOD_NAME')?></span>
                        </div>
                    </td>

                    <?/** Цена */?>
                    <td class="order-detail__item-body-table-tr-td">
                        <div class="order-detail__item-body-table-tr-td-box">
                            <span><?= Loc::getMessage('SPOD_PRICE')?></span>
                        </div>
                    </td>

                    <?/** Скидка */?>
                    <? if($arResult["SHOW_DISCOUNT_TAB"] <> ''):?>
                        <td class="order-detail__item-body-table-tr-td">
                            <div class="order-detail__item-body-table-tr-td-box">
                                <span><?= Loc::getMessage('SPOD_DISCOUNT') ?></span>
                            </div>
                        </td>
                    <?endif;?>

                    <?/** Количество */?>
                    <td class="order-detail__item-body-table-tr-td">
                        <div class="order-detail__item-body-table-tr-td-box">
                            <span><?= Loc::getMessage('SPOD_QUANTITY')?></span>
                        </div>
                    </td>

                    <?/** Сумма */?>
                    <td class="order-detail__item-body-table-tr-td">
                        <div class="order-detail__item-body-table-tr-td-box">
                            <span><?= Loc::getMessage('SPOD_ORDER_PRICE')?></span>
                        </div>
                    </td>

                </tr>
            </thead>

            <tbody>

                <?/** Список товаров */?>
                <? foreach ($arResult['BASKET'] as $basketItem):?>
                    <tr class="order-detail__item-body-table-tr">

                        <?/** Информация о товаре */?>
                        <td class="order-detail__item-body-table-tr-td item-name" data-label="<?= Loc::getMessage('SPOD_NAME')?>">
                            <div class="order-detail__item-body-table-tr-td-box">

                                <?/** Изображение товара */?>
                                <?
                                if($basketItem['PICTURE']['SRC'] <> '') {
                                    $imageSrc = $basketItem['PICTURE']['SRC'];
                                } else {
                                    $imageSrc = $this->GetFolder().'/images/no_photo.png';
                                }
                                ?>
                                <img src="<?=$imageSrc?>">

                                <?/** Название товара */?>
                                <span><?=htmlspecialcharsbx($basketItem['NAME'])?></span>

                                <?/** Свойства товара */?>
                                <?/* if (isset($basketItem['PROPS']) && is_array($basketItem['PROPS'])):?>
                                    <?foreach ($basketItem['PROPS'] as $itemProps):?>
                                        <div class="order-detail__item-table-tr-td-product-property">
                                            <?=htmlspecialcharsbx($itemProps['NAME']) . ': ' . htmlspecialcharsbx($itemProps['VALUE'])?>
                                        </div>
                                    <?endforeach;?>
                                <?endif;*/?>
                            </div>
                        </td>

                        <?/** Цена товара */?>
                        <td class="order-detail__item-body-table-tr-td" data-label="<?= Loc::getMessage('SPOD_PRICE')?>">
                            <div class="order-detail__item-body-table-tr-td-box">
                                <span><?=$basketItem['BASE_PRICE_FORMATED']?></span>
                            </div>
                        </td>

                        <?/** Скидка */?>
                        <? if($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"] <> ''):?>
                            <td class="order-detail__item-body-table-tr-td" data-label="<?= Loc::getMessage('SPOD_DISCOUNT') ?>">
                                <div class="order-detail__item-body-table-tr-td-box">
                                    <span><?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></span>
                                </div>
                            </td>
                        <? elseif(mb_strlen($arResult["SHOW_DISCOUNT_TAB"])):?>
                            <td class="order-detail__item-body-table-tr-td" data-label="<?= Loc::getMessage('SPOD_DISCOUNT') ?>">
                                <div class="order-detail__item-body-table-tr-td-box">
                                    <span>-</span>
                                </div>
                            </td>
                        <?endif;?>

                        <?/** Количество */?>
                        <td class="order-detail__item-body-table-tr-td" data-label="<?= Loc::getMessage('SPOD_QUANTITY')?>">
                            <div class="order-detail__item-body-table-tr-td-box">
                                <span>
                                    <?
                                    if($basketItem['MEASURE_NAME'] <> '') {
                                        echo $basketItem['QUANTITY'] . ' ' . htmlspecialcharsbx($basketItem['MEASURE_NAME']);
                                    } else {
                                        echo $basketItem['QUANTITY'] . ' ' . Loc::getMessage('SPOD_DEFAULT_MEASURE');
                                    }
                                    ?>
                                </span>
                            </div>
                        </td>

                        <?/** Сумма */?>
                        <td class="order-detail__item-body-table-tr-td" data-label="<?= Loc::getMessage('SPOD_ORDER_PRICE')?>">
                            <div class="order-detail__item-body-table-tr-td-box">
                                <span><?=$basketItem['FORMATED_SUM']?></span>
                            </div>
                        </td>

                    </tr>
                <?endforeach;?>

            </tbody>

        </table>

    </div>
</div>
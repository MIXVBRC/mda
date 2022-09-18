<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

<div class="order-detail__item order-detail__item-product">

    <?/** Заголовок */?>
    <div class="order-detail__title"><h3><?= Loc::getMessage('SPOD_ORDER_BASKET')?></h3></div>

    <div class="order-detail__item-body">

        <div class="order-detail__item-info">

            <table class="order-detail__item-table order-detail__item-table-width mobile-table">

                <thead>
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
                </thead>

                <tbody>
                    <?/** Список товаров */?>
                    <? foreach ($arResult['BASKET'] as $basketItem):?>
                        <tr class="order-detail__item-table-tr">

                            <?/** Информация о товаре */?>
                            <td class="order-detail__item-table-tr-td" data-label="<?= Loc::getMessage('SPOD_NAME')?>">
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
                            <td class="order-detail__item-table-tr-td" data-label="<?= Loc::getMessage('SPOD_PRICE')?>"><?=$basketItem['BASE_PRICE_FORMATED']?></td>

                            <?/** Скидка */?>
                            <? if($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"] <> ''):?>
                                <td class="order-detail__item-table-tr-td" data-label="<?= Loc::getMessage('SPOD_DISCOUNT') ?>"><?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></td>
                            <? elseif(mb_strlen($arResult["SHOW_DISCOUNT_TAB"])):?>
                                <td class="order-detail__item-table-tr-td" data-label="<?= Loc::getMessage('SPOD_DISCOUNT') ?>">-</td>
                            <?endif;?>

                            <?/** Количество */?>
                            <td class="order-detail__item-table-tr-td" data-label="<?= Loc::getMessage('SPOD_QUANTITY')?>">
                                <?
                                if($basketItem['MEASURE_NAME'] <> '') {
                                    echo $basketItem['QUANTITY'] . ' ' . htmlspecialcharsbx($basketItem['MEASURE_NAME']);
                                } else {
                                    echo $basketItem['QUANTITY'] . ' ' . Loc::getMessage('SPOD_DEFAULT_MEASURE');
                                }
                                ?>
                            </td>

                            <?/** Сумма */?>
                            <td class="order-detail__item-table-tr-td" data-label="<?= Loc::getMessage('SPOD_ORDER_PRICE')?>"><?=$basketItem['FORMATED_SUM']?></td>

                        </tr>
                    <?endforeach;?>
                </tbody>

            </table>

        </div>

    </div>
</div>

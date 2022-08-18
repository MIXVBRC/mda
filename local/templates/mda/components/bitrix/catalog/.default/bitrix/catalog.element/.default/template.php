<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$img = $arResult['DETAIL_PICTURE']['SRC'] ? $arResult['DETAIL_PICTURE']['SRC'] : SITE_TEMPLATE_PATH.'/img/noimg.png';

//pre($arResult['PRODUCT']['USE_OFFERS']);
//pre($arResult);
//pre($arResult['PRODUCT_OFFERS_PROPERTY']);
//pre($arResult['OFFERS_FIELD_CODE']);
?>

<div class="element">
    <div class="container">
        <div class="element__body">
            <div class="element__img" data-entity="images-container">
                <img class="img__cover" src="<?=$img?>" alt="<?=$arResult['DETAIL_PICTURE']['ALT']?>">
            </div>
            <div class="element__info">
                <div class="element__name" data-name><?=$arResult['NAME']?></div>
                <div class="element__description"><?=$arResult['DETAIL_TEXT']?></div>

                <?if ($arResult['PRODUCT_OFFERS']):?>

                    <?foreach ($arResult['PRODUCT_OFFERS_PROPERTY'] as $offerProperty):?>

                        <div class="element__offers">
                            <span data-offer data-offer-property=""></span>
                        </div>

                    <?endforeach;?>


                    <?foreach ($arResult['PRODUCT_OFFERS'] as $offer):?>
                        <div class="element__buy-container">
                            <a data-add2basket href="<?=$offer['ADD_URL']?>" class="element__buy-button">В корзину</a>
                            <div class="element__price"><?=$offer['PRICE']?></div>
                        </div>
                    <?endforeach;?>

                <?else:?>

                    <div class="element__buy-container">
<!--                        <div class="element__quantity">Товар в наличии<span>8 шт.</span></div>-->
                        <a data-add2basket href="<?=$arResult['ADD_URL']?>" class="element__buy-button">В корзину</a>
                        <div class="element__price"><?=$arResult['PRICES'][$arParams['PRICE_CODE'][0]]['PRINT_VALUE']?></div>
                    </div>

                <?endif;?>

            </div>
        </div>
    </div>
</div>

<script>
    $('[data-add2basket]').on('click', function (event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('href')
        });
    });
</script>
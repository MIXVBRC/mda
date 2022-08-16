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

$img = $arResult['DETAIL_PICTURE']['SRC'] ? $arResult['DETAIL_PICTURE']['SRC'] : SITE_TEMPLATE_PATH.'/img/noimg.png'
?>

<div class="element" id="bid">
    <div class="container">
        <div class="element__body">
            <div class="element__img" data-entity="images-container">
                <img class="img__cover" src="<?=$img?>" alt="<?=$arResult['DETAIL_PICTURE']['ALT']?>">
            </div>
            <div class="element__info">
                <div class="element__name"><?=$arResult['NAME']?></div>
                <div class="element__description"><?=$arResult['DETAIL_TEXT']?></div>
                <div class="element__buy-container">
                    <div class="element__quantity">Товар в наличии<span>8 шт.</span></div>
                    <a href="javascript:void(0);" data-add2basket data-product="<?=$arResult['ID']?>" class="element__buy-button">В корзину</a>
                    <div class="element__price"><?=$arResult['PRICES'][$arParams['PRICE_CODE'][0]]['PRINT_VALUE']?></div>
                </div>
            </div>
        </div>
    </div>
</div>
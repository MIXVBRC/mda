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

//pre($arResult);
?>

    <div class="element" id="bid">
        <a href="javascript:void(0);" data-add2basket data-product="<?=$arResult['ID']?>">add</a>
        <div class="container">
            <div class="element__body">
                <div class="element__img" data-entity="images-container">
                    <img class="img__cover" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResult['DETAIL_PICTURE']['ALT']?>">
                </div>
                <div class="element__info">
                    <div class="element__name"><?=$arResult['NAME']?></div>
                    <div class="element__description"><?=$arResult['DETAIL_TEXT']?></div>
                    <div class="element__buy-container">
                        <div class="element__quantity">Товар в наличии<span>8 шт.</span></div>
                        <a href="javascript:void(0);" class="element__buy-button"><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></a>
                        <div class="element__price"><?=$arResult['PRICES'][$arParams['PRICE_CODE'][0]]['PRINT_VALUE']?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
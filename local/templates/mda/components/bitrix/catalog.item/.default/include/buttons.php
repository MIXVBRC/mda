<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $itemIds
 * @var array $item
 * @var array $actualItem
 * @var array $price
 * @var CatalogSectionComponent $component
 * @var array $minOffer
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var string $measureRatio
 * @var string $buttonSizeClass
 */
?>

<div data-entity="buttons-block">
    <div id="<?=$itemIds['BASKET_ACTIONS']?>" <?=($actualItem['CAN_BUY'] ? '' : 'style="display: none;"')?>>
        <a class="button" id="<?=$itemIds['BUY_LINK']?>" href="javascript:void(0)" rel="nofollow">
            <?=($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET'])?>
        </a>
    </div>
</div>

<?
/**
 * @global CMain $APPLICATION
 * @var array $itemIds
 * @var array $actualItem
 * @var array $arParams
 * @var array $arResult
 * @var bool $showAddBtn
 * @var bool $showBuyBtn
 * @var CatalogSectionComponent $component
 */
?>

<div data-entity="main-button-container">

    <?if ($actualItem['CAN_BUY']):?>

        <div id="<?=$itemIds['BASKET_ACTIONS_ID']?>">

            <?if ($showAddBtn):?>

                <a class="button" data-bubble id="<?=$itemIds['ADD_BASKET_LINK']?>" href="javascript:void(0);">
                    <?=$arParams['MESS_BTN_ADD_TO_BASKET']?>
                </a>

            <?endif;?>

            <?if ($showBuyBtn):?>

                <a class="button" data-bubble id="<?=$itemIds['BUY_LINK']?>" href="javascript:void(0);">
                    <?=$arParams['MESS_BTN_BUY']?>
                </a>

            <?endif;?>

        </div>

    <?else:?>

        <a class="button" id="<?=$itemIds['NOT_AVAILABLE_MESS']?>" href="javascript:void(0)" rel="nofollow">
            <?=$arParams['MESS_NOT_AVAILABLE']?>
        </a>

    <?endif;?>

</div>

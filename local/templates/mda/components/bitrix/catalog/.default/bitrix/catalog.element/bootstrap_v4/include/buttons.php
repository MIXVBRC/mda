<?
/**
 * @global CMain $APPLICATION
 * @var array $itemIds
 * @var array $actualItem
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 */

$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
?>

<div data-entity="main-button-container">

    <?if ($actualItem['CAN_BUY']):?>

        <div id="<?=$itemIds['BASKET_ACTIONS_ID']?>">

            <?if ($showAddBtn):?>

                <a class="element__buy-button" id="<?=$itemIds['ADD_BASKET_LINK']?>" href="javascript:void(0);">
                    <?=$arParams['MESS_BTN_ADD_TO_BASKET']?>
                </a>

            <?endif;?>

            <?if ($showBuyBtn):?>

                <a class="element__buy-button" id="<?=$itemIds['BUY_LINK']?>" href="javascript:void(0);">
                    <?=$arParams['MESS_BTN_BUY']?>
                </a>

            <?endif;?>

        </div>

    <?else:?>

        <a class="element__buy-button" id="<?=$itemIds['NOT_AVAILABLE_MESS']?>" href="javascript:void(0)" rel="nofollow">
            <?=$arParams['MESS_NOT_AVAILABLE']?>
        </a>

    <?endif;?>

</div>

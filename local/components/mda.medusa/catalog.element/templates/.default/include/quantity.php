<?
/**
 * @var array $itemIds
 * @var array $price
 * @var array $arParams
 * @var array $actualItem
 */
?>

<?if ($arParams['USE_PRODUCT_QUANTITY'] && $actualItem['CAN_BUY']):?>

    <div class="quantity" data-entity="quantity-block">
        <span class="quantity__button minus" id="<?=$itemIds['QUANTITY_DOWN_ID']?>"></span>
        <input class="quantity__input" id="<?=$itemIds['QUANTITY_ID']?>" type="number" value="<?=$price['MIN_QUANTITY']?>">
        <span class="quantity__button plus" id="<?=$itemIds['QUANTITY_UP_ID']?>"></span>
        <span class="quantity__result">
            <span id="<?=$itemIds['QUANTITY_MEASURE']?>"><?=$actualItem['ITEM_MEASURE']['TITLE']?></span>
            <span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
        </span>
    </div>

<?endif;?>
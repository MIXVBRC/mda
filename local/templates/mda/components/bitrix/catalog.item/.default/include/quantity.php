<?
/**
 * @var array $arParams
 * @var array $itemIds
 * @var array $actualItem
 * @var array $price
 * @var array $minOffer
 * @var bool $haveOffers
 * @var string $measureRatio
 */
?>

<?if ($actualItem['CAN_BUY'] && $arParams['USE_PRODUCT_QUANTITY']):?>
    <div class="quantity" data-entity="quantity-block">
        <span class="quantity__button minus disabled" id="<?=$itemIds['QUANTITY_DOWN']?>"></span>
        <input class="quantity__input" id="<?=$itemIds['QUANTITY']?>" type="number" value="<?=$measureRatio?>" name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>">
        <span class="quantity__button plus" id="<?=$itemIds['QUANTITY_UP']?>"></span>
        <span class="quantity__result">
            <span id="<?=$itemIds['QUANTITY_MEASURE']?>"><?=$actualItem['ITEM_MEASURE']['TITLE']?></span>
            <span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
        </span>
    </div>
<?endif;?>

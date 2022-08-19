<?
/**
 * @var array $arParams
 * @var array $itemIds
 * @var array $price
 * @var array $minOffer
 * @var bool $haveOffers
 * @var string $measureRatio
 */
?>
<div class="list1__price" data-entity="price-block">

    <?if ($price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE']):?>
        <div class="list1__price-old">
            <span id="<?=$itemIds['PRICE_OLD']?>"><?=$price['PRINT_RATIO_BASE_PRICE']?></span>
        </div>
    <?endif;?>

    <div class="list1__price-now" id="<?=$itemIds['PRICE']?>">
        <?=$price['PRINT_RATIO_PRICE']?>
    </div>

</div>

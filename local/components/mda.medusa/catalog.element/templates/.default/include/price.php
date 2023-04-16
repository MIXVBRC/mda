<?
/**
 * @var array $itemIds
 * @var array $price
 * @var array $arParams
 * @var array $showDiscount
 */
use Bitrix\Main\Localization\Loc;
?>

<? if ($price['PRINT_RATIO_PRICE']): ?>
    <div class="element__price">
        <? if ($showDiscount && $price['PRINT_RATIO_BASE_PRICE'] && $price['DISCOUNT']):?>
            <div class="element__price-old">
                <span id="<?=$itemIds['OLD_PRICE_ID']?>"><?= $price['PRINT_RATIO_BASE_PRICE'] ?></span>
            </div>
        <? endif; ?>

        <div class="element__price-now" id="<?=$itemIds['PRICE_ID']?>">
            <?=$price['PRINT_RATIO_PRICE']?>
        </div>

        <? if ($showDiscount && $price['PRINT_RATIO_DISCOUNT'] && $price['DISCOUNT']):?>
            <div class="element__price-discount" id="<?=$itemIds['DISCOUNT_PRICE_ID']?>">
                <?= Loc::getMessage('CT_BCE_CATALOG_ECONOMY_INFO2', array('#ECONOMY#' => $price['PRINT_RATIO_DISCOUNT'])) ?>
            </div>
        <? endif; ?>
    </div>
<? endif; ?>
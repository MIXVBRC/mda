<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $cartId
 */

$compositeStub = ($arResult['COMPOSITE_STUB'] ?? 'N') === 'Y';

if ($arResult['NUM_PRODUCTS'] > 0):?>

	<a href="<?=$arParams['PATH_TO_BASKET']?>" class="basket-small">

		<?if ($arParams['SHOW_NUM_PRODUCTS'] === 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] === 'Y') && !$compositeStub):?>

            <span class="basket-small__count"><?=$arResult['NUM_PRODUCTS']?></span>

        <?endif;?>

	</a>

<?else:?>

    <a href="<?=$arParams['PATH_TO_BASKET']?>" class="basket-small"></a>

<?endif;?>
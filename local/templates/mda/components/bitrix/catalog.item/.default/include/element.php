<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var string $discountPositionClass
 * @var string $labelPositionClass
 * @var string $areaId
 * @var CatalogSectionComponent $component
 */
$this->setFrameMode(false);
?>

<? require __DIR__ . '/image.php'; ?>

<? require __DIR__ . '/title.php'; ?>

<?// require __DIR__ . '/quantityLimit.php'; ?>

<?// require __DIR__ . '/props.php'; ?>

<?/*
<div class="list1__item-hide">
    <? require __DIR__ . '/sku.php'; ?>
</div>
*/?>

<? require __DIR__ . '/price.php'; ?>

<? if (MDA_SITE_MODE_SALE) require __DIR__ . '/quantity.php'; ?>

<? if (MDA_SITE_MODE_SALE) require __DIR__ . '/buttons.php'; ?>

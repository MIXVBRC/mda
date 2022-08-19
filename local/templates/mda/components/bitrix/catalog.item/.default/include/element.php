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

<? require __DIR__ . '/image.php';?>

<? require __DIR__ . '/title.php';?>

<?
if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
{

//    require __DIR__ . '/quantityLimit.php';
//    require __DIR__ . '/props.php';

    require __DIR__ . '/sku.php';
    require __DIR__ . '/price.php';
    require __DIR__ . '/quantity.php';
    require __DIR__ . '/buttons.php';


    /*
    foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
    {
        switch ($blockName)
        {
            case 'quantityLimit':
                require __DIR__ . '/quantityLimit.php';
                break;

            case 'quantity':
                require __DIR__ . '/quantity.php';
                break;

            case 'price':
                require __DIR__ . '/price.php';
                break;

            case 'buttons':
                require __DIR__ . '/buttons.php';
                break;

            case 'props':
                require __DIR__ . '/props.php';
                break;

            case 'sku':
                require __DIR__ . '/sku.php';
                break;
        }
    }
    */
}

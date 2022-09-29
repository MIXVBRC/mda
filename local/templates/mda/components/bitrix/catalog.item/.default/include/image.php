<?
/**
 * @var array $item
 * @var array $itemIds
 *
 * @var array $arParams
 * @var array $price
 * @var array $morePhoto
 * @var string $discountPositionClass
 * @var string $labelPositionClass
 * @var string $imgTitle
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 */

//$bgImage = !empty($item['PREVIEW_PICTURE_SECOND']) ? $item['PREVIEW_PICTURE_SECOND']['SRC'] : $item['PREVIEW_PICTURE']['SRC'];
?>


<a href="<?=$item['DETAIL_PAGE_URL']?>" class="list1__img" data-before-text="Подробнее" data-entity="image-wrapper">
    <div id="<?=$itemIds['PICT_SLIDER']?>" data-slider-interval="<?=$arParams['SLIDER_INTERVAL']?>" data-slider-wrap="true"></div>

    <?/*
    <div id="<?=$itemIds['PICT']?>" style="background-image: url('<?=$item['PREVIEW_PICTURE']['SRC']?>/*');"></div>
    */?>

    <?/*
    <div id="<?=$itemIds['SECOND_PICT']?>" style="background-image: url('<?=$bgImage?>');"></div>
    */?>

    <img class="img__cover" src="<?=$item['PREVIEW_PICTURE']['SRC']?:MDA_NO_PHOTO?>" alt="<?=$imgTitle?>" id="<?=$itemIds['PICT']?>">

    <?/*
    <img class="img__cover" src="<?=$bgImage?>" id="<?=$itemIds['SECOND_PICT']?>" style="display: none;">
    */?>
</a>
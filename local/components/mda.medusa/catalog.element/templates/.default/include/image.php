<?
/**
 * @var array $itemIds
 * @var array $actualItem
 * @var array $arResult
 * @var string $alt
 * @var string $title
 */
?>
<div class="element__img" data-entity="images-container" id="<?=$itemIds['BIG_SLIDER_ID']?>">
    <?foreach ($actualItem['MORE_PHOTO'] as $key => $photo):?>
        <div class="element__img-container" data-entity="image" data-id="<?=$photo['ID']?>">
            <img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>">
        </div>
    <?endforeach;?>
</div>
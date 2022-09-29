<?
/**
 * @var array $itemIds
 * @var array $actualItem
 * @var array $arResult
 * @var string $alt
 * @var string $title
 */
//pre($actualItem['MORE_PHOTO'][0]);
//if (!$actualItem['MORE_PHOTO'][0]) {
//    pre($arResult);
//}
?>
<div class="element__img" data-entity="images-container" id="<?=$itemIds['BIG_SLIDER_ID']?>">
    <?foreach ($actualItem['MORE_PHOTO'] as $key => $photo):?>
        <div data-entity="image" data-id="<?=$photo['ID']?>">
            <img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>">
        </div>
    <?endforeach;?>
</div>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="menu-bottom">
    <ul class="menu-bottom__list">

        <?foreach($arResult as $arItem):?>
            <li class="menu-bottom__item"><a href="<?=$arItem["LINK"]?>" class="menu-bottom__link"><?=$arItem["TEXT"]?></a></li>
        <?endforeach?>

    </ul>
</div>
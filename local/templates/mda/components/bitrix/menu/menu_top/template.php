<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<nav class="menu-top" data-menu-top>
    <ul class="menu-top__list">
        <?foreach($arResult as $arItem):?>
            <li class="menu-top__item"><a href="<?=$arItem["LINK"]?>" class="menu-top__link"><?=$arItem["TEXT"]?></a></li>
        <?endforeach?>
    </ul>
</nav>
<div class="burger" data-menu-burger><span></span></div>
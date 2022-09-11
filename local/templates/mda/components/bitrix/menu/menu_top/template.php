<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<nav class="menu-top" data-menu-top>
    <ul class="menu-top__list">

        <?foreach($arResult as $arItem):?>

            <li class="menu-top__item"<?=($arItem['SELECTED']?' data-menu-select':'')?>>

                <a href="<?=$arItem["LINK"]?>" class="menu-top__item-link"><?=$arItem["TEXT"]?></a>

                <?if ($arItem['SECTIONS']):?>

                    <div class="menu-top__item-subsection">
                        <div class="menu-top__item-subsection-body">
                            <div class="container">
                                <ul class="menu-top__item-subsection-list">

                                    <?foreach ($arItem['SECTIONS'] as $arItemSub):?>

                                        <li class="menu-top__item-subsection-item">

                                            <a href="<?=$arItemSub['LINK']?>" class="menu-top__item-subsection-item-link"><?=$arItemSub['NAME']?></a>

                                            <?if ($arItemSub['SECTIONS']):?>

                                                <ul class="menu-top__item-subsection-subsection-list">

                                                <?foreach ($arItemSub['SECTIONS'] as $arItemSubSub):?>

                                                        <li class="menu-top__item-subsection-subsection-item">
                                                            <a href="<?=$arItemSubSub['LINK']?>" class="menu-top__item-subsection-subsection-item-link"><?=$arItemSubSub['NAME']?></a>
                                                        </li>

                                                <?endforeach;?>

                                                </ul>

                                            <?endif;?>

                                        </li>

                                    <?endforeach;?>

                                </ul>
                            </div>
                        </div>
                    </div>

                <?endif;?>

            </li>

        <?endforeach?>

    </ul>
</nav>
<div class="burger" data-menu-burger><div class="burger__body"><span></span></div></div>
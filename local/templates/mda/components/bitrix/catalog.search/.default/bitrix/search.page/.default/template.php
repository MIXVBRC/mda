<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="form">
    <div class="form__body" style="padding: 15px">
        <form class="form__form" action="" method="get">

            <input type="hidden" name="how" value="<? echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>"/>

            <div class="form__item">
                <input class="form__input" type="text" name="q" value="<?= $arResult["REQUEST"]["QUERY"] ?>" size="40"/>
            </div>

            <div class="form__item">
                <input class="button" type="submit" value="<?= GetMessage("SEARCH_GO") ?>"/>
            </div>

            <div class="form__item">
                <div class="form__message">
                    <? $APPLICATION->ShowProperty('SEARCH_MESSAGE') ?>
                </div>
            </div>
            
        </form>
    </div>
</div>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="order-cansel">
    <div class="order-cansel__body">

        <?if($arResult["ERROR_MESSAGE"] == ''):?>

            <form class="order-cansel__form" method="post" action="<?=POST_FORM_ACTION_URI?>">

                <input type="hidden" name="CANCEL" value="Y">
                <?=bitrix_sessid_post()?>
                <input type="hidden" name="ID" value="<?=$arResult["ID"]?>">

                <div class="order-cansel__item">
                    <?=GetMessage("SALE_CANCEL_ORDER1") ?>
                    <a class="order-cansel__link" href="<?=$arResult["URL_TO_DETAIL"]?>">
                        <?=GetMessage("SALE_CANCEL_ORDER2")?> #<?=$arResult["ACCOUNT_NUMBER"]?>
                    </a>?
                </div>

                <div class="order-cansel__item">
                    <?= GetMessage("SALE_CANCEL_ORDER3") ?>
                </div>

                <div class="order-cansel__item">
                    <?= GetMessage("SALE_CANCEL_ORDER4") ?>:
                </div>

                <div class="order-cansel__item">
                    <textarea class="order-cansel__input" rows="4" cols="30" name="REASON_CANCELED"></textarea>
                </div>

                <div class="order-cansel__item">
                    <input class="order-cansel__button" type="submit" name="action" value="<?=GetMessage("SALE_CANCEL_ORDER_BTN") ?>"/>
                </div>

                <div class="order-cansel__item">
                    <a class="order-cansel__link" href="<?=$arResult["URL_TO_LIST"]?>" rel="nofollow"><?=GetMessage("SALE_RECORDS_LIST")?></a>
                </div>

            </form>

        <?else:?>

            <div class="order-cansel__error">
                <p><?=ShowError($arResult["ERROR_MESSAGE"]);?></p>
            </div>

        <?endif;?>

    </div>
</div>
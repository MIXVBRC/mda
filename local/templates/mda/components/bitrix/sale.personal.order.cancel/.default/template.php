<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="form">
    <div class="form__body">

        <? if($arResult["ERROR_MESSAGE"] == ''): ?>

            <form class="form__form" method="post" action="<?=POST_FORM_ACTION_URI?>">

                <input type="hidden" name="CANCEL" value="Y">
                <?=bitrix_sessid_post()?>
                <input type="hidden" name="ID" value="<?=$arResult["ID"]?>">

                <div class="form__list">

                    <div class="form__item">
                        <div class="form__small">
                            <?=GetMessage("SALE_CANCEL_ORDER1") ?>
                            <a class="form__link" href="<?=$arResult["URL_TO_DETAIL"]?>">
                                <?=GetMessage("SALE_CANCEL_ORDER2")?> #<?=$arResult["ACCOUNT_NUMBER"]?>
                            </a>?
                            <?= GetMessage("SALE_CANCEL_ORDER3") ?>
                        </div>
                    </div>

                    <div class="form__item">
                        <p><?= GetMessage("SALE_CANCEL_ORDER4") ?>:</p>
                    </div>

                    <div class="form__item">
                        <textarea class="form__textarea" rows="4" cols="30" name="REASON_CANCELED" placeholder="Причина отмены заказа"></textarea>
                    </div>

                    <div class="form__item">
                        <input class="form__button" type="submit" name="action" value="<?=GetMessage("SALE_CANCEL_ORDER_BTN") ?>"/>
                    </div>

                    <div class="form__item">
                        <a class="form__link" href="<?=$arResult["URL_TO_LIST"]?>" rel="nofollow"><?=GetMessage("SALE_RECORDS_LIST")?></a>
                    </div>

                </div>

            </form>

        <? else: ?>

            <div class="form__item">
                <div class="form__error">
                    <p><?=ShowError($arResult["ERROR_MESSAGE"]);?></p>
                </div>
            </div>

        <? endif; ?>

    </div>

</div>
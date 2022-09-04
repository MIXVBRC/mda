<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */

?>

<div class="form">
    <div class="form__body">

        <div class="form__title">Присоединяйся к нашей команде</div>

        <form class="form__form" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="AUTH" />

            <?if ($arResult["BACKURL"] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>

            <?foreach ($arResult["POST"] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>

            <div class="form__list">

                <?if ($arParams["~AUTH_RESULT"] || $arResult['ERROR_MESSAGE']):?>
                    <div class="form__item">
                        <div class="form__message">
                            <?
                            ShowMessage($arParams["~AUTH_RESULT"]);
                            ShowMessage($arResult['ERROR_MESSAGE']);
                            ?>
                        </div>
                    </div>
                <? endif ?>


                <div class="form__item">
                    <input class="form__input" placeholder="<?=GetMessage("AUTH_LOGIN")?>" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>">
                </div>

                <div class="form__item">
                    <input class="form__input" placeholder="<?=GetMessage("AUTH_PASSWORD")?>" type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off">
                </div>

                <? if($arResult["CAPTCHA_CODE"]): ?>

                    <div class="form__item">
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>"/>
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA"/>
                    </div>

                    <div class="form__item">
                        <input class="form__input" placeholder="<?=GetMessage("AUTH_CAPTCHA_PROMT")?>" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off">
                    </div>

                <? endif; ?>

                <? if ($arResult["STORE_PASSWORD"] == "Y"): ?>

                    <div class="form__item">
                        <input class="form__checkbox" type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" />
                        <label for="USER_REMEMBER"><?=GetMessage("AUTH_REMEMBER_ME")?></label>
                    </div>

                <? endif; ?>

                <div class="form__item">
                    <input class="form__button" type="submit" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>">
                </div>

                <? if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"): ?>

                    <div class="form__item">
                        <a class="form__link" href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a>
                    </div>

                <? endif; ?>

                <? if ($arParams["NOT_SHOW_LINKS"] != "Y"): ?>

                    <div class="form__item">
                        <a class="form__link" href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
                    </div>

                <? endif; ?>

            </div>


        </form>

    </div>

</div>

<script type="text/javascript">
    <?if ($arResult["LAST_LOGIN"] <> ''):?>
        try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
    <?else:?>
        try{document.form_auth.USER_LOGIN.focus();}catch(e){}
    <?endif?>
</script>

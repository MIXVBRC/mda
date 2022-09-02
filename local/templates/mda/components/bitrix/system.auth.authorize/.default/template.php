<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */

?>

<div class="auth">

    <?if ($arParams["~AUTH_RESULT"] || $arResult['ERROR_MESSAGE']):?>
        <div class="register__error">
            <?
            ShowMessage($arParams["~AUTH_RESULT"]);
            ShowMessage($arResult['ERROR_MESSAGE']);
            ?>
        </div>
    <? endif ?>

    <div class="auth__body">
        <form class="auth__form" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="AUTH" />

            <?if ($arResult["BACKURL"] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>

            <?foreach ($arResult["POST"] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>

            <table class="auth__teble">

                <tr class="auth__item">
                    <td class="auth__label"><?=GetMessage("AUTH_LOGIN")?></td>
                    <td>
                        <input class="auth__input" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>"/>
                    </td>
                </tr>

                <tr class="auth__item">
                    <td class="auth__label"><?=GetMessage("AUTH_PASSWORD")?></td>
                    <td>
                        <input class="auth__input" type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off"/>
                    </td>
                </tr>

                <?if($arResult["CAPTCHA_CODE"]):?>
                    <tr class="auth__item">
                        <td></td>
                        <td>
                            <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>"/>
                            <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA"/>
                        </td>
                    </tr>

                    <tr class="auth__item">
                        <td class="auth__label"><?=GetMessage("AUTH_CAPTCHA_PROMT")?></td>
                        <td>
                            <input class="auth__input" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                        </td>
                    </tr>
                <?endif?>

                <?if ($arResult["STORE_PASSWORD"] == "Y"):?>
                    <tr class="auth__item">
                        <td></td>
                        <td>
                            <input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" />
                            <label class="auth__remember" for="USER_REMEMBER"><?=GetMessage("AUTH_REMEMBER_ME")?></label>
                        </td>
                    </tr>
                <?endif?>

                <?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
                    <tr class="auth__item">
                        <td></td>
                        <td class="auth__button">
                            <input type="submit" name="Login" value="Войти"/>
                            <a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a>
                        </td>
                    </tr>
                <?endif?>

                <?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
                    <tr class="auth__item">
                        <td></td>
                        <td>
                            <a class="auth__forgot" href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
                        </td>
                    </tr>
                <?endif?>

            </table>
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

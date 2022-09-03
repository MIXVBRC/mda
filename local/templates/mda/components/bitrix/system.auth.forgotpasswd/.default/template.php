<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="forgot">
    <div class="forgot__body">

        <?if ($arParams["~AUTH_RESULT"]):?>
            <div class="register__error"><?ShowMessage($arParams["~AUTH_RESULT"])?></div>
        <? endif ?>

        <? if ($arResult["BACKURL"] <> ''): ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
        <? endif; ?>

        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="SEND_PWD">

        <form class="forgot__form" name="bform" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">
            <table class="forgot__teble">

                <tbody>

                    <tr class="forgot__item">
                        <td class="forgot__label"><?= GetMessage("sys_forgot_pass_login1") ?></td>
                        <td>
                            <input class="forgot__input" type="text" name="USER_LOGIN" value="<?= $arResult["USER_LOGIN"] ?>"/>
                            <input type="hidden" name="USER_EMAIL"/>
                        </td>
                    </tr>

                    <tr class="forgot__item">
                        <td class="forgot__label"></td>
                        <td><?= GetMessage("sys_forgot_pass_note_email") ?></td>
                    </tr>

                    <? if ($arResult["PHONE_REGISTRATION"]): ?>

                        <tr class="forgot__item">
                            <td class="forgot__label"><?= GetMessage("sys_forgot_pass_phone") ?></td>
                            <td><input class="forgot__input" type="text" name="USER_PHONE_NUMBER" value="<?= $arResult["USER_PHONE_NUMBER"] ?>"/></td>
                        </tr>

                        <tr class="forgot__item">
                            <td class="forgot__label"></td>
                            <td><?= GetMessage("sys_forgot_pass_note_phone") ?></td>
                        </tr>

                    <? endif; ?>

                    <? if ($arResult["USE_CAPTCHA"]): ?>

                        <tr class="forgot__item">
                            <td></td>
                            <td><input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>" />
                                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA" /></td>
                        </tr>

                        <tr class="forgot__item">
                            <td class="forgot__label"><? echo GetMessage("system_auth_captcha") ?></td>
                            <td><input class="forgot__input" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" /></td>
                        </tr>

                    <? endif ?>

                    <tr class="forgot__item">
                        <td></td>
                        <td class="forgot__button"><input type="submit" name="send_account_info" value="<?= GetMessage("AUTH_SEND") ?>"/></td>
                    </tr>

                    <tr class="forgot__item">
                        <td></td>
                        <td><a class="forgot__auth" href="<?= $arResult["AUTH_AUTH_URL"] ?>" rel="nofollow"><?= GetMessage("AUTH_AUTH") ?></a></td>
                    </tr>

                </tbody>

            </table>
        </form>

    </div>
</div>

<script type="text/javascript">
    document.bform.onsubmit = function () {
        document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;
    };
    document.bform.USER_LOGIN.focus();
</script>

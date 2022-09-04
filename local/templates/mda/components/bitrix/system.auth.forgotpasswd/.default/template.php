<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="form">
    <div class="form__body">

        <div class="form__title">Восстановление пароля</div>

        <form class="form__form" name="bform" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">

            <div class="form__list">

                <?if ($arParams["~AUTH_RESULT"]):?>
                    <div class="form__item">
                        <div class="form__message"><?ShowMessage($arParams["~AUTH_RESULT"])?></div>
                    </div>
                <? endif ?>

                <? if ($arResult["BACKURL"] <> ''): ?>
                    <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                <? endif; ?>

                <input type="hidden" name="AUTH_FORM" value="Y">
                <input type="hidden" name="TYPE" value="SEND_PWD">

                <div class="form__item">
                    <input class="form__input" placeholder="<?=GetMessage("sys_forgot_pass_login1")?>" type="text" name="USER_LOGIN" value="<?= $arResult["USER_LOGIN"] ?>">
                    <input type="hidden" name="USER_EMAIL"/>
                </div>

                <div class="form__item">
                    <div class="form__small"><?=GetMessage("sys_forgot_pass_note_email")?></div>
                </div>

                <? if ($arResult["PHONE_REGISTRATION"]): ?>

                    <div class="form__item">
                        <input class="form__input" placeholder="<?=GetMessage("sys_forgot_pass_phone")?>" type="text" name="USER_PHONE_NUMBER" value="<?= $arResult["USER_PHONE_NUMBER"] ?>">
                    </div>

                    <div class="form__item">
                        <div class="form__small"><?=GetMessage("sys_forgot_pass_note_phone")?></div>
                    </div>

                <? endif; ?>

                <? if ($arResult["USE_CAPTCHA"]): ?>

                    <div class="form__item">
                        <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA" />
                    </div>

                    <div class="form__item">
                        <input class="form__input" placeholder="<?=GetMessage("system_auth_captcha")?>" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off">
                    </div>

                <? endif ?>

                <div class="form__item">
                    <input class="form__button" type="submit" name="send_account_info" value="<?= GetMessage("AUTH_SEND") ?>">
                </div>

                <div class="form__item">
                    <a class="form__link" href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_AUTH")?></a>
                </div>

            </div>


        </form>

    </div>

</div>

<script type="text/javascript">
    document.bform.onsubmit = function () {
        document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;
    };
    document.bform.USER_LOGIN.focus();
</script>

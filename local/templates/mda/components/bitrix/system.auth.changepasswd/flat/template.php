<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?
if (!$arResult["SHOW_FORM"]) LocalRedirect($arResult["AUTH_AUTH_URL"]);
?>

<div class="form">
    <div class="form__body">

        <div class="form__title"><?=GetMessage("AUTH_CHANGE_PASSWORD")?></div>

        <form name="bform" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">

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
                <input type="hidden" name="TYPE" value="CHANGE_PWD">

                <div class="form__item">
                    <input class="form__input" id="USER_LOGIN" type="text" name="USER_LOGIN" value="<?= $arResult["LAST_LOGIN"] ?>">
                    <label class="form__label" for="USER_LOGIN">
                        * <?=GetMessage("AUTH_LOGIN")?>
                    </label>
                </div>

                <div class="form__item">
                    <input class="form__input" id="USER_CURRENT_PASSWORD" type="password" name="USER_CURRENT_PASSWORD" value="<?= $arResult["USER_CURRENT_PASSWORD"] ?>" autocomplete="new-password">
                    <label class="form__label" for="USER_CURRENT_PASSWORD">
                        * <?=GetMessage("sys_auth_changr_pass_current_pass")?>
                    </label>
                </div>

                <div class="form__item">
                    <input class="form__input" id="USER_PASSWORD" type="password" name="USER_PASSWORD" value="<?= $arResult["USER_PASSWORD"] ?>" autocomplete="new-password">
                    <label class="form__label" for="USER_PASSWORD">
                        * <?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>
                    </label>
                </div>

                <div class="form__item">
                    <input class="form__input" id="USER_CONFIRM_PASSWORD" type="password" name="USER_CONFIRM_PASSWORD" value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>" autocomplete="new-password">
                    <label class="form__label" for="USER_CONFIRM_PASSWORD">
                        * <?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>
                    </label>
                </div>

                <? if ($arResult["USE_CAPTCHA"]): ?>

                    <div class="form__item">
                        <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA" />
                    </div>

                    <div class="form__item">
                        <input class="form__input" id="FORM_CAPTCHA" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off">
                        <label class="form__label" for="FORM_CAPTCHA">
                            * <?=GetMessage("system_auth_captcha")?>
                        </label>
                    </div>

                <? endif ?>

                <div class="form__item">
                    <input class="button" type="submit" name="send_account_info" value="<?= GetMessage("AUTH_CHANGE") ?>">
                </div>

            </div>


        </form>

    </div>

</div>
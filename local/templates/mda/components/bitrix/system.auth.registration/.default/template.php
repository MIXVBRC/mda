<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arResult["SHOW_SMS_FIELD"] == true) {
    CJSCore::Init('phone_auth');
}
?>

<div class="form">
    <div class="form__body">

        <div class="form__title"><?=GetMessage("AUTH_REGISTER")?></div>

        <?if ($arParams["~AUTH_RESULT"]):?>
            <div class="form__item">
                <div class="form__message"><?ShowMessage($arParams["~AUTH_RESULT"])?></div>
            </div>
        <? endif ?>

        <? if ($arResult["SHOW_EMAIL_SENT_CONFIRMATION"]): ?>
            <div class="form__item">
                <div class="form__note"><?=GetMessage("AUTH_EMAIL_SENT")?></div>
            </div>
        <? endif; ?>


        <? if ($arResult["SHOW_SMS_FIELD"] == true): ?>

            <form method="post" action="<?= $arResult["AUTH_URL"] ?>" name="regform">

                <input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>"/>

                <div class="form__list">

                    <div class="form__item">
                        <input class="form__input" placeholder="*<?=GetMessage("main_register_sms_code")?>" type="text" name="SMS_CODE" value="<?=htmlspecialcharsbx($arResult["SMS_CODE"])?>" autocomplete="off">
                    </div>

                    <div class="form__item">
                        <input class="form__button" type="submit" name="code_submit_button" value="<?=GetMessage("main_register_sms_send")?>">
                    </div>

                </div>

            </form>

            <script>
                new BX.PhoneAuth({
                    containerId: 'bx_register_resend',
                    errorContainerId: 'bx_register_error',
                    interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
                    data:
                        <?=CUtil::PhpToJSObject([
                            'signedData' => $arResult["SIGNED_DATA"],
                        ])?>,
                    onError:
                        function (response) {
                            var errorDiv = BX('bx_register_error');
                            var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
                            errorNode.innerHTML = '';
                            for (var i = 0; i < response.errors.length; i++) {
                                errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
                            }
                            errorDiv.style.display = '';
                        }
                });
            </script>

            <div id="bx_register_error" style="display:none"><?ShowError("error")?></div>

            <div id="bx_register_resend"></div>

        <? elseif (!$arResult["SHOW_EMAIL_SENT_CONFIRMATION"]): ?>

            <form class="form__form" method="post" action="<?= $arResult["AUTH_URL"] ?>" name="bform" enctype="multipart/form-data">

                <input type="hidden" name="AUTH_FORM" value="Y"/>
                <input type="hidden" name="TYPE" value="REGISTRATION"/>

                <div class="form__list">

                    <div class="form__item">
                        <input class="form__input" placeholder="<?= GetMessage("AUTH_NAME") ?>" type="text" name="USER_NAME" maxlength="50" value="<?= $arResult["USER_NAME"] ?>">
                    </div>

                    <div class="form__item">
                        <input class="form__input" placeholder="<?= GetMessage("AUTH_LAST_NAME") ?>" type="text" name="USER_LAST_NAME" maxlength="50" value="<?= $arResult["USER_LAST_NAME"] ?>">
                    </div>

                    <div class="form__item">
                        <input class="form__input" placeholder="* <?= GetMessage("AUTH_LOGIN_MIN") ?>" type="text" name="USER_LOGIN" maxlength="50" value="<?= $arResult["USER_LOGIN"] ?>">
                    </div>

                    <div class="form__item">
                        <input class="form__input" placeholder="* <?= GetMessage("AUTH_PASSWORD_REQ") ?>" type="password" name="USER_PASSWORD" maxlength="255" value="<?= $arResult["USER_PASSWORD"] ?>" autocomplete="off">
                    </div>

                    <? if ($arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]): ?>

                        <div class="form__item">
                            <div class="form__small"><?= $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></div>
                        </div>

                    <? endif ?>

                    <div class="form__item">
                        <input class="form__input" placeholder="* <?= GetMessage("AUTH_CONFIRM") ?>" type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>" autocomplete="off">
                    </div>

                    <? if ($arResult["EMAIL_REGISTRATION"]): ?>

                        <div class="form__item">
                            <input class="form__input" placeholder="<?=($arResult["EMAIL_REQUIRED"] ? '* ' : '')?><?= GetMessage("AUTH_EMAIL") ?>" type="text" name="USER_EMAIL" maxlength="255" value="<?= $arResult["USER_EMAIL"] ?>">
                        </div>

                    <? endif ?>

                    <? if (!$arResult["SHOW_EMAIL_SENT_CONFIRMATION"] && $arResult["USE_EMAIL_CONFIRMATION"] === "Y"): ?>

                        <div class="form__item">
                            <div class="form__small"><?=GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div>
                        </div>

                    <? endif ?>

                    <? if ($arResult["PHONE_REGISTRATION"]): ?>

                        <div class="form__item">
                            <input class="form__input" placeholder="<?=($arResult["PHONE_REQUIRED"] ? '* ' : '')?><?= GetMessage("main_register_phone_number") ?>" type="text" name="USER_PHONE_NUMBER" maxlength="255" value="<?= $arResult["USER_PHONE_NUMBER"] ?>">
                        </div>

                    <? endif ?>

                    <? if ($arResult["USE_CAPTCHA"] == "Y"): ?>

                        <div class="form__item">
                            <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>">
                            <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA"/>
                        </div>

                        <div class="form__item">
                            <input class="form__input" placeholder="<?= GetMessage("CAPTCHA_REGF_PROMT") ?>" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off">
                        </div>

                    <? endif ?>

                    <div class="form__item">
                        <? $APPLICATION->IncludeComponent("bitrix:main.userconsent.request", "",
                            array(
                                "ID" => COption::getOptionString("main", "new_user_agreement", ""),
                                "IS_CHECKED" => "Y",
                                "AUTO_SAVE" => "N",
                                "IS_LOADED" => "Y",
                                "ORIGINATOR_ID" => $arResult["AGREEMENT_ORIGINATOR_ID"],
                                "ORIGIN_ID" => $arResult["AGREEMENT_ORIGIN_ID"],
                                "INPUT_NAME" => $arResult["AGREEMENT_INPUT_NAME"],
                                "REPLACE" => array(
                                    "button_caption" => GetMessage("AUTH_REGISTER"),
                                    "fields" => array(
                                        rtrim(GetMessage("AUTH_NAME"), ":"),
                                        rtrim(GetMessage("AUTH_LAST_NAME"), ":"),
                                        rtrim(GetMessage("AUTH_LOGIN_MIN"), ":"),
                                        rtrim(GetMessage("AUTH_PASSWORD_REQ"), ":"),
                                        rtrim(GetMessage("AUTH_EMAIL"), ":"),
                                    )
                                ),
                            )
                        ); ?>
                    </div>

                    <div class="form__item">
                        <input class="form__button" type="submit" name="Register" value="<?= GetMessage("AUTH_REGISTER") ?>">
                    </div>

                    <div class="form__item">
                        <div class="form__small">* <?= GetMessage("AUTH_REQ") ?></div>
                    </div>

                    <div class="form__item">
                        <a class="form__link" href="<?= $arResult["AUTH_AUTH_URL"] ?>" rel="nofollow"><?= GetMessage("AUTH_AUTH") ?></a>
                    </div>

                </div>

            </form>

            <script type="text/javascript">
                document.bform.USER_NAME.focus();
            </script>

        <? endif ?>

    </div>

</div>
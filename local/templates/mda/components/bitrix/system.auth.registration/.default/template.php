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

<div class="register">

    <?if ($arParams["~AUTH_RESULT"]):?>
        <div class="register__error"><?ShowMessage($arParams["~AUTH_RESULT"])?></div>
    <? endif ?>

    <? if ($arResult["SHOW_EMAIL_SENT_CONFIRMATION"]): ?>
        <p><? echo GetMessage("AUTH_EMAIL_SENT") ?></p>
    <? endif; ?>

    <? if (!$arResult["SHOW_EMAIL_SENT_CONFIRMATION"] && $arResult["USE_EMAIL_CONFIRMATION"] === "Y"): ?>
        <p><? echo GetMessage("AUTH_EMAIL_WILL_BE_SENT") ?></p>
    <? endif ?>


    <noindex>
        <div class="register__body">

            <? if ($arResult["SHOW_SMS_FIELD"] == true): ?>

                <form class="register__form" method="post" action="<?= $arResult["AUTH_URL"] ?>" name="regform">

                    <input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult["SIGNED_DATA"]) ?>"/>

                    <table class="register__teble">

                        <tbody>

                        <tr class="register__item">
                            <td><span class="register__necessarily">*</span>Код подтверждения из СМС:</td>
                            <td><input class="register__input" type="text" name="SMS_CODE" value="<?= htmlspecialcharsbx($arResult["SMS_CODE"]) ?>" autocomplete="off"/></td>
                        </tr>

                        <tr class="register__item">
                            <td></td>
                            <td class="register__button"><input type="submit" name="code_submit_button" value="<? echo GetMessage("main_register_sms_send") ?>"/></td>
                        </tr>

                        </tbody>

                    </table>
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

                <div id="bx_register_error" style="display:none"><? ShowError("error") ?></div>

                <div id="bx_register_resend"></div>

            <? elseif (!$arResult["SHOW_EMAIL_SENT_CONFIRMATION"]): ?>

                <form class="register__form" method="post" action="<?= $arResult["AUTH_URL"] ?>" name="bform" enctype="multipart/form-data">

                    <input type="hidden" name="AUTH_FORM" value="Y"/>
                    <input type="hidden" name="TYPE" value="REGISTRATION"/>

                    <table class="register__teble">

                        <tbody>

                        <tr class="register__item">
                            <td></td>
                            <td><b><?= GetMessage("AUTH_REGISTER") ?></b></td>
                        </tr>

                        <tr class="register__item">
                            <td class="register__label"><?= GetMessage("AUTH_NAME") ?></td>
                            <td><input class="register__input" type="text" name="USER_NAME" maxlength="50" value="<?= $arResult["USER_NAME"] ?>"/></td>
                        </tr>

                        <tr class="register__item">
                            <td class="register__label"><?= GetMessage("AUTH_LAST_NAME") ?></td>
                            <td><input class="register__input" type="text" name="USER_LAST_NAME" maxlength="50" value="<?= $arResult["USER_LAST_NAME"] ?>"/></td>
                        </tr>

                        <tr class="register__item">
                            <td class="register__label"><span class="register__necessarily">*</span><?= GetMessage("AUTH_LOGIN_MIN") ?></td>
                            <td><input class="register__input" type="text" name="USER_LOGIN" maxlength="50" value="<?= $arResult["USER_LOGIN"] ?>"/></td>
                        </tr>

                        <tr>
                            <td class="register__label"><span class="register__necessarily">*</span><?= GetMessage("AUTH_PASSWORD_REQ") ?></td>
                            <td><input class="register__input" type="password" name="USER_PASSWORD" maxlength="255" value="<?= $arResult["USER_PASSWORD"] ?>" autocomplete="off"/></td>
                        </tr>

                        <tr>
                            <td class="register__label"><span class="register__necessarily">*</span><?= GetMessage("AUTH_CONFIRM") ?></td>
                            <td><input class="register__input" type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>" autocomplete="off"/></td>
                        </tr>

                        <? if ($arResult["EMAIL_REGISTRATION"]): ?>

                            <tr>
                                <td class="register__label">
                                    <? if ($arResult["EMAIL_REQUIRED"]): ?>
                                        <span class="register__necessarily">*</span>
                                    <? endif ?>
                                    <?= GetMessage("AUTH_EMAIL") ?>
                                </td>
                                <td><input class="register__input" type="text" name="USER_EMAIL" maxlength="255" value="<?= $arResult["USER_EMAIL"] ?>"/></td>
                            </tr>

                        <? endif ?>

                        <? if ($arResult["PHONE_REGISTRATION"]): ?>

                            <tr>
                                <td class="register__label">
                                    <? if ($arResult["PHONE_REQUIRED"]): ?>
                                        <span class="register__necessarily">*</span>
                                    <? endif ?>
                                    <?= GetMessage("main_register_phone_number") ?>
                                </td>
                                <td><input class="register__input" type="text" name="USER_PHONE_NUMBER" maxlength="255" value="<?= $arResult["USER_PHONE_NUMBER"] ?>"/></td>
                            </tr>

                        <? endif ?>

                        <? if ($arResult["USE_CAPTCHA"] == "Y"): ?>

                            <tr class="register__item">
                                <td></td>
                                <td><input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>" />
                                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA" /></td>
                            </tr>

                            <tr class="register__item">
                                <td class="register__label"><?= GetMessage("CAPTCHA_REGF_PROMT") ?>:</td>
                                <td><input class="register__input" type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" /></td>
                            </tr>

                        <? endif ?>

                        <tr class="register__item">
                            <td></td>
                            <td>
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
                            </td>
                        </tr>

                        <tr class="register__item">
                            <td></td>
                            <td class="register__button"><input type="submit" name="Register" value="<?= GetMessage("AUTH_REGISTER") ?>"/></td>
                        </tr>

                        <tr class="register__item">
                            <td></td>
                            <td class="register__requirements">
                                <div><span class="register__necessarily">*</span><?= GetMessage("AUTH_REQ") ?></div>
                                <div><?= $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></div>
                            </td>
                        </tr>

                        <tr class="register__item">
                            <td></td>
                            <td><a class="register__auth" href="<?= $arResult["AUTH_AUTH_URL"] ?>" rel="nofollow"><?= GetMessage("AUTH_AUTH") ?></a></td>
                        </tr>

                        </tbody>

                    </table>
                </form>



                <script type="text/javascript">
                    document.bform.USER_NAME.focus();
                </script>

            <? endif ?>

        </div>
    </noindex>
</div>
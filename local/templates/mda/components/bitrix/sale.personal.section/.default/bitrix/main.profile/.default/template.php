<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

?>

<div class="profile">
    <div class="profile__body">
        <form class="profile__form" method="post" name="form1" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data" role="form">

            <?=$arResult["BX_SESSION_CHECK"]?>
            <input type="hidden" name="lang" value="<?=LANG?>" />
            <input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
            <input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />

            <? if ($arResult["ID"] > 0 & ($arResult["arUser"]["TIMESTAMP_X"] <> '' || $arResult["arUser"]["LAST_LOGIN"] <> '')): ?>

                <div class="profile__item">

                    <? if ($arResult["arUser"]["TIMESTAMP_X"] <> ''): ?>

                        <b><?=Loc::getMessage('LAST_UPDATE')?> <?=$arResult["arUser"]["TIMESTAMP_X"]?></b>

                    <? endif; ?>

                    <? if ($arResult["arUser"]["TIMESTAMP_X"] <> ''): ?>

                        <b><?=Loc::getMessage('LAST_LOGIN')?> <?=$arResult["arUser"]["LAST_LOGIN"]?></b>

                    <? endif; ?>

                </div>

            <? endif; ?>

            <? if ($arResult["strProfileError"] || $arResult['DATA_SAVED'] == 'Y'): ?>

                <div class="profile__item">

                    <? if ($arResult["strProfileError"]): ?>
                        <div class="profile__error"><?ShowError($arResult["strProfileError"])?></div>
                    <? endif; ?>

                    <? if ($arResult['DATA_SAVED'] == 'Y'): ?>
                        <div class="profile__success"><?ShowNote(Loc::getMessage('PROFILE_DATA_SAVED'))?></div>
                    <? endif; ?>

                </div>

            <? endif; ?>

            <div class="profile__item">
                <label class="profile__label" for="main-profile-name"><?=Loc::getMessage('NAME')?></label>
                <input class="profile__input" type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?=$arResult["arUser"]["NAME"]?>"/>
            </div>

            <div class="profile__item">
                <label class="profile__label" for="main-profile-last-name"><?=Loc::getMessage('LAST_NAME')?></label>
                <input class="profile__input" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?=$arResult["arUser"]["LAST_NAME"]?>"/>
            </div>

            <div class="profile__item">
                <label class="profile__label" for="main-profile-second-name"><?=Loc::getMessage('SECOND_NAME')?></label>
                <input class="profile__input" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" value="<?=$arResult["arUser"]["SECOND_NAME"]?>"/>
            </div>

            <div class="profile__item">
                <label class="profile__label" for="main-profile-email"><?=Loc::getMessage('EMAIL')?></label>
                <input class="profile__input" type="text" name="EMAIL" readonly maxlength="50" id="main-profile-email" value="<?=$arResult["arUser"]["EMAIL"]?>"/>
            </div>

            <? if ($arResult['CAN_EDIT_PASSWORD']): ?>

                <div class="profile__item">
                    <label class="profile__label" for="main-profile-password"><?=Loc::getMessage('NEW_PASSWORD_REQ')?></label>
                    <input class="profile__input" type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off"/>
                </div>

                <div class="profile__item">
                    <div class="profile__small">
                        <?=$arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]?>
                    </div>
                </div>

                <div class="profile__item">
                    <label class="profile__label" for="main-profile-password-confirm"><?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?></label>
                    <input class="profile__input" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off"/>
                </div>

            <? endif; ?>

            <div class="profile__item">
                <div class="profile__button">
                    <input type="submit" name="save" value="<?=(($arResult["ID"]>0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>"/>
                    <input type="submit" name="reset" value="<?echo GetMessage("MAIN_RESET")?>"/>
                </div>
            </div>

            <div class="profile__item">

                <? if ($arResult["SOCSERV_ENABLED"]): ?>

                    <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:socserv.auth.split",
                        ".default",
                        array(
                            "SHOW_PROFILES" => "Y",
                            "ALLOW_DELETE" => "Y"
                        ),
                        false
                    );
                    ?>

                <? endif; ?>

            </div>

            <script>
                BX.Sale.PrivateProfileComponent.init();
            </script>

        </form>
    </div>
</div>
<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>

<div class="form">
    <div class="form__body">
        <form action="<?=POST_FORM_ACTION_URI?>" method="POST">

            <?=bitrix_sessid_post()?>

            <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">

            <div class="form__title">Присоединяйся к нашей команде</div>

            <div class="form__list">

                <? if(!empty($arResult["ERROR_MESSAGE"])): ?>

                    <div class="form__item">
                        <div class="form__error">
                            <? foreach($arResult["ERROR_MESSAGE"] as $error): ?>
                                <?ShowError($error)?>
                            <? endforeach; ?>
                        </div>
                    </div>

                <? endif; ?>

                <? if($arResult["OK_MESSAGE"] <> ''): ?>

                    <div class="form__item">
                        <div class="form__success">
                            <p><?=$arResult["OK_MESSAGE"]?></p>
                        </div>
                    </div>

                <? endif; ?>

                <div class="form__item">
                    <input class="form__input" placeholder="<?=(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) ? '* ' : ''?><?=GetMessage("MFT_NAME")?>" type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
                </div>

                <div class="form__item">
                    <input class="form__input" placeholder="<?=(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) ? '* ' : ''?><?=GetMessage("MFT_EMAIL")?>" type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
                </div>

                <div class="form__item">
                    <textarea class="form__textarea" placeholder="<?=(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) ? '* ' : ''?><?=GetMessage("MFT_MESSAGE")?>" name="MESSAGE" rows="3"><?=$arResult["MESSAGE"]?></textarea>
                </div>

                <?if($arParams["USE_CAPTCHA"] == "Y"):?>

                    <div class="form__item">
                        <div class="form__small"><?=GetMessage("MFT_CAPTCHA")?></div>
                    </div>

                    <div class="form__item">
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
                    </div>

                    <div class="form__item">
                        <input class="form__input" placeholder="<?=GetMessage("MFT_CAPTCHA_CODE")?>" type="text" name="captcha_word" size="30" maxlength="50" value="">
                    </div>

                <?endif;?>

                <div class="form__item">
                    <input class="form__button" type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
                </div>

            </div>


        </form>

    </div>

</div>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<div class="form">
    <div class="form__body">

        <?=$arResult["FORM_HEADER"]?>

            <div class="form__title"><?= $arResult['FORM_TITLE'] ?></div>

            <div class="form__list">

                <? if ($arResult['isFormErrors'] == 'Y' && $arResult['FORM_ERRORS_TEXT']): ?>

                    <div class="form__item">
                        <div class="form__error">
                            <?=$arResult['FORM_ERRORS_TEXT']?>
                        </div>
                    </div>

                <? endif; ?>

                <? if ($arResult['FORM_NOTE']): ?>

                    <div class="form__item">
                        <div class="form__success">
                            <?=$arResult['FORM_NOTE']?>
                        </div>
                    </div>

                <? endif; ?>

                <? foreach ($arResult['QUESTIONS'] as $FIELD_SID => $arQuestion):?>

                    <div class="form__item" data-form-input>
                        <?= $arQuestion["HTML_CODE"] ?>
                        <label class="form__label" for="<?=$FIELD_SID.'_'.$arQuestion['STRUCTURE'][0]['FIELD_ID']?>">
                            <?=($arQuestion['REQUIRED']=='Y'?'* ':'') . $arQuestion['CAPTION']?>
                        </label>
                    </div>

                <? endforeach; ?>

                <? if ($arResult["isUseCaptcha"] == "Y"): ?>

                    <div class="form__item">
                        <div class="form__small"><?= GetMessage("FORM_CAPTCHA_TABLE_TITLE") ?></div>
                    </div>

                    <div class="form__item">
                        <input type="hidden" name="captcha_sid" value="<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"/>
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>" width="180" height="40"/>
                    </div>

                    <div class="form__item">
                        <input class="form__input" id="FORM_CAPTCHA" type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext">
                        <label class="form__label" for="FORM_CAPTCHA">* <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?></label>
                    </div>

                <? endif; ?>

                <div class="form__item">
                    <div class="form__small">
                        * <?= GetMessage("FORM_REQUIRED_FIELDS") ?>
                    </div>
                </div>

                <div class="form__item">
                    <input class="button" type="submit" name="web_form_submit" value="<?= htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == '' ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>">
                </div>

            </div>

        <?=$arResult["FORM_FOOTER"]?>

    </div>

    <script>
        (function () {
            function checkInput(item, input) {
                if ($(input).val()) {
                    $(item).attr('data-form-label','');
                } else {
                    $(item).removeAttr('data-form-label');
                }
            }

            $('[data-form-input]').each(function (key, item) {
                let input = $(this).find('input,textarea');

                checkInput(this, input);

                $(input).change(function () {
                    checkInput(item, this);
                });
            });

            $('[data-phone-mask]').inputmask("+7 (999) 999-99-99");
        })();

    </script>
</div>

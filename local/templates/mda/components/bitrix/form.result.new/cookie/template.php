<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<input type="hidden" name="id" value="<?=$arResult['CONFIG']['id']?>">
<input type="hidden" name="sec" value="<?=$arResult['CONFIG']['sec']?>">
<input type="hidden" name="replace[]" value="<?=$arResult['CONFIG']['replace']?>">
<input type="hidden" name="url" value="<?=$arResult['CONFIG']['url']?>">
<input type="hidden" name="action" value="saveConsent">

<div class="cookie" data-cookie>
    <div class="cookie__body">

        <?=$arResult["FORM_HEADER"]?>

        <div class="cookie__text">
            <?=$arResult['CONFIG']['text']?>
        </div>

        <input href="<?=$arResult['CONFIG']['actionUrl']?>" type="submit" class="cookie__button button__medium" value="Понятно" data-bubble data-cookie-button>

        <?=$arResult["FORM_FOOTER"]?>

    </div>
</div>

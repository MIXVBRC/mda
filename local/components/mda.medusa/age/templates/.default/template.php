<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var AgeComponent $component */

use Bitrix\Main\Localization\Loc;

?>

<div class="age">
    <div class="age__body">
        <div class="age__img">
            <img src="/local/templates/mda/img/18.png" alt="18+">
        </div>
        <div class="age__description">
            <p>Сайт предназначен для лиц, старше 18 лет.</p>
            <p><b>Тебе есть 18?</b></p>
        </div>
        <div class="age__buttons">
            <div class="button__success" data-bubble data-age-button-yes>Да</div>
            <div class="button__error" data-bubble data-age-button-no>Нет</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        AgeComponent.init({
            ajaxUrl: '<?= CUtil::JSEscape($component->getPath() . '/ajax.php') ?>',
        });
    });
</script>




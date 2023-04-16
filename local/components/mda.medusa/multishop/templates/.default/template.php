<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);
?>
<div class="multishop">
    <div class="multishop__body">
        <span class="multishop__select" data-multishop-selected="<?=$arResult['SHOP']['XML_ID']?>">
            <i class="fa fa-shopping-basket"></i>
            <?=$arResult['SHOP']['NAME']?>
        </span>
        <div class="multishop__popup" data-multishop-question style="opacity: 0">
            <div class="multishop__popup-title">Ваш магазин: <span><?=$arResult['SELECT']['NAME']?></span></div>
            <div class="multishop__popup-buttons">
                <div class="multishop__popup-buttons-yes" data-multishop-popup-yes>Да</div>
                <div class="multishop__popup-buttons-no" data-multishop-popup-no>Сменить магазин</div>
            </div>
            <div class="multishop__popup-description">
                Выбор магазина необходим для правильного отображения ассортимента.
            </div>
        </div>
    </div>
</div>

<?
$jsParams = [
    'nodes' => [
        'selected' => '[data-multishop-selected]',
        'question' => '[data-multishop-question]',
        'yes' => '[data-multishop-popup-yes]',
        'no' => '[data-multishop-popup-no]',
    ],
    'showQuestion' => (bool) $arResult['SHOW_QUESTION'],
    'shops' => array_values($arResult['SHOPS']),
    'shop' => $arResult['SHOP'],
    'cookieName' => 'BITRIX_SM_' . $arParams['COOKIE_NAME'],
];
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        MultiShop.init(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    });
</script>

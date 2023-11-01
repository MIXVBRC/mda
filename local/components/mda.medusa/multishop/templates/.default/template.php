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
        <div class="multishop__select" data-multishop-shop="<?=$arResult['SHOP']['XML_ID']?>">
            <i class="fa fa-shopping-basket"></i>
            <span><?=$arResult['SHOP']['NAME']?></span>
        </div>
        <? if ($arResult['SHOP']['PHONE']): ?>
            <div class="multishop__phone">
                <a href="tel:<?=$arResult['SHOP']['PHONE']?>"><?=$arResult['SHOP']['PHONE']?></a>
            </div>
        <? endif; ?>
        <div class="multishop__popup" data-multishop-select>
            <ul class="multishop__list">
                <? foreach ($arResult['SHOPS'] as $shop): ?>
                    <? if ($arResult['SHOP']['XML_ID'] === $shop['XML_ID']) continue;?>
                    <li class="multishop__item" data-multishop-shops-item="<?=$shop['XML_ID']?>">
                        <?=$shop['NAME']?>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>
        <div class="multishop__popup" data-multishop-question>
            <div class="multishop__popup-title">Ваш магазин: <span><?=$arResult['SHOP']['NAME']?></span></div>
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
        'shop' => '[data-multishop-shop]',
        'shopsItem' => '[data-multishop-shops-item]',
        'select' => '[data-multishop-select]',
        'question' => '[data-multishop-question]',
        'yes' => '[data-multishop-popup-yes]',
        'no' => '[data-multishop-popup-no]',
    ],
    'showQuestion' => (bool) $arResult['SHOW_QUESTION'],
    'shops' => array_values($arResult['SHOPS']),
    'shop' => $arResult['SHOP'],
    'templateFolder' => $templateFolder,
    'animationTime' => 300,
];
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        MultiShop.init(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    });
</script>

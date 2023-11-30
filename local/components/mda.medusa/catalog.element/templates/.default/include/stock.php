<?
/**
 * @global CMain $APPLICATION
 * @var array $itemIds
 * @var array $actualItem
 * @var array $arParams
 * @var array $arResult
 * @var bool $showAddBtn
 * @var bool $showBuyBtn
 * @var CatalogSectionComponent $component
 */
?>

<div style="color: #fff; margin: 10px 0">

    <? if (!$arResult['HAVE_OFFERS']): ?>

        <div>Наличие: <span><?=$arResult['STOCK']?></span></div>

    <? elseif (count($arResult['OFFERS']) > 1): ?>
        <div style="margin-bottom: 10px">Наличие:</div>
        <ul style="margin-left: 10px">

            <? foreach ($arResult['OFFERS'] as $offer): ?>

                <li>
                    <span>
                        <?=$offer['STOCK']?> - <?=$offer['PROPERTIES']['CML2_ATTRIBUTES']['VALUE'][0]?>
                    </span>
                </li>

            <? endforeach; ?>

        </ul>
    <? else:?>

        <div>Наличие: <span><?=$arResult['OFFERS'][0]['STOCK']?></span></div>

    <? endif; ?>

</div>


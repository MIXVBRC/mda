<?
/**
 * @var array $itemIds
 * @var bool $haveOffers
 */
?>

<?if ($haveOffers && !empty($arResult['OFFERS_PROP'])):?>

    <div class="element__properties" id="<?=$itemIds['TREE_ID']?>">

        <div class="element__properties-title">Предложения</div>

        <?foreach ($arResult['SKU_PROPS'] as $skuProperty):?>

            <?
            if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']])) continue;
            $propertyId = $skuProperty['ID'];
            $skuProps[] = [
                'ID' => $propertyId,
                'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                'VALUES' => $skuProperty['VALUES'],
                'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
            ];
            ?>

            <div class="element__properties-sky-element" data-entity="sku-line-block">

                <div class="element__properties-sky-title"><?=htmlspecialcharsEx($skuProperty['NAME'])?>:</div>

                <ul class="element__properties-sky-list">

                    <? foreach ($skuProperty['VALUES'] as &$value):?>

                        <?$value['NAME'] = htmlspecialcharsbx($value['NAME']);?>

                        <?if ($skuProperty['SHOW_MODE'] === 'PICT'):?>

                            <li class="element__properties-sky-item" title="<?=$value['NAME']?>" data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                <div class="element__properties-sky-item-img" title="<?=$value['NAME']?>" style="background-image: url('<?=$value['PICT']['SRC']?>');"></div>
                            </li>

                        <? else: ?>

                            <li class="element__properties-sky-item" title="<?=$value['NAME']?>" data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                <?=$value['NAME']?>
                            </li>

                        <?endif;?>

                    <? endforeach; ?>

                </ul>
            </div>

        <?endforeach;?>

    </div>

<?endif;?>

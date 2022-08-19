<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $itemIds
 * @var array $item
 * @var array $actualItem
 * @var array $price
 * @var CatalogSectionComponent $component
 * @var array $minOffer
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var string $measureRatio
 * @var string $buttonSizeClass
 */
?>

<? if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $haveOffers && !empty($item['OFFERS_PROP'])):?>

    <div class="list1__properties" id="<?=$itemIds['PROP_DIV']?>">

        <? foreach ($arParams['SKU_PROPS'] as $skuProperty):?>

            <?
            $propertyId = $skuProperty['ID'];
            if (!isset($item['SKU_TREE_VALUES'][$propertyId])) continue;
            $skuProps[] = array(
                'ID' => $skuProperty['ID'],
                'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                'VALUES' => $skuProperty['VALUES'],
                'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
            );
            ?>

            <div class="list1__properties-sky-element" data-entity="sku-line-block">

                <div class="list1__properties-sky-title"><?=htmlspecialcharsEx($skuProperty['NAME'])?>:</div>

                <ul class="list1__properties-sky-list">

                    <? foreach ($skuProperty['VALUES'] as $value):?>

                        <?
                        if (!isset($item['SKU_TREE_VALUES'][$propertyId][$value['ID']]))  continue;
                        $value['NAME'] = htmlspecialcharsbx($value['NAME']);
                        ?>

                        <?if ($skuProperty['SHOW_MODE'] === 'PICT'):?>

                            <li class="list1__properties-sky-item" title="<?=$value['NAME']?>" data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                <div class="list1__properties-sky-item-img" title="<?=$value['NAME']?>" style="background-image: url('<?=$value['PICT']['SRC']?>');"></div>
                            </li>

                        <?else:?>

                            <li class="list1__properties-sky-item" title="<?=$value['NAME']?>" data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                <?=$value['NAME']?>
                            </li>

                        <?endif;?>

                    <?endforeach; ?>

                </ul>
            </div>

        <?endforeach;?>

    </div>

<?endif;

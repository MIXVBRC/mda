<?
/**
 * @var array $arResult
 */
?>
<?if ((!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) && !empty($arResult['DISPLAY_PROPERTIES'])):?>

    <div class="element__properties">

        <div class="element__properties-title">Характеристики</div>

        <ul class="element__properties-list">

            <?foreach ($arResult['DISPLAY_PROPERTIES'] as $property):?>

                <li class="element__properties-item">
                    <div class="element__properties-name"><?=$property['NAME']?>:</div>
                    <div class="element__properties-value">
                        <? if (is_array($property['DISPLAY_VALUE'])){
                            echo implode(' / ', $property['DISPLAY_VALUE']);
                        } else {
                            echo $property['DISPLAY_VALUE'];
                        } ?>
                    </div>
                </li>

            <?endforeach; unset($property);?>

        </ul>
    </div>

<?endif;?>
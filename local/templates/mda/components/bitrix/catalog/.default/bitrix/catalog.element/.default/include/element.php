<?
/**
 * @var array $itemIds
 * @var array $arParams
 * @var array $arResult
 */
?>
<div class="element" id="<?=$itemIds['ID']?>">
        <div class="element__body">
            <div>
                <?require_once __DIR__ . '/image.php';?>
            </div>

            <div>
                <div class="element__info">

                    <?if ($arResult['DETAIL_TEXT']):?>
                        <div class="element__description">
                            <div class="element__description-title">Описание</div>
                            <div class="element__description-text"><?=$arResult['DETAIL_TEXT']?></div>
                        </div>
                    <?endif;?>

                    <?
                    foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName)
                    {
                        switch ($blockName)
                        {
                            case 'sku':
                                require_once __DIR__ . '/sku.php';
                                break;

                            case 'props':
                                require_once __DIR__ . '/props.php';
                                break;
                        }
                    }
                    ?>

                    <div class="element__buy-container">

                        <?
                        foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName)
                        {
                            switch ($blockName)
                            {
//                            case 'rating':
//                                require_once __DIR__ . '/rating.php';
//                                break;
//
//                            case 'priceRanges':
//                                require_once __DIR__ . '/priceRanges.php';
//                                break;
//
//                            case 'quantityLimit':
//                                require_once __DIR__ . '/quantityLimit.php';
//                                break;

                                case 'price':
                                    require_once __DIR__ . '/price.php';
                                    break;

                                case 'quantity':
                                    if (MDA_SITE_MODE_SALE) require_once __DIR__ . '/quantity.php';
                                    break;

                                case 'buttons':
                                    if (MDA_SITE_MODE_SALE) require_once __DIR__ . '/buttons.php';
                                    break;
                            }
                        }
                        ?>

                    </div>

                </div>
            </div>

        </div>
    </div>
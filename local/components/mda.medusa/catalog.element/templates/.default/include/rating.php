<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 */
?>

<?if ($arParams['USE_VOTE_RATING'] === 'Y')
{
    ?>
    <div>
        <?php
        $APPLICATION->IncludeComponent(
            'bitrix:iblock.vote',
            'stars',
            array(
                'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'ELEMENT_ID' => $arResult['ID'],
                'ELEMENT_CODE' => '',
                'MAX_VOTE' => '5',
                'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
                'SET_STATUS_404' => 'N',
                'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                'CACHE_TIME' => $arParams['CACHE_TIME']
            ),
            $component,
            array('HIDE_ICONS' => 'Y')
        );
        ?>
    </div>
    <?php
}
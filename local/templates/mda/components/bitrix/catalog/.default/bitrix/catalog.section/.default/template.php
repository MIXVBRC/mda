<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |	Attention!
 * |	The following comments are for system use
 * |	and are required for the component to work correctly in ajax mode:
 * |	<!-- items-container -->
 * |	<!-- pagination-container -->
 * |	<!-- component-end -->
 */

$this->setFrameMode(true);

if (!empty($arResult['NAV_RESULT']))
{
	$navParams =  array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
}
else
{
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
	$showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}
?>

<?if ($showTopPager):?>
	<div data-pagination-num="<?=$navParams['NavNum']?>">
		<?=$arResult['NAV_STRING']?>
	</div>
<?endif;?>

<div class="list1">
    <div class="container">
        <div class="list1__body">
            <div class="list1__list">

                <?
                $elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
                $elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
                $elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
                ?>

                <?foreach ($arResult['ITEMS'] as $arItem):?>

                <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);

                    $img = $arItem['DETAIL_PICTURE']['SRC'] ? $arItem['DETAIL_PICTURE']['SRC'] : SITE_TEMPLATE_PATH.'/img/noimg.png'
                ?>

                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="list1__item"  id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                    <div class="list1__img">
                        <img class="img__cover" src="<?=$img?>" alt="<?=$arItem['DETAIL_PICTURE']['ALT']?>">
                    </div>
                    <div class="list1__name"><?=$arItem['NAME']?></div>
                    <div class="list1__price"><?=$arItem['PRICES'][$arParams['PRICE_CODE'][0]]['PRINT_VALUE']?></div>
                </a>
                <?endforeach;?>
            </div>
        </div>
    </div>
</div>

<? if ($showBottomPager):?>
	<div data-pagination-num="<?=$navParams['NavNum']?>">
		<?=$arResult['NAV_STRING']?>
	</div>
<?endif;?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
?>

<?if ($arResult["ITEMS"]):?>
    <section class="news">
        <div class="container">
            <h2 class="news__title main__title">Новости</h2>
            <div class="news__body">
                <div class="news__list">

                    <?foreach($arResult["ITEMS"] as $arItem):?>

                    <?
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>

                    <a class="news__item" href="<?=$arItem['DETAIL_PAGE_URL']?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="news__name"><?=$arItem['NAME']?></div>
                        <div class="news__description"><?=$arItem['PREVIEW_TEXT']?></div>
                    </a>

                    <?endforeach;?>

                </div>

                <div class="news__right">
                    <?if ($arResult['IMAGE']):?>
                        <img src="<?=$arResult['IMAGE']?>">
                    <?endif;?>
                </div>

            </div>
        </div>
    </section>
<?endif;?>


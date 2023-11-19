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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$itemDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if ($arResult['ITEMS']):?>

    <section class="popular">
        <div class="container">
            <h2 class="popular__title main__title">Популярное</h2>
            <div class="popular__body">
                <div class="popular__list">

                    <?foreach ($arResult['ITEMS'] as $item):?>

                        <?
                        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $strSectionEdit);
                        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $strSectionDelete, $itemDeleteParams);
                        ?>

                        <div class="popular__item" id="<?=$this->GetEditAreaId($item['ID'])?>">
                            <a href="<?=$item['DETAIL_PAGE_URL']?>" class="popular__link">
                                <img src="<?=$item['PREVIEW_PICTURE']['SRC']?:MDA_NO_PHOTO;?>" alt="<?=$item['NAME']?>" class="popular__img img__cover">
                                <div class="popular__name"><?=$item['NAME']?></div>
                            </a>
                        </div>

                    <?endforeach;?>

                </div>

                <div class="popular__right">
                    <?if ($arResult['IMAGE']):?>
                        <img class="img__cover" src="<?=$arResult['IMAGE']?>">
                    <?endif;?>
                </div>

            </div>
        </div>
    </section>

<?endif;?>



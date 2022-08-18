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
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if ($arResult['SECTIONS']):?>

    <section class="popular">
        <div class="container">
            <h2 class="popular__title main__title">Популярное</h2>
            <div class="popular__body">
                <div class="popular__list">

                    <?foreach ($arResult['SECTIONS'] as $arSection):?>

                    <?
                    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
                    ?>

                        <div class="popular__item" id="<?=$this->GetEditAreaId($arSection['ID'])?>">
                            <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="popular__link">
                                <img src="<?=$arSection['PICTURE']['SRC']?>" alt="<?=$arSection['PICTURE']['ALT']?>" class="popular__img img__cover">
                                <div class="popular__name"><?=$arSection['NAME']?></div>
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
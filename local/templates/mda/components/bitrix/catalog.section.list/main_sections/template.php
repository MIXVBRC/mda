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

    <section class="sections-main">
        <div class="container">
            <div class="sections-main__body">
                <div class="sections-main__list">

                    <?foreach ($arResult['SECTIONS'] as $arSection):?>

                    <?
                        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
                    ?>

                        <div class="sections-main__item" id="<?=$this->GetEditAreaId($arSection['ID'])?>">
                            <a class="sections-main__link" href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a>
                        </div>

                    <?endforeach;?>

                </div>

                <div class="sections-main__img">
                    <?if ($arResult['IMAGE']):?>
                        <img class="img__contain" src="<?=$arResult['IMAGE']?>">
                    <?endif;?>
                </div>

            </div>
        </div>
    </section>

<?endif;?>
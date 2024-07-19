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
$this->setFrameMode(false);

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if ($arResult["SECTIONS_COUNT"] > 0 && $arResult['SECTIONS']):?>

    <div class="sections-mini">
        <div class="sections-mini__body">
            <div class="sections-mini__list">

                <?foreach ($arResult['SECTIONS'] as $arSection):?>

                    <?
                    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
                    ?>

                    <div class="sections-mini__item" id="<?=$this->GetEditAreaId($arSection['ID'])?>">
                        <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="sections-mini__link"><?=$arSection['NAME']?></a>
                    </div>

                <?endforeach;?>
            </div>
        </div>
    </div>

<?endif;?>
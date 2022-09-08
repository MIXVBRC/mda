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

<? if ($arResult["ITEMS"]): ?>

    <div class="advantage">
        <div class="container">
            <div class="advantage__body">
                <div class="advantage__list">

                    <?foreach($arResult["ITEMS"] as $arItem):?>

                        <?
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>

                        <div class="advantage__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <div class="advantage__icon">

                                <?if ($arItem['PROPERTIES']['SHOW_ICON']['VALUE'] == 'Y'):?>

                                    <i class="fa fa-<?=$arItem['PROPERTIES']['ICON']['VALUE']?>"></i>

                                <?else:?>

                                    <img src="<?=$arItem["PREVIEW_PICTURE"]['URL']?>" alt="<?=$arItem["PREVIEW_PICTURE"]['ALT']?>">

                                <?endif;?>

                            </div>
                            <div class="advantage__name"><?=$arItem['NAME']?></div>
                        </div>

                    <?endforeach;?>

                </div>
            </div>
        </div>
    </div>

<?endif;?>
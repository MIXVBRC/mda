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
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>

<?if ($arResult["ITEMS"]):?>
    <div class="list2">
        <div class="list2__body">
            <div class="list2__list">

                <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    $picture = $arItem["PREVIEW_PICTURE"] ?: $arItem["DETAIL_PICTURE"];
                ?>

                <a class="list2__item" href="<?=$arItem['PROPERTIES']['EXTERNAL_LINK']['VALUE']?:$arItem['DETAIL_PAGE_URL']?>" <?= $arItem['PROPERTIES']['EXTERNAL_LINK']['VALUE']? 'target="_blank"' : '' ?> id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="list2__item-img">

                        <?/*
                        <img class="img__cover" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
                        */?>

                        <?= getPictureSource(
                            $picture,
                            [
                                "min"=> [
                                    1200 => 303
                                ],
                                "max"=>[
                                    320 => 286,
                                    575 => 541,
                                    767 => 733,
                                    991 => 353,
                                    1199 => 303
                                ]
                            ],
                            0
                        ); ?>

                    </div>
                    <div class="list2__item-info">
                        <div class="list2__item-info-name"><?=$arItem['NAME']?></div>
                        <div class="list2__item-info-description"><?=$arItem['PREVIEW_TEXT']?></div>
                    </div>
                </a>

                <?endforeach;?>

            </div>
        </div>
    </div>
<?endif;?>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>
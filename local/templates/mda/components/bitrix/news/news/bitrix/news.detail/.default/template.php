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

pre($arResult['DETAIL_PICTURE']['SRC']);
getPictureSource(
    $arResult["DETAIL_PICTURE"],
    [
        "min"=> [
            1200 => 848
        ],
        "max"=>[
            260 => 290,
            575 => 515,
            767 => 707,
            991 => 691,
            1199 => 668
        ]
    ],
    0
)
?>
<div class="detail1">
    <div class="container">
        <div class="detail1__body">
            <div class="detail1__img">
                <img class="img__cover" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResult['DETAIL_PICTURE']['ALT']?>">
            </div>

            <div class="detail1__description"><?=$arResult['DETAIL_TEXT']?></div>
        </div>
        <a href="<?=$arResult['LIST_PAGE_URL']?>" class="back-button">Назад</a>
    </div>
</div>
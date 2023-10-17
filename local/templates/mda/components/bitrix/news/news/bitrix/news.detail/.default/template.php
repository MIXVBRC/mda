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

$picture = $arResult["PREVIEW_PICTURE"] ?: $arResult["DETAIL_PICTURE"];
?>
<div class="detail1">
    <div class="detail1__body">
        <div class="detail1__img">
            <?/*
            <img class="img__cover" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResult['DETAIL_PICTURE']['ALT']?>">
            */?>
            <?= getPictureSource(
                $picture,
                [
                    "min"=> [
                        1200 => 732
                    ],
                    "max"=>[
                        260 => 192,
                        575 => 507,
                        767 => 699,
                        991 => 732,
                        1199 => 732
                    ]
                ],
                0
            ); ?>
        </div>

        <div class="detail1__description"><?=$arResult['DETAIL_TEXT']?></div>
    </div>
    <a href="<?=$arResult['BACK_URL']?>" class="back-button button">Назад</a>
</div>
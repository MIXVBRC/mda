<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

if($arResult["FILE"] <> ''): ?>
    <a href="tel:<?include($arResult["FILE"]);?>"><?if ($arParams['ICON']):?><i class="fa fa-<?=$arParams['ICON']?>"></i><?endif;?><?include($arResult["FILE"]);?></a>
<? endif; ?>


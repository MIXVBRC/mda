<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<div class="pagenavigation">
	<div class="container">
		<ul class="pagenavigation__list">

            <?if ($arResult["NavPageNomer"] > 1):?>
                <?if($arResult["bSavePage"]):?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><span>1</span></a></li>
                <?else:?>
                    <?if ($arResult["NavPageNomer"] > 2):?>
                        <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
                    <?else:?>
                        <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
                    <?endif?>
                    <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span>1</span></a></li>
                <?endif?>
            <?else:?>
                    <li><span><?echo GetMessage("round_nav_back")?></span></li>
                    <li data-select><span>1</span></li>
            <?endif?>

            <?if ($arResult["nStartPage"]>1):?>
                <li><span>...</span></li>
            <?endif?>

            <?$arResult["nStartPage"]++;?>
            <?while($arResult["nStartPage"] <= $arResult["nEndPage"]-1):?>
                <?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                    <li data-select><span><?=$arResult["nStartPage"]?></span></li>
                <?else:?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><span><?=$arResult["nStartPage"]?></span></a></li>
                <?endif?>
                <?$arResult["nStartPage"]++?>
            <?endwhile?>

            <?if ($arResult["nEndPage"]<$arResult["NavPageCount"]):?>
                <li><span>...</span></li>
            <?endif?>

            <?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
                <?if($arResult["NavPageCount"] > 1):?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><span><?=$arResult["NavPageCount"]?></span></a></li>
                <?endif?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span><?echo GetMessage("round_nav_forward")?></span></a></li>
            <?else:?>
                <?if($arResult["NavPageCount"] > 1):?>
                    <li data-select><span><?=$arResult["NavPageCount"]?></span></li>
                <?endif?>
                    <li><span><?echo GetMessage("round_nav_forward")?></span></li>
            <?endif?>
		</ul>
	</div>
</div>

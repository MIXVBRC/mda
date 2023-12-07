<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '<div class="breadcrumbs"><div class="breadcrumbs__list">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	if ($index == 0) {
		$title = 'MDA';
	} else {
		$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	}

	$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
        $strReturn .= '<div class="breadcrumbs__item"><a href="'.$arResult[$index]["LINK"].'" class="breadcrumbs__link">'.$title.'</a></div>';
	}
	else
	{
        $strReturn .= '<div class="breadcrumbs__item"><span class="breadcrumbs__link">'.$title.'</span></div>';
	}
}

$strReturn .= '</div></div>';

return $strReturn;

?>

<?php

/**
 * @return int
 */
function getUserID()
{
    global $USER;
    return (int) $USER->GetID();
}

/**
 * @return bool
 */
function isMainPage()
{
    global $APPLICATION;
    return $APPLICATION->GetCurPage(false) == '/';
}

/**
 * @return bool
 */
function isAdmin()
{
    global $USER;
    if ($USER->IsAdmin()) return true;
    return false;
}

/**
 * @return bool
 */
function isAuth()
{
    global $USER;
    if ($USER->IsAuthorized()) return true;
    return false;
}

/**
 * @param $data
 * @param bool $die
 * @param bool $var_dump
 */
function pre($data, $die = false, $var_dump = false)
{
    if (!isAdmin()) return;

    echo "<pre>";
    $var_dump ? var_dump($data) : print_r($data);
    echo "</pre>";

    if ($die) die;
}

/**
 * @param $data
 * @param bool $add
 */
function fpc($data, $add = false)
{
    if (!isAdmin()) return;

    if ($add)
        file_put_contents(__DIR__.'/log.txt', print_r($data, true). PHP_EOL, FILE_APPEND);
    else
        file_put_contents(__DIR__.'/log.txt', print_r($data, true));
}

/**
 * @param $image
 * @param $arSizeInfo
 * @param $minHeight
 */
function getPictureSource($image, $arSizeInfo, $minHeight)
{
    foreach ($arSizeInfo as $minmax => $arSize) {
        foreach ($arSize as $windows => $size) {
            $arImageInfo = getimagesize(str_replace(" ", "%20", $_SERVER["DOCUMENT_ROOT"] . $image["SRC"]));
            $width = $size;
            $height = $arImageInfo[1] / ($arImageInfo[0] / $width);
            if ($height < $minHeight) {
                $height = $minHeight;
                $width = $arImageInfo[0] / ($arImageInfo[1] / $minHeight);
            }
            $arImage = CFile::ResizeImageGet($image, ["width"=>$width,"height"=>$height]);
            echo "<source type=\"{$arImageInfo['mime']}\" media=\"({$minmax}-width:{$windows}px)\" srcset=\"{$arImage['src']}\">";
        }
    }
}
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
function pre($data, $var_dump = false, $die = false)
{
    if (!isAdmin()) return;

    echo "<pre style=\"color: #000 !important; background-color: #fff !important; padding: 15px;\">";
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
 *
 * Пример использования в компоненте news.detail:

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

 * Данный пример вернет:

<picture>
    <source type="image/png" media="(min-width:1200px)" srcset="/upload/resize_cache/iblock/7b9/848_477_1/image.png">
    <source type="image/png" media="(max-width:260px)" srcset="/upload/resize_cache/iblock/7b9/290_163_1/image.png">
    <source type="image/png" media="(max-width:575px)" srcset="/upload/resize_cache/iblock/7b9/515_289_1/image.png">
    <source type="image/png" media="(max-width:767px)" srcset="/upload/resize_cache/iblock/7b9/707_397_1/image.png">
    <source type="image/png" media="(max-width:991px)" srcset="/upload/resize_cache/iblock/7b9/691_388_1/image.png">
    <source type="image/png" media="(max-width:1199px)" srcset="/upload/resize_cache/iblock/7b9/668_375_1/image.png">
    <img srcset="./upload/iblock/7b9/image.png" alt="Lorem 3">
</picture>

 * min и max в массиве:
 *     ключ - размер дисплея
 *     значение - ширина изображения
 */
function getPictureSource($image, $arSizeInfo, $minHeight)
{
    $result = '<picture>';

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
            $result .= "<source type=\"{$arImageInfo['mime']}\" media=\"({$minmax}-width:{$windows}px)\" srcset=\"{$arImage['src']}\">";
        }
    }

    $result .= "<img srcset=\".{$image["SRC"]}\" alt=\"{$image["ALT"]}\">";
    $result .= '</picture>';

    return $result;
}
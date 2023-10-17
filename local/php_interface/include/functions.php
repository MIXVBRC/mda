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
 * @param bool $var_dump
 * @param bool $die
 */
function pre($data, $var_dump = false, $die = false)
{
    if (!isAdmin()) return;

    $style = 'background-color: #fff; color:#000; padding: 10px; border-radius: 5px;';

    $trace = debug_backtrace();
    $file = str_replace($_SERVER["DOCUMENT_ROOT"], '', $trace[0]['file']);
    $arInfo = $file.':'.$trace[0]['line'];

    echo '<pre style="'.$style.'">';
    print_r($arInfo);
    echo '<br>';
    $var_dump ? var_dump($data) : print_r($data);
    echo '</pre>';


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
 * @return string
 *
 * <pre>
 * min и max в массиве $arSizeInfo:
 * ключ - размер дисплея
 * значение - визуально отображаемая ширина изображения
 *
 * Пример использования в компоненте news.detail:
 *
 * echo getPictureSource(
 *     $arResult["DETAIL_PICTURE"],
 *     [
 *         "min"=> [
 *             1200 => 848
 *         ],
 *         "max"=>[
 *             260 => 290,
 *             575 => 515,
 *             767 => 707,
 *             991 => 691,
 *             1199 => 668
 *         ]
 *     ],
 *     0
 * )
 *
 * Данный пример вернет:
 *
 * &lt;picture&gt;
 *     &lt;source type="image/png" media="(min-width:1200px)" srcset="/upload/resize_cache/iblock/7b9/848_477_1/image.png"&gt;
 *     &lt;source type="image/png" media="(max-width:260px)" srcset="/upload/resize_cache/iblock/7b9/290_163_1/image.png"&gt;
 *     &lt;source type="image/png" media="(max-width:575px)" srcset="/upload/resize_cache/iblock/7b9/515_289_1/image.png"&gt;
 *     &lt;source type="image/png" media="(max-width:767px)" srcset="/upload/resize_cache/iblock/7b9/707_397_1/image.png"&gt;
 *     &lt;source type="image/png" media="(max-width:991px)" srcset="/upload/resize_cache/iblock/7b9/691_388_1/image.png"&gt;
 *     &lt;source type="image/png" media="(max-width:1199px)" srcset="/upload/resize_cache/iblock/7b9/668_375_1/image.png"&gt;
 *     &lt;img srcset="./upload/iblock/7b9/image.png" alt="image">
 * &lt;/picture>
 *
 * </pre>
 *
 */
function getPictureSource($image, $arSizeInfo, $minHeight)
{
    if (empty($image)) return;

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
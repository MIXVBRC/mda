<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// Namespace D7
use Bitrix\Main\Page\Asset;
?>
<?
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID;?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $APPLICATION->ShowTitle() ?></title>

    <?
    // Для подключения css
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.min.css");

    // Для подключения скриптов
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/script.js");

    // Для вывода строки в секцию <head> ... </head>, например можно добавить шрифт
    Asset::getInstance()->addString("<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">");
    Asset::getInstance()->addString("<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>");
    Asset::getInstance()->addString("<link href=\"https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap\" rel=\"stylesheet\">");
    ?>

    <?$APPLICATION->ShowHead();?>
</head>
<body style="background-image: url('<?=SITE_TEMPLATE_PATH?>/img/ef.png'), url('<?=SITE_TEMPLATE_PATH?>/img/prop.png');">

<div class="content">

    <?$APPLICATION->ShowPanel();?>

    <header class="header" data-header>
        <a href="<?= (isMainPage() ? "javascript:void(0)" : "/") ?>" class="logo">
            <img class="logo__file" src="<?=SITE_TEMPLATE_PATH?>/img/logo_header.png" alt="Logo">
        </a>
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "menu_top",
            array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "left",
                "DELAY" => "N",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "ROOT_MENU_TYPE" => "top",
                "USE_EXT" => "N",
                "COMPONENT_TEMPLATE" => "menu_top"
            ),
            false
        );
        ?>
        <div class="burger" data-menu-burger><span></span></div>
    </header>

    <div class="main">

        <? if (!isMainPage()): ?>
        <div class="title">
            <div class="container">
                <h1 class="title__text"><?$APPLICATION->ShowTitle(false);?></h1>

                <?$APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "",
                    Array(
                        "PATH" => "",
                        "SITE_ID" => "s1",
                        "START_FROM" => "0"
                    )
                );?><br>

            </div>

        </div>
        <? endif; ?>

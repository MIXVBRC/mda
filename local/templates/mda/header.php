<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

// Namespace D7
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID;?>">
<head>
    <style>html {background-color: #15151B;}</style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?$APPLICATION->ShowTitle()?></title>

    <?
    // Для подключения css
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/swiper-bundle.min.css");

    // Для подключения скриптов
    CJSCore::Init(['jquery3']); // \bitrix\modules\main\jscore.php
//    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.inputmask.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/script.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/swiper-bundle.min.js");

    // Для вывода строки в секцию <head> ... </head>, например можно добавить шрифт
    Asset::getInstance()->addString("<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">");
    Asset::getInstance()->addString("<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>");
    Asset::getInstance()->addString("<link href=\"https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap\" rel=\"stylesheet\">");
    ?>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(95265911, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/95265911" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZHFB705W5Z"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-ZHFB705W5Z');
    </script>
    <!-- /Google tag (gtag.js) -->

    <?$APPLICATION->ShowHead();?>
</head>
<body style="background-image: url('<?=SITE_TEMPLATE_PATH?>/img/ef.png'), url('<?=SITE_TEMPLATE_PATH?>/img/prop.png');">

<?if ($APPLICATION->GetDirProperty('MDA_LOGO') == 'Y'):?>
    <div class="mda-bg"></div>
<?endif;?>

<div class="content">

    <header class="header" data-header>

        <?$APPLICATION->ShowPanel();?>
        
        <div class="header__body">
            <div class="header__body-top">
                <div class="container">
                    <?
                    $APPLICATION->IncludeComponent(
	"mda.medusa:multishop", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"FILTER_NAME" => "multiShopFilter",
		"COOKIE_NAME" => "MDA_MULTI_SHOP",
		"PRODUCTS_FILTER_NAME" => "multiShopProducts",
		"SECTIONS_FILTER_NAME" => "multiShopSections"
	),
	false,
	array(
		"HIDE_ICONS" => MDA_HIDE_ICONS
	)
);
                    ?>
                </div>
            </div>
            <div class="header__body-down">
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
                        "USE_EXT" => "Y",
                        "COMPONENT_TEMPLATE" => "menu_top",
                        "IBLOCK_SECTIONS" => array(
                        )
                    ),
                    false,
                    array(
                        "HIDE_ICONS" => MDA_HIDE_ICONS
                    )
                );
                ?>
            </div>
        </div>
    </header>

    <div class="main">

        <? if (!isMainPage()): ?>

            <div class="title">
                <div class="container">

                    <?if ($APPLICATION->GetDirProperty('HIDE_TITLE') != 'Y'):?>

                        <h1 class="title__text"><?$APPLICATION->ShowTitle(false);?></h1>


                        <?$APPLICATION->IncludeComponent(
                            "bitrix:breadcrumb",
                            "",
                            Array(
                                "PATH" => "",
                                "SITE_ID" => "s1",
                                "START_FROM" => "0"
                            ),
                            false,
                            array(
                                "HIDE_ICONS" => MDA_HIDE_ICONS
                            )
                        );?>

                    <? endif; ?>

                </div>
            </div>

            <div class="container" style="color:<?= $APPLICATION->GetDirProperty('TEXT_COLOR')?:'initial' ?>;">

        <? endif; ?>

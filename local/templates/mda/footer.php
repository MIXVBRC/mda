<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>

<? if (!isMainPage()): ?>
</div>
<?endif;?>

</div>

</div>

<footer class="footer">
    <div class="container">
        <div class="footer__body">
            <div class="phone">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "phone",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/phone.php",
                        "ICON" => "phone"
                    )
                );?>
            </div>

            <?
            $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "menu_bottom",
                array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "bottom",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "bottom",
                    "USE_EXT" => "N",
                    "COMPONENT_TEMPLATE" => "menu_bottom"
                ),
                false
            );
            ?>

            <div class="logo"><img class="img__contain" src="<?=SITE_TEMPLATE_PATH?>/img/mda_w.png" alt=""></div>
        </div>
    </div>
</footer>

<? if (MDA_SITE_MODE_SALE): ?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:sale.basket.basket.line",
        "",
        Array(
            "HIDE_ON_BASKET_PAGES" => "Y",
            "PATH_TO_AUTHORIZE" => "",
            "PATH_TO_BASKET" => SITE_DIR."personal/order/",
            "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
            "PATH_TO_PERSONAL" => SITE_DIR."personal/",
            "PATH_TO_PROFILE" => SITE_DIR."personal/",
            "PATH_TO_REGISTER" => SITE_DIR."login/",
            "POSITION_FIXED" => "N",
            "SHOW_AUTHOR" => "N",
            "SHOW_EMPTY_VALUES" => "Y",
            "SHOW_NUM_PRODUCTS" => "Y",
            "SHOW_PERSONAL_LINK" => "N",
            "SHOW_PRODUCTS" => "N",
            "SHOW_REGISTRATION" => "N",
            "SHOW_TOTAL_PRICE" => "N"
        ),
        array("HIDE_ICONS" => MDA_HIDE_ICONS)
    );?>

    <a href="<?=(isAuth() ? '/personal/' : '/auth/')?>" class="personal-small" title="Персональный кабинет"></a>

<?endif;?>

<div class="popup" data-popup>
    <div class="popup__body">
        <div class="popup__close" data-popup-close></div>
        <div class="popup__content" data-popup-content></div>
    </div>
</div>

<?
$APPLICATION->IncludeComponent(
	"mda.medusa:cookie.userconsent", 
	".default", 
	array(
		"ID" => "2",
		"IS_CHECKED" => "Y",
		"IS_LOADED" => "Y",
		"AUTO_SAVE" => "Y",
		"SUBMIT_EVENT_NAME" => "cookie",
		"AJAX_MODE" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "cookie"
	),
	false
);
?>

</body>
</html>
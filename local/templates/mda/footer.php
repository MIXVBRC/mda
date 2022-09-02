<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>

</div>

</div>

<footer class="footer">
    <div class="container">

        <div class="phone">
            <i class="fa fa-phone"></i>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "phone",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "EDIT_TEMPLATE" => "",
                    "PATH" => "/include/phone.php"
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
</footer>

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
    )
);?>

<a href="/personal/" class="personal-small"></a>

</body>
</html>
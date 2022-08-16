<? require_once ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");?>
<?$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket.line",
    "store_v3",
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
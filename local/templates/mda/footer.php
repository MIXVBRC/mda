<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>

</div>

</div>

<footer class="footer">
    <div class="container">

        <div class="phone">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
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
</body>
</html>
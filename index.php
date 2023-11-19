<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("MDA");
?>

<section class="slider">
    <div class="slider__list">
        <div class="slider__item">
            <div class="anaglyph" data-audio>
                <svg viewBox="0 0 1088 362" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 360.387V0H158.306L209.276 227.865L262.045 0H417.353V360.387H313.614L317.212 103.139L250.052 360.387H167.901L99.541 103.139L103.739 360.387H0Z"/>
                    <path d="M524.678 115.732V90.5464L584.043 93.5447C640.649 102.659 650.403 155.308 648.205 180.493C651.563 246.694 606.829 266.842 584.043 268.641H524.678V245.255L455.719 231.463L524.678 217.671V200.881L418.541 180.493L524.678 160.705V143.915L455.719 129.523L524.678 115.732ZM597.842 146.913C605.128 146.913 611.034 141.007 611.034 133.721C611.034 126.435 605.128 120.529 597.842 120.529C590.556 120.529 584.65 126.435 584.65 133.721C584.65 141.007 590.556 146.913 597.842 146.913Z"/>
                    <path d="M602.699 361.586H588.301C592.751 361.834 597.58 361.85 602.699 361.586Z"/>
                    <path d="M592.499 0.599565C650.064 0.799446 763.637 38.1373 757.401 185.89C751.681 321.414 659.423 358.662 602.699 361.586H823.961L840.751 309.417H956.483L975.072 361.586H1087.21L953.485 0.599565H592.499ZM899.508 118.13L930.147 230.563H868.869L899.508 118.13Z"/>
                </svg>
                <svg viewBox="0 0 1088 362" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 360.387V0H158.306L209.276 227.865L262.045 0H417.353V360.387H313.614L317.212 103.139L250.052 360.387H167.901L99.541 103.139L103.739 360.387H0Z"/>
                    <path d="M524.678 115.732V90.5464L584.043 93.5447C640.649 102.659 650.403 155.308 648.205 180.493C651.563 246.694 606.829 266.842 584.043 268.641H524.678V245.255L455.719 231.463L524.678 217.671V200.881L418.541 180.493L524.678 160.705V143.915L455.719 129.523L524.678 115.732ZM597.842 146.913C605.128 146.913 611.034 141.007 611.034 133.721C611.034 126.435 605.128 120.529 597.842 120.529C590.556 120.529 584.65 126.435 584.65 133.721C584.65 141.007 590.556 146.913 597.842 146.913Z"/>
                    <path d="M602.699 361.586H588.301C592.751 361.834 597.58 361.85 602.699 361.586Z"/>
                    <path d="M592.499 0.599565C650.064 0.799446 763.637 38.1373 757.401 185.89C751.681 321.414 659.423 358.662 602.699 361.586H823.961L840.751 309.417H956.483L975.072 361.586H1087.21L953.485 0.599565H592.499ZM899.508 118.13L930.147 230.563H868.869L899.508 118.13Z"/>
                </svg>
                <svg viewBox="0 0 1088 362" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 360.387V0H158.306L209.276 227.865L262.045 0H417.353V360.387H313.614L317.212 103.139L250.052 360.387H167.901L99.541 103.139L103.739 360.387H0Z"/>
                    <path d="M524.678 115.732V90.5464L584.043 93.5447C640.649 102.659 650.403 155.308 648.205 180.493C651.563 246.694 606.829 266.842 584.043 268.641H524.678V245.255L455.719 231.463L524.678 217.671V200.881L418.541 180.493L524.678 160.705V143.915L455.719 129.523L524.678 115.732ZM597.842 146.913C605.128 146.913 611.034 141.007 611.034 133.721C611.034 126.435 605.128 120.529 597.842 120.529C590.556 120.529 584.65 126.435 584.65 133.721C584.65 141.007 590.556 146.913 597.842 146.913Z"/>
                    <path d="M602.699 361.586H588.301C592.751 361.834 597.58 361.85 602.699 361.586Z"/>
                    <path d="M592.499 0.599565C650.064 0.799446 763.637 38.1373 757.401 185.89C751.681 321.414 659.423 358.662 602.699 361.586H823.961L840.751 309.417H956.483L975.072 361.586H1087.21L953.485 0.599565H592.499ZM899.508 118.13L930.147 230.563H868.869L899.508 118.13Z"/>
                </svg>
            </div>
            <div class="slider__description">Сеть магазинов кальянной индустрии</div>
            <img class="slider__img" src="<?=SITE_TEMPLATE_PATH?>/img/slider.png" alt="">
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // slider audio
            let audio = new Audio('/local/templates/mda/audio/mda.mp3');
            $('[data-audio]').on('click', function (event) {
                $(this).toggleAttr('data-audio-play');
                if ($(this).hasAttr('data-audio-play')) {
                    audio.play();
                } else {
                    audio.pause();
                }
            });
        });
    </script>
</section>

<?
$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"main_sections", 
	array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COUNT_ELEMENTS" => "Y",
		"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
		"FILTER_NAME" => "sectionsFilter",
		"IBLOCK_ID" => MDA_IBLOCK_ID_CATALOG,
		"IBLOCK_TYPE" => "catalog",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SECTION_ID" => "",
		"SECTION_URL" => "/catalog/#SECTION_CODE#/",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "1",
		"VIEW_MODE" => "LINE",
		"COMPONENT_TEMPLATE" => "main_sections",
		"IMAGE" => "4053"
	),
	false,
	array(
		"HIDE_ICONS" => MDA_HIDE_ICONS
	)
);
?>

<?
//$APPLICATION->IncludeComponent("bitrix:sale.bestsellers","",
//    Array(
//        "LINE_ELEMENT_COUNT" => "3",
//        "TEMPLATE_THEME" => "blue",
//        "BY" => "AMOUNT",
//        "PERIOD" => "0",
//        "FILTER" => array("N", "P", "F"),
//        "CACHE_TYPE" => "A",
//        "CACHE_TIME" => "86400",
//        "AJAX_MODE" => "N",
//        "DETAIL_URL" => "",
//        "BASKET_URL" => "/personal/basket.php",
//        "ACTION_VARIABLE" => "action",
//        "PRODUCT_ID_VARIABLE" => "id",
//        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
//        "ADD_PROPERTIES_TO_BASKET" => "Y",
//        "PRODUCT_PROPS_VARIABLE" => "prop",
//        "PARTIAL_PRODUCT_PROPERTIES" => "N",
//        "DISPLAY_COMPARE" => "N",
//        "SHOW_OLD_PRICE" => "N",
//        "SHOW_DISCOUNT_PERCENT" => "N",
//        "PRICE_CODE" => array("BASE"),
//        "SHOW_PRICE_COUNT" => "1",
//        "PRODUCT_SUBSCRIPTION" => "N",
//        "PRICE_VAT_INCLUDE" => "Y",
//        "USE_PRODUCT_QUANTITY" => "N",
//        "SHOW_NAME" => "Y",
//        "SHOW_IMAGE" => "Y",
//        "MESS_BTN_BUY" => "Купить",
//        "MESS_BTN_DETAIL" => "Подробнее",
//        "MESS_NOT_AVAILABLE" => "Нет в наличии",
//        "MESS_BTN_SUBSCRIBE" => "Подписаться",
//        "PAGE_ELEMENT_COUNT" => "30",
//        "SHOW_PRODUCTS_3" => "Y",
//        "PROPERTY_CODE_3" => array("MANUFACTURER", "MATERIAL"),
//        "CART_PROPERTIES_3" => array("CORNER"),
//        "ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
//        "LABEL_PROP_3" => "SPECIALOFFER",
//        "PROPERTY_CODE_4" => array("COLOR"),
//        "CART_PROPERTIES_4" => array(),
//        "OFFER_TREE_PROPS_4" => array("-"),
//        "HIDE_NOT_AVAILABLE" => "N",
//        "CONVERT_CURRENCY" => "Y",
//        "CURRENCY_ID" => "RUB",
//        "AJAX_OPTION_JUMP" => "N",
//        "AJAX_OPTION_STYLE" => "Y",
//        "AJAX_OPTION_HISTORY" => "N"
//    )
//);
?>

<? // Популярные разделы
//$APPLICATION->IncludeComponent(
//	"bitrix:catalog.section.list",
//	"main_popular",
//	array(
//		"ADD_SECTIONS_CHAIN" => "Y",
//		"CACHE_FILTER" => "N",
//		"CACHE_GROUPS" => "Y",
//		"CACHE_TIME" => "36000000",
//		"CACHE_TYPE" => "A",
//		"COUNT_ELEMENTS" => "Y",
//		"COUNT_ELEMENTS_FILTER" => "CNT_ALL",
//		"FILTER_NAME" => "sectionsFilter",
//		"IBLOCK_ID" => MDA_IBLOCK_ID_CATALOG,
//		"IBLOCK_TYPE" => "catalog",
//		"SECTION_CODE" => "",
//		"SECTION_FIELDS" => array(
//			0 => "",
//			1 => "",
//		),
//		"SECTION_ID" => "",
//		"SECTION_URL" => "/catalog/#SECTION_CODE_PATH#/",
//		"SECTION_USER_FIELDS" => array(
//			0 => "",
//			1 => "UF_RECOMMEND",
//			2 => "",
//		),
//		"SHOW_PARENT_NAME" => "Y",
//		"TOP_DEPTH" => "9",
//		"VIEW_MODE" => "LINE",
//		"COMPONENT_TEMPLATE" => "main_popular",
//		"IMAGE" => "4054",
//		"ELEMENT_COUNT" => "4"
//	),
//	false,
//	array(
//		"HIDE_ICONS" => MDA_HIDE_ICONS
//	)
//);
?>

<?php
$APPLICATION->IncludeComponent(
	"mda.medusa:popular", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "12",
		"POPULAR_FIELD" => "POPULAR",
		"LIMIT" => "4",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"TITLE" => "Популярное",
		"IMAGE" => "4054"
	),
	false,
	array(
		"HIDE_ICONS" => MDA_HIDE_ICONS
	)
);
?>

<?
/*
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "advantage",
    array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "/news/#ELEMENT_CODE#/",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "12",
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "Y",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "8",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            0 => "SHOW_ICON",
            1 => "ICON",
            2 => "",
        ),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "SORT",
        "SORT_BY2" => "ACTIVE_FROM",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPONENT_TEMPLATE" => "advantage",
        "IMAGE" => "46"
    ),
    false
);
*/
?>

<?
$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main_news", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "/news/#ELEMENT_CODE#/",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => MDA_IBLOCK_ID_NEWS,
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "3",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "EXTERNAL_LINK",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "main_news",
		"IMAGE" => "4055"
	),
	false,
	array(
		"HIDE_ICONS" => MDA_HIDE_ICONS
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мебельная компания");
?>

    <section class="slider">
        <div class="slider__list">
            <div class="slider__item">
                <div class="mda-animate">
                    <img class="mda-animate__w" src="<?=SITE_TEMPLATE_PATH?>/img/mda_w.png" alt="">
                    <img class="mda-animate__r" src="<?=SITE_TEMPLATE_PATH?>/img/mda_r.png" alt="">
                    <img class="mda-animate__b" src="<?=SITE_TEMPLATE_PATH?>/img/mda_b.png" alt="">
                </div>
                <div class="slider__description">Сеть магазинов кальянной индустрии</div>
                <img class="slider__img img__contain" src="<?=SITE_TEMPLATE_PATH?>/img/slider.png" alt="">
            </div>
        </div>
    </section>

    <?$APPLICATION->IncludeComponent(
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
            "IBLOCK_ID" => "5",
            "IBLOCK_TYPE" => "catalog",
            "SECTION_CODE" => "",
            "SECTION_FIELDS" => array(
                0 => "",
                1 => "",
            ),
            "SECTION_ID" => $_REQUEST["SECTION_ID"],
            "SECTION_URL" => "/catalog/#SECTION_CODE#/",
            "SECTION_USER_FIELDS" => array(
                0 => "",
                1 => "",
            ),
            "SHOW_PARENT_NAME" => "Y",
            "TOP_DEPTH" => "1",
            "VIEW_MODE" => "LINE",
            "COMPONENT_TEMPLATE" => "main_sections"
        ),
        false
    );?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "main_popular",
        array(
            "ADD_SECTIONS_CHAIN" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "COUNT_ELEMENTS" => "Y",
            "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
            "FILTER_NAME" => "sectionsFilter",
            "IBLOCK_ID" => "5",
            "IBLOCK_TYPE" => "catalog",
            "SECTION_CODE" => "",
            "SECTION_FIELDS" => array(
                0 => "",
                1 => "",
            ),
            "SECTION_ID" => $_REQUEST["SECTION_ID"],
            "SECTION_URL" => "/catalog/#SECTION_CODE#/",
            "SECTION_USER_FIELDS" => array(
                0 => "",
                1 => "",
            ),
            "SHOW_PARENT_NAME" => "Y",
            "TOP_DEPTH" => "1",
            "VIEW_MODE" => "LINE",
            "COMPONENT_TEMPLATE" => "main_sections"
        ),
        false
    );?>

<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "Y",
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
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array("",""),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => $_REQUEST["ID"],
        "IBLOCK_TYPE" => "-",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
        "INCLUDE_SUBSECTIONS" => "Y",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "20",
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
        "PROPERTY_CODE" => array("",""),
        "SET_BROWSER_TITLE" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "Y",
        "SHOW_404" => "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N"
    )
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>

<?
CModule::IncludeModule("catalog");
$storeList = \Bitrix\Catalog\StoreTable::getList([
    'filter' => ['ACTIVE'>='Y'],
])->fetchAll();
?>

<div class="contacts">
    <div class="contacts__body">
        <div class="contacts__list">

            <?foreach($storeList as $store):?>

                <div class="contacts__item">

                    <div class="contacts__item-info">

                        <div class="contacts__item-name">
                            <h2><?=$store['TITLE']?></h2>
                        </div>

                        <?if ($store['PHONE']):?>

                            <div class="contacts__item-phone">
                                <i class="fa fa-phone"></i>
                                <a href="tel:<?=$store['PHONE']?>"><?=$store['PHONE']?></a>
                            </div>

                            <div class="contacts__item-whatsapp">
                                <i class="fa fa-whatsapp"></i>
                                <a href="https://wa.me/<?=$store['PHONE']?>"><?=$store['PHONE']?></a>
                            </div>

                        <?endif;?>

                        <?if ($store['ADDRESS']):?>
                            <div class="contacts__item-address">
                                <span>Адрес: </span><address><?=$store['ADDRESS']?></address>
                            </div>
                        <?endif;?>

                        <?if ($store['SCHEDULE']):?>

                            <div class="contacts__item-time">
                                Режим работы: <span><?=$store['SCHEDULE']?></span>
                            </div>

                        <?endif;?>

                    </div>

                    <div class="contacts__map">
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:map.yandex.view",
                            "",
                            [
                                "INIT_MAP_TYPE" => "COORDINATES",
                                "MAP_DATA" =>   serialize(
                                    [
                                        'yandex_lon' => $store['GPS_S'],
                                        'yandex_lat' => $store['GPS_N'],
                                        'PLACEMARKS' => [
                                            [
                                                "LON" => $store['GPS_S'],
                                                "LAT" => $store['GPS_N'],
                                                "TEXT" => htmlspecialcharsbx($store['TITLE'])
                                            ]
                                        ]
                                    ]
                                ),
                                "MAP_WIDTH" => "100%",
                                "MAP_HEIGHT" => "250",
                                "CONTROLS" => ["ZOOM", "SMALLZOOM", "SCALELINE"],
                                "OPTIONS" => [
                                    "ENABLE_DRAGGING",
                                    "ENABLE_SCROLL_ZOOM",
                                    "ENABLE_DBLCLICK_ZOOM"
                                ],
                                "MAP_ID" => ""
                            ],
                            array("HIDE_ICONS" => MDA_HIDE_ICONS)
                        );
                        ?>
                    </div>

                </div>

            <?endforeach;?>

        </div>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
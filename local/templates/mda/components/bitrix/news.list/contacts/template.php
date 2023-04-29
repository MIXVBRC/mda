<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="contacts">
    <div class="contacts__body">
        <div class="contacts__list">

            <?foreach($arResult["ITEMS"] as $arItem):?>

                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>

                <div class="contacts__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

                    <div class="contacts__item-info">

                        <div class="contacts__item-name">
                            <h2><?=$arItem['NAME']?></h2>
                        </div>

                        <div class="contacts__item-phone">
                            <i class="fa fa-phone"></i>
                            <a href="tel:<?=$arItem['PROPERTIES']['PHONE']['VALUE']?>"><?=$arItem['PROPERTIES']['PHONE']['VALUE']?></a>
                        </div>

                        <div class="contacts__item-whatsapp">
                            <i class="fa fa-whatsapp"></i>
                            <a href="https://wa.me/<?=$arItem['PROPERTIES']['WHATSAPP']['VALUE_PREG']?>"><?=$arItem['PROPERTIES']['WHATSAPP']['VALUE']?></a>
                        </div>

                        <div class="contacts__item-address">
                            <span>Адрес: </span><address><?=$arItem['PROPERTIES']['ADDRESS']['VALUE']?></address>
                        </div>

                        <?if ($arItem['PROPERTIES']['AROUND_THE_CLOCK']['VALUE'] == 'Y'):?>

                            <div class="contacts__item-time">
                                Режим работы: <span>24/7 Круглосуточно</span>
                            </div>

                        <?else:?>

                            <div class="contacts__item-time">
                                Режим работы: с <span><?=$arItem['PROPERTIES']['START']['VALUE']?></span> до <span><?=$arItem['PROPERTIES']['END']['VALUE']?></span>
                            </div>

                        <?endif;?>

                    </div>

                    <div class="contacts__map">
                        <?
                        if ($arItem['PROPERTIES']['MAP']['VALUE']) {
                            echo $arItem['PROPERTIES']['MAP']['VALUE'];
                        } else {
                            $mapText = implode('<br>',$arItem['PROPERTIES']['MAP_TEXT']['VALUE'] ?: [$arItem['NAME']]);
                            $APPLICATION->IncludeComponent(
                                "bitrix:map.yandex.view",
                                "",
                                [
                                    "INIT_MAP_TYPE" => "COORDINATES",
                                    "MAP_DATA" =>   serialize(
                                        [
                                            'yandex_lon' => $arItem['PROPERTIES']['MAP_LON']['VALUE'],
                                            'yandex_lat' => $arItem['PROPERTIES']['MAP_LAT']['VALUE'],
                                            'yandex_scale' => $arItem['PROPERTIES']['MAP_SCALE']['VALUE'],
                                            'PLACEMARKS' => [
                                                [
                                                    "LON" => $arItem['PROPERTIES']['MAP_LON']['VALUE'],
                                                    "LAT" => $arItem['PROPERTIES']['MAP_LAT']['VALUE'],
                                                    "TEXT" => $mapText,
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
                                ["HIDE_ICONS" => true]
                            );
                        }
                        ?>
                        <?

                        ?>
                    </div>

                </div>

            <?endforeach;?>

        </div>
    </div>
</div>
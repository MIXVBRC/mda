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

                <div class="contacts__item">

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
                        <?=$arItem['PROPERTIES']['MAP']['VALUE']?>
                    </div>

                </div>

            <?endforeach;?>

        </div>
    </div>
</div>
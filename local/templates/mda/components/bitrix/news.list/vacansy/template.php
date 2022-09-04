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

<? if ($arResult["ITEMS"]): ?>

    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
    <?endif;?>

    <div class="vacansy">
        <div class="vacansy__body">

            <h2 class="vacansy__title"><?=$arResult['NAME']?></h2>

            <div class="vacansy__list">

                <?foreach($arResult["ITEMS"] as $arItem):?>

                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>

                    <div class="vacansy__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

                        <div class="vacansy__item-title"><?=$arItem['NAME']?></div>

                        <?if ($arItem['PROPERTIES']['REQUIREMENTS']['VALUE']['TEXT']):?>

                            <div class="vacansy__item-text">
                                <span><?=$arItem['PROPERTIES']['DESCRIPTION']['NAME']?>:</span>

                                <?if ($arItem['PROPERTIES']['DESCRIPTION']['VALUE']['TYPE'] == 'TEXT'):?>

                                    <?=$arItem['PROPERTIES']['DESCRIPTION']['VALUE']['TEXT']?>

                                <?else:?>

                                    <?=htmlspecialchars_decode($arItem['PROPERTIES']['DESCRIPTION']['VALUE']['TEXT'])?>

                                <?endif;?>
                            </div>

                        <?endif;?>

                        <?if ($arItem['PROPERTIES']['REQUIREMENTS']['VALUE']['TEXT']):?>

                            <div class="vacansy__item-text">

                                <span><?=$arItem['PROPERTIES']['REQUIREMENTS']['NAME']?>:</span>

                                <?if ($arItem['PROPERTIES']['REQUIREMENTS']['VALUE']['TYPE'] == 'TEXT'):?>

                                    <?=$arItem['PROPERTIES']['REQUIREMENTS']['VALUE']['TEXT']?>

                                <?else:?>

                                    <?=htmlspecialchars_decode($arItem['PROPERTIES']['REQUIREMENTS']['VALUE']['TEXT'])?>

                                <?endif;?>

                            </div>

                        <?endif;?>

                        <div class="vacansy__item-footer">

                            <div class="vacansy__item-terms">

                                <?if ($arItem['PROPERTIES']['AROUND_THE_CLOCK']['VALUE'] == 'Y'):?>

                                    <div class="vacansy__item-time">График работы 24/7 Круглосуточно</div>

                                <?else:?>

                                    <div class="vacansy__item-time">График работы с <?=$arItem['PROPERTIES']['START']['VALUE']?> до <?=$arItem['PROPERTIES']['END']['VALUE']?></div>

                                <?endif;?>

                                <?if ($arItem['PROPERTIES']['PAY']['VALUE']):?>

                                    <div class="vacansy__item-pay">Зарплата от <?=CurrencyFormat($arItem['PROPERTIES']['PAY']['VALUE'], "RUB")?></div>

                                <?endif;?>

                            </div>

                            <a href="/about/feedback.php" data-popup-link id="<?=$arResult['CODE'].'-'.$arItem['ID']?>" class="vacansy__item-button"><?=GetMessage('VACANSY_BUTTON')?></a>

                        </div>

                    </div>

                <?endforeach;?>

            </div>

        </div>
    </div>

    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
    <?endif;?>

<?endif;?>
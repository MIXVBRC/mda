<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

<div class="order-detail__item" data-item data-close>
    <div class="order-detail__item-header">
        <div class="order-detail__item-header-title"><h3><?= Loc::getMessage('SPOD_LIST_ORDER_INFO') ?></h3></div>
        <span class="order-detail__item-header-arrow" data-opener></span>
    </div>
    <div class="order-detail__item-body" data-opener-box>
        <div class="order-detail__item-body-element">
            <ul class="order-detail__item-list">

                <?/** ФИО */?>
                <?/*
                <li>
                    <span>
                        <?
                        $userName = $arResult["USER_NAME"];
                        if (mb_strlen($userName) || mb_strlen($arResult['FIO'])) {
                            echo Loc::getMessage('SPOD_LIST_FIO').':';
                        } else {
                            echo Loc::getMessage('SPOD_LOGIN').':';
                        }
                        ?>
                    </span>
                    <span></span>
                    <span>
                        <?
                        if($userName <> '') {
                            echo htmlspecialcharsbx($userName);
                        } elseif(mb_strlen($arResult['FIO'])) {
                            echo htmlspecialcharsbx($arResult['FIO']);
                        } else {
                            echo htmlspecialcharsbx($arResult["USER"]['LOGIN']);
                        }
                        ?>
                    </span>
                </li>
                */?>

                <?/** Статус заказа */?>
                <li>
                    <span>
                        <?= Loc::getMessage('SPOD_LIST_CURRENT_STATUS_DATE', array(
                            '#DATE_STATUS#' => $arResult["DATE_STATUS_FORMATED"]
                        )) ?>
                    </span>
                    <span></span>
                    <span>
                        <?
                        if ($arResult['CANCELED'] !== 'Y') {
                            echo htmlspecialcharsbx($arResult["STATUS"]["NAME"]);
                        } else {
                            echo Loc::getMessage('SPOD_ORDER_CANCELED');
                        }
                        ?>
                    </span>
                </li>

                <?/** Сумма заказа */?>
                <li>
                    <span><?= Loc::getMessage('SPOD_ORDER_PRICE')?>:</span>
                    <span></span>
                    <span><?= $arResult["PRICE_FORMATED"]?></span>
                </li>

                <?/** E-mail */?>
                <?/*
                <?if (mb_strlen($arResult["USER"]["EMAIL"]) && !in_array("EMAIL", $arParams['HIDE_USER_INFO'])):?>
                    <li>
                        <span><?= Loc::getMessage('SPOD_EMAIL')?>:</span>
                        <span></span>
                        <span><?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?></span>
                    </li>
                <?endif;?>
                */?>

            </ul>

            <div class="info-box" style="display: none">
                <?/** Свойства заказа */?>
                <?if (isset($arResult["ORDER_PROPS"])):?>
                    <ul class="order-detail__item-list">

                        <?/** Логин */?>
                        <?/*
                        <? if (mb_strlen($arResult["USER"]["LOGIN"]) && !in_array("LOGIN", $arParams['HIDE_USER_INFO'])):?>
                            <li>
                                <span><?= Loc::getMessage('SPOD_LOGIN')?>:</span>
                                <span></span>
                                <span><?= htmlspecialcharsbx($arResult["USER"]["LOGIN"]) ?></span>
                            </li>
                        <?endif;?>
                        */?>

                        <?foreach ($arResult["ORDER_PROPS"] as $property):?>
                            <li>
                                <span><?= htmlspecialcharsbx($property['NAME']) ?>:</span>
                                <span></span>
                                <span>
                                <?
                                if ($property["TYPE"] == "Y/N") {
                                    echo Loc::getMessage('SPOD_' . ($property["VALUE"] == "Y" ? 'YES' : 'NO'));
                                } else {
                                    if ($property['MULTIPLE'] == 'Y' && $property['TYPE'] !== 'FILE' && $property['TYPE'] !== 'LOCATION') {
                                        $propertyList = unserialize($property["VALUE"], ['allowed_classes' => false]);
                                        foreach ($propertyList as $propertyElement) {
                                            echo $propertyElement . '</br>';
                                        }
                                    } else if ($property['TYPE'] == 'FILE') {
                                        echo $property["VALUE"];
                                    } else {
                                        echo htmlspecialcharsbx($property["VALUE"]);
                                    }
                                }
                                ?>
                            </span>
                            </li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>

                <?/** Комментарии к заказу */?>
                <?if($arResult["USER_DESCRIPTION"] <> ''):?>
                    <div class="order-detail__item-text"><?= Loc::getMessage('SPOD_ORDER_DESC') ?>:</div>
                    <div class="order-detail__item-textarea"><?= nl2br(htmlspecialcharsbx($arResult["USER_DESCRIPTION"])) ?></div>
                <?endif;?>
            </div>

            <?/** Подробнее */?>
            <a class="button info-show" data-button href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_MORE') ?></a>
            <a class="button info-hide" style="display: none" data-button href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_LESS') ?></a>

            <?/** Повторить заказ */?>
            <a class="button" data-button href="<?=$arResult["URL_TO_COPY"]?>"><?= Loc::getMessage('SPOD_ORDER_REPEAT') ?></a>

            <?/** Отменить заказ */?>
            <?if ($arResult['CAN_CANCEL'] === 'Y'):?>
                <a class="order-detail__item-link" data-button href="<?=$arResult["URL_TO_CANCEL"]?>"><?= Loc::getMessage('SPOD_ORDER_CANCEL') ?></a>
            <?endif;?>
        </div>
    </div>
</div>
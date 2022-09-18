<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

<div class="order-detail__item">

    <?/** Заголовок */?>
    <div class="order-detail__title"><h3><?= Loc::getMessage('SPOD_LIST_ORDER_INFO') ?></h3></div>

    <div class="order-detail__item-body">

        <div class="order-detail__item-info">
            <table class="order-detail__item-table">

                <?/** ФИО */?>
                <tr class="order-detail__item-table-tr">
                    <td class="order-detail__item-table-tr-td">
                        <?
                        $userName = $arResult["USER_NAME"];
                        if (mb_strlen($userName) || mb_strlen($arResult['FIO'])) {
                            echo Loc::getMessage('SPOD_LIST_FIO').':';
                        } else {
                            echo Loc::getMessage('SPOD_LOGIN').':';
                        }
                        ?>
                    </td>
                    <td class="order-detail__item-table-tr-td">
                        <?
                        if($userName <> '') {
                            echo htmlspecialcharsbx($userName);
                        } elseif(mb_strlen($arResult['FIO'])) {
                            echo htmlspecialcharsbx($arResult['FIO']);
                        } else {
                            echo htmlspecialcharsbx($arResult["USER"]['LOGIN']);
                        }
                        ?>
                    </td>
                </tr>

                <?/** Статус заказа */?>
                <tr class="order-detail__item-table-tr">
                    <td class="order-detail__item-table-tr-td">
                        <?= Loc::getMessage('SPOD_LIST_CURRENT_STATUS_DATE', array(
                            '#DATE_STATUS#' => $arResult["DATE_STATUS_FORMATED"]
                        )) ?>
                    </td>
                    <td class="order-detail__item-table-tr-td">
                        <?
                        if ($arResult['CANCELED'] !== 'Y') {
                            echo htmlspecialcharsbx($arResult["STATUS"]["NAME"]);
                        } else {
                            echo Loc::getMessage('SPOD_ORDER_CANCELED');
                        }
                        ?>
                    </td>
                </tr>

                <?/** Сумма заказа */?>
                <tr class="order-detail__item-table-tr">
                    <td class="order-detail__item-table-tr-td">
                        <?= Loc::getMessage('SPOD_ORDER_PRICE')?>:
                    </td>
                    <td class="order-detail__item-table-tr-td">
                        <?= $arResult["PRICE_FORMATED"]?>
                    </td>
                </tr>
            </table>
        </div>

        <?/** Информация о пользователе */?>
        <div class="order-detail__item-show order-detail__info-box" style="display: none">

            <div class="order-detail__item-title"><?= Loc::getMessage('SPOD_USER_INFORMATION') ?></div>

            <table class="order-detail__item-table">

                <?/** Логин */?>
                <? if (mb_strlen($arResult["USER"]["LOGIN"]) && !in_array("LOGIN", $arParams['HIDE_USER_INFO'])):?>
                    <tr class="order-detail__item-table-tr">
                        <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_LOGIN')?>:</td>
                        <td class="order-detail__item-table-tr-td"><?= htmlspecialcharsbx($arResult["USER"]["LOGIN"]) ?></td>
                    </tr>
                <?endif;?>

                <?/** E-mail */?>
                <?if (mb_strlen($arResult["USER"]["EMAIL"]) && !in_array("EMAIL", $arParams['HIDE_USER_INFO'])):?>
                    <tr class="order-detail__item-table-tr">
                        <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_EMAIL')?>:</td>
                        <td class="order-detail__item-table-tr-td">
                            <a class="order-detail__link" href="mailto:<?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?>"><?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?></a>
                        </td>
                    </tr>
                <?endif;?>

                <?/** Тип плательщика */?>
                <?if (mb_strlen($arResult["USER"]["PERSON_TYPE_NAME"]) && !in_array("PERSON_TYPE_NAME", $arParams['HIDE_USER_INFO'])):?>
                    <tr class="order-detail__item-table-tr">
                        <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_PERSON_TYPE_NAME') ?>:</td>
                        <td class="order-detail__item-table-tr-td"><?= htmlspecialcharsbx($arResult["USER"]["PERSON_TYPE_NAME"]) ?></td>
                    </tr>
                <?endif;?>

                <?/** Свойства заказа */?>
                <?if (isset($arResult["ORDER_PROPS"])):?>
                    <?foreach ($arResult["ORDER_PROPS"] as $property):?>
                        <tr class="order-detail__item-table-tr">
                            <?/** Название свойства */?>
                            <td class="order-detail__item-table-tr-td"><?= htmlspecialcharsbx($property['NAME']) ?>:</td>

                            <?/** Значение свойства */?>
                            <td class="order-detail__item-table-tr-td">
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
                            </td>
                        </tr>
                    <?endforeach;?>
                <?endif;?>

                <?/** Комментарии к заказу */?>
                <?if($arResult["USER_DESCRIPTION"] <> ''):?>
                    <tr class="order-detail__item-table-tr">
                        <td class="order-detail__item-table-tr-td"><?= Loc::getMessage('SPOD_ORDER_DESC') ?>:</td>
                        <td class="order-detail__item-table-tr-td"><?= nl2br(htmlspecialcharsbx($arResult["USER_DESCRIPTION"])) ?></td>
                    </tr>
                <?endif;?>

            </table>

        </div>

        <div class="order-detail__item-buttons">

            <?/** Повторить заказ */?>
            <a class="button__success" data-button href="<?=$arResult["URL_TO_COPY"]?>"><?= Loc::getMessage('SPOD_ORDER_REPEAT') ?></a>

            <?/** Отменить заказ */?>
            <a class="button__error" data-button href="<?=$arResult["URL_TO_CANCEL"]?>"><?= Loc::getMessage('SPOD_ORDER_CANCEL') ?></a>

            <?/** Подробнее */?>
            <a class="button__medium order-detail__info-show" data-button href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_MORE') ?></a>
            <a class="button__medium order-detail__info-hide" style="display: none" data-button href="javascript:void(0);"><?= Loc::getMessage('SPOD_LIST_LESS') ?></a>

        </div>

    </div>
</div>

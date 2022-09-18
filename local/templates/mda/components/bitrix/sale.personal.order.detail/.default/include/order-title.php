<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

<div class="order-detail__item">
    <div class="order-detail__title">
        <h2>
            <?= Loc::getMessage('SPOD_SUB_ORDER_TITLE', array(
                "#ACCOUNT_NUMBER#"=> htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
                "#DATE_ORDER_CREATE#"=> $arResult["DATE_INSERT_FORMATED"]
            ))?>

            <?= count($arResult['BASKET']);?>

            <?
            $count = count($arResult['BASKET']) % 10;
            if ($count == '1') {
                echo Loc::getMessage('SPOD_TPL_GOOD');
            } else if ($count >= '2' && $count <= '4') {
                echo Loc::getMessage('SPOD_TPL_TWO_GOODS');
            } else {
                echo Loc::getMessage('SPOD_TPL_GOODS');
            }
            ?>

            <?=Loc::getMessage('SPOD_TPL_SUMOF')?>

            <?=$arResult["PRICE_FORMATED"]?>
        </h2>
    </div>
</div>

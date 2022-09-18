<?
/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

<div class="order-detail">

    <?/** Навигаторы */?>
    <? if ($arParams['GUEST_MODE'] !== 'Y'):?>
        <a class="button back-button" href="<?= htmlspecialcharsbx($arResult["URL_TO_LIST"]) ?>"><?= Loc::getMessage('SPOD_RETURN_LIST_ORDERS') ?></a>
    <?endif;?>

    <?/** Тело */?>
    <div class="order-detail__body">

        <?/** Подзаголовок */?>
        <? require __DIR__ . '/order-title.php'; ?>

        <?/** Информация о заказе */?>
        <? require __DIR__ . '/order-info.php'; ?>

        <?/** Параметры оплаты */?>
        <? require __DIR__ . '/order-payment.php'; ?>

        <?/** Параметры отгрузки */?>
        <? require __DIR__ . '/order-shipment.php'; ?>

        <?/** Содержимое заказа */?>
        <? require __DIR__ . '/order-products.php'; ?>

        <?/** Итого */?>
        <? require __DIR__ . '/order-total.php'; ?>

    </div>

    <?/** Навигаторы */?>
    <? if ($arParams['GUEST_MODE'] !== 'Y'):?>
        <a class="button back-button" href="<?= htmlspecialcharsbx($arResult["URL_TO_LIST"]) ?>"><?= Loc::getMessage('SPOD_RETURN_LIST_ORDERS') ?></a>
    <?endif;?>
</div>
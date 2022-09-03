<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата заказа");
ob_start();
?>

<?
$APPLICATION->IncludeComponent(
    "bitrix:sale.order.payment",
    "",
    []
);
?>
<?
$content = ob_get_contents();
ob_end_clean();
?>
<div class="order-confirm__file" style="padding: 15px">
    <?=$content?>
</div>

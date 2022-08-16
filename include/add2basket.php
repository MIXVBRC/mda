<? require_once ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");?>
<?
if (!CModule::IncludeModule("sale") && !CModule::IncludeModule("catalog")) die;

Add2BasketByProductID(
    intval($_POST['product']),
    1,
    false
);
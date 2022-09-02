<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

LocalRedirect('/account/personal/');
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
if (isAuth()) {
    LocalRedirect('/personal/');
}
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
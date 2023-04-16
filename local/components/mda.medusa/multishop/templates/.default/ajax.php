<? require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();

$result = [];


$action = $request->getPost('ACTION');
$select = $request->getPost('SELECT');
$arParams = $request->getPost('PARAMS');

$result = [
    $action,
    $select,
    $arParams,
];

if ($action === 'select') {

}




pre($result);
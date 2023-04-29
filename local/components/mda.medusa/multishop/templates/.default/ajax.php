<? require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application;
use MDA\Medusa\MultiShop;

CModule::IncludeModule('mda.medusa');

$request = Application::getInstance()->getContext()->getRequest();

$action = $request->getPost('ACTION');
$xmlId = $request->getPost('XML_ID');

MultiShop::setUserShop($xmlId, false);
echo json_encode(MultiShop::getUserShop());

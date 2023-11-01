<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

Loc::loadMessages(__FILE__);

class AgeComponent extends CBitrixComponent
{
	public function executeComponent()
	{
        $session = \Bitrix\Main\Application::getInstance()->getSession();
        if (!$session->has('age') || isAdmin()) {
            $this->includeComponentTemplate();
        }
	}
}
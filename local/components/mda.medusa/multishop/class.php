<?

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
use MDA\Medusa\Core;
use MDA\Medusa\MultiShop;

Class Comments extends CBitrixComponent
{
    public function executeComponent()
    {

        if (!$this->arResult['SHOPS'] = MultiShop::getShops()) {
            return;
        }

        if (!$this->arResult['SHOP'] = MultiShop::getUserShop()) {

            $this->arResult['SHOW_QUESTION'] = true;
            $this->arResult['SHOP'] = $this->arResult['SHOPS'][array_key_first($this->arResult['SHOPS'])];

            if (!MultiShop::setUserShop($this->arResult['SHOP']['XML_ID'])) return;

        }

        $filter = MultiShop::getFiltersByShop($this->arResult['SHOP']['XML_ID']);

        $GLOBALS[Core::getElementsFilterName()] = $filter['FILTER_PRODUCTS'];
        $GLOBALS[Core::getSectionsFilterName()] = $filter['FILTER_SECTIONS'];

        $this->includeComponentTemplate();
    }
}
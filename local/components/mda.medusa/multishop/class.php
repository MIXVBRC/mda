<?

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
use MDA\Medusa\Core;
use MDA\Medusa\MultiShop;

Class MultiShopComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if($this->startResultCache($this->arParams['CACHE_TIME'], [MultiShop::getUserShop()['XML_ID']])) {
            if (!$this->arResult['SHOPS'] = MultiShop::getShops()) {
                return;
            }

            $this->arResult['SHOP'] = MultiShop::getUserShop();

            $this->arResult['SHOW_QUESTION'] = $this->arResult['SHOP']['AUTO_SELECT'];

            $filter = MultiShop::getFiltersByShop($this->arResult['SHOP']['XML_ID']);

            $GLOBALS[Core::getElementsFilterName()] = $filter['FILTER_PRODUCTS'];
            $GLOBALS[Core::getSectionsFilterName()] = $filter['FILTER_SECTIONS'];

            $this->includeComponentTemplate();
        }

    }
}
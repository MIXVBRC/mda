<?php

// Регистрируем события
use Bitrix\Main\UserTable;
use Bitrix\Sale\Basket;
use Bitrix\Sale\BasketItem;
use Bitrix\Sale\Order;
use Bitrix\Sale\PropertyValue;
use MDA\Medusa\MultiShop;

$eventList = [
    ['module' => 'main', 'eventName' => 'OnProlog', 'eventAction' => 'OnEpilogHandler', 'sort' => 1],
    ['module' => 'iblock', 'eventName' => 'OnBeforeIBlockElementUpdate', 'eventAction' => 'OnBeforeIBlockElementUpdateHandler', 'sort' => 2],
    ['module' => 'sale', 'eventName' => 'OnSaleOrderSaved', 'eventAction' => 'OnSaleOrderSavedHandler', 'sort' => 3],
];

// Добавляем события
$eventManager = \Bitrix\Main\EventManager::getInstance();
foreach ($eventList as $event) {
    $eventManager->addEventHandler(
        $event['module'],
        $event['eventName'],
        ['MDAEvents', $event['eventAction']],
        $event['eventIncludeFile'] ? : false,
        $event['sort'] ? : 100,
    );
}

Class MDAEvents
{
    public static function OnEpilogHandler()
    {
        if (!(defined('ERROR_404') && ERROR_404 == 'Y')) return;

        CEventLog::Add([
            'SEVERITY' => 'INFO',
            'AUDIT_TYPE_ID' => 'ERROR_404',
            'MODULE_ID' => 'main',
            'DESCRIPTION' => $_SERVER['REQUEST_URI'],
        ]);

        $GLOBALS['APPLICATION']->RestartBuffer();
        $GLOBALS['APPLICATION']->SetTitle("404 Not Found");
        $GLOBALS['APPLICATION']->SetDirProperty('HIDE_TITLE', 'Y');

        include_once $_SERVER["DOCUMENT_ROOT"] . '/404.php';
    }

    public static function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        // Не выгружаем картинки из 1С
        if (@$_REQUEST['mode'] == 'import') {
            unset($arFields['PREVIEW_PICTURE']);
            unset($arFields['DETAIL_PICTURE']);
        }
    }

    public static function OnSaleOrderSavedHandler(\Bitrix\Main\Event $event)
    {
        /** @var Order $order */
        $order = $event->getParameter("ENTITY");

        $fields['ORDER_ID'] = $order->getId();
        $fields['ORDER_DATE'] = $order->getDateInsert()->toString();
        $fields['PRICE'] = SaleFormatCurrency($order->getPrice(), $order->getCurrency());
        $fields['USER_DESCRIPTION'] = $order->getField('USER_DESCRIPTION') ?: '-';

        $query = UserTable::query();
        $query->setFilter([
            'ID' => $order->getUserId()
        ]);
        $query->setSelect([
            'NAME',
            'LAST_NAME',
            'SECOND_NAME',
            'EMAIL',
        ]);
        $user = $query->fetch();

        $fields['USER_NAME'] = implode(' ', [
            $user['NAME'],
            $user['LAST_NAME'],
            $user['SECOND_NAME'],
        ]);
        $fields['EMAIL'] = $user['EMAIL'];

        /** @var PropertyValue $property */
        foreach ($order->getPropertyCollection() as $property) {
            switch ($property->getField('CODE')) {
                case 'FIO':
                    $fields['USER_NAME_ORDER'] = $property->getValue();
                    break;
                case 'PHONE':
                    $fields['PHONE'] = $property->getValue();
                    break;
                case 'EMAIL':
                    $fields['EMAIL_ORDER'] = $property->getValue();
                    break;
                case 'SHOP':
                    $shop = MultiShop::getShops()[$property->getValue()];
                    $fields['SHOP'] = $shop['NAME'];
                    $fields['SHOP_EMAIL'] = $shop['EMAIL'];
                    break;
            }
        }

        $dbBasketItems = CSaleBasket::GetList(
            ['ID' => 'ASC'],
            ['ORDER_ID' => $order->getId()],
            false,
            false,
            ['ID', 'NAME', 'QUANTITY', 'PRICE']
        );

        $table = <<< TABLE

<table class="mda__table">
<tr>
<th>Наименование</th>
<th>Цена</th>
<th>Количество (шт.)</th>
<th>Итоговая цена</th>
</tr>
TABLE;

        while ($arBasketItems = $dbBasketItems->Fetch()) {

            $quantity = $arBasketItems["QUANTITY"];
            $price = SaleFormatCurrency($arBasketItems['PRICE'], $order->getCurrency());
            $priceFinal = SaleFormatCurrency($arBasketItems['PRICE'] * $quantity, $order->getCurrency());

            $table .= '<tr>';
            $table .= "<td style='padding: 0 10px 0 10px'>{$arBasketItems["NAME"]}</td>";
            $table .= "<td style='text-align: center'>{$price}</td>";
            $table .= "<td style='text-align: center'>{$quantity}</td>";
            $table .= "<td style='text-align: center'>{$priceFinal}</td>";
            $table .= '</tr>';
        }

        $table .= '</table>';

        $fields['ORDER_PRODUCT_LIST'] = $table;

        \CEvent::Send("SALE_NEW_ORDER_CUSTOM", SITE_ID, $fields);
    }
}


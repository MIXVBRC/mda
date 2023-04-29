<?php


namespace MDA\Medusa;


use Bitrix\Main\Event;
use Bitrix\Sale\Order;
use Bitrix\Sale\PropertyValue;

class OrderSubscriber
{
    public static function MultiShopOnSaleOrderBeforeSavedHandler(Event $event)
    {
        /** @var Order $order */
        $order = $event->getParameter("ENTITY");

        if (!$order->isNew()) return;

        /** @var PropertyValue $property */
        foreach ($order->getPropertyCollection() as $property) {
            if ($property->getField('CODE') == 'SHOP') {
                $property->setField('VALUE', MultiShop::getUserShop()['XML_ID']);
            }
        }
    }
}
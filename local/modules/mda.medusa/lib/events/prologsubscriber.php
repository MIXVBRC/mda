<?php


namespace MDA\Medusa;


use Bitrix\Main\Context;
use Bitrix\Sale\Basket;
use Bitrix\Sale\BasketItem;
use Bitrix\Sale\Fuser;
use CModule;

class PrologSubscriber
{
    public static function MultiShopBasketCheckHandler()
    {
        MultiShop::addUser();

        CModule::IncludeModule('sale');
        $fUserId = Fuser::getId();
        $site = Context::getCurrent()->getSite();
        $basket = Basket::loadItemsForFUser($fUserId, $site);

        /** @var BasketItem $basketItem */
        foreach ($basket->getBasketItems() as $basketItem) {
            $xmlId = $basketItem->getField('PRODUCT_XML_ID');

            if (empty($xmlId)) continue;

            $itemQuantity = $basketItem->getQuantity();
            $itemMaxQuantity = MultiShop::getProductStocks($xmlId);
            $save = false;
            if ($itemMaxQuantity <= 0) {
                $basketItem->delete();
                $save = true;
            } else if ($itemQuantity > $itemMaxQuantity) {
                $basketItem->setField('QUANTITY', $itemMaxQuantity);
                $basketItem->save();
                $save = true;
            }

            if ($save) $basket->save();
        }
    }
}
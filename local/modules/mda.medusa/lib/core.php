<?php


namespace MDA\Medusa;


use COption;

class Core
{
    protected static $module = 'mda.medusa';

    public static function getProductIblockId(): int
    {
        return (int) COption::GetOptionString(self::$module, 'product_iblock_id');
    }

    public static function getOfferIblockId(): int
    {
        return (int) COption::GetOptionString(self::$module, 'offer_iblock_id');
    }

    public static function getShopHlBlockId(): int
    {
        return (int) COption::GetOptionString(self::$module, 'shop_hl_block_id');
    }

    public static function getStockHlBlockId(): int
    {
        return (int) COption::GetOptionString(self::$module, 'stock_hl_block_id');
    }
}
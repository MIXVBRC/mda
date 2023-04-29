<?php

namespace MDA\Medusa\Tables;

use Bitrix\Main\Entity;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UserTable;
use Bitrix\Sale\FuserTable;

/**
 * Class DataTable
 *
 * Fields:
 * <ul>
 * <li> ID int
 * <li> FUSER_ID int
 * <li> USER_ID int
 * <li> XML_ID string
 * <li> AUTO_SELECT bool
 * <li> DATE_CREATE datatime
 * <li> DATE_UPDATE datatime
 * </ul>
 *
 * Tables:
 * <ul>
 * <li> FUSER
 * <li> USER
 * </ul>
 *
 * @package Umino\Kodik\Tables
 **/

class MultiShopTable extends Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'mda_medusa_multi_shop';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
            ]),
            new Entity\IntegerField('FUSER_ID', [
                'required' => true,
            ]),
            new Entity\IntegerField('USER_ID'),
            new Entity\StringField('XML_ID', [
                'required' => true,
            ]),
            new Entity\BooleanField('AUTO_SELECT', [
                'required' => true,
                'default_value' => true,
            ]),
            new Entity\DatetimeField('DATE_CREATE', [
                'required' => true,
                'default_value' => function () {
                    return new DateTime();
                }
            ]),
            new Entity\DatetimeField('DATE_UPDATE', [
                'required' => true,
                'default_value' => function () {
                    return new DateTime();
                }
            ]),
            new Entity\ReferenceField(
                'FUSER',
                FuserTable::class,
                ['=this.FUSER_ID' => 'ref.ID'],
                ['join_type' => 'INNER']
            ),
            new Entity\ReferenceField(
                'USER',
                UserTable::class,
                ['=this.TRANSLATION_ID' => 'ref.ID'],
                ['join_type' => 'LEFT']
            ),
        ];
    }
}
<?php

use Bitrix\Main\Loader;
use MDA\Medusa\MultiShop;

require_once 'config.php';

Loader::includeModule('mda.medusa');

MultiShop::removeOldUserData();
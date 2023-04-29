<?php

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

$events = [
    [
        'module' => 'main',
        'event' => 'OnBeforeProlog',
        'callback' => ['MDA\Medusa\PrologSubscriber', 'MultiShopBasketCheckHandler'],
        'file' => '/lib/events/prologsubscriber.php',
    ],
    [
        'module' => 'sale',
        'event' => 'OnSaleOrderBeforeSaved',
        'callback' => ['MDA\Medusa\OrderSubscriber', 'MultiShopOnSaleOrderBeforeSavedHandler'],
        'file' => '/lib/events/ordersubscriber.php',
    ],
];

foreach ($events as $event) {
    $eventManager->addEventHandler(
        $event['module'],
        $event['event'],
        $event['callback'],
        __DIR__ . $event['file'],
    );
}

?>
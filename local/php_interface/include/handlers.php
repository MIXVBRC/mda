<?php

// Регистрируем события
$eventList = [
    ['module' => 'main', 'eventName' => 'OnProlog', 'eventAction' => 'OnEpilogHandler', 'sort' => 1]
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

        include_once $_SERVER["DOCUMENT_ROOT"] . '/404.php';
    }
}


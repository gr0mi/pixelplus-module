<?php

Bitrix\Main\Loader::registerAutoloadClasses(
    'im0rg.pixelplus',
    [
        'im0rg\\ClientTable' => 'lib/ClientTable.php',
        'im0rg\\TaskTable' => 'lib/TaskTable.php',
        'im0rg\\StatusTable' => 'lib/StatusTable.php',
    ]
);

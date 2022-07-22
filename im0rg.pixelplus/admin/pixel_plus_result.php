<?php

use Bitrix\Main\Loader;
use im0rg\TaskTable;

/**
 * @var string $by
 * @var string $order
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

global $APPLICATION;

Loader::includeModule('im0rg.pixelplus');

$lAdmin = new CAdminUiList(
    TaskTable::getTableName(),
    new CAdminUiSorting(
        TaskTable::getTableName(),
        "CLIENT.ID",
        "asc"
    )
);

$query = TaskTable::query()
    ->setSelect([
        'CLIENT.ID',
        'CLIENT.NAME',
        'CLIENT_TASK_COUNT',
        'CLIENT_TASK_F_SUM',
        'CLIENT_TASK_P_SUM'
    ])
    ->registerRuntimeField('CLIENT_TASK_COUNT', [
            'data_type' => 'integer',
            'expression' => ['COUNT(DISTINCT %s)', 'ID'],
        ]
    )
    ->registerRuntimeField('CLIENT_TASK_F_SUM', [
        'expression' => ['(' . TaskTable::query()
                ->setFilter([
                    '=STATUS.NAME' => 'F',
                    '=CLIENT_ID' => new Bitrix\Main\DB\SqlExpression('%s')
                ])
                ->registerRuntimeField('CLIENT_TASK_F', [
                        'data_type' => 'integer',
                        'expression' => ['SUM(%s)', 'PRICE'],
                    ]
                )
                ->setSelect([
                    'CLIENT_TASK_F'
                ])
                ->getQuery() . ')', 'CLIENT.ID']
    ])
    ->registerRuntimeField('CLIENT_TASK_P_SUM', [
        'expression' => ['(' . TaskTable::query()
                ->setFilter([
                    '=STATUS.NAME' => 'P',
                    '=CLIENT_ID' => new Bitrix\Main\DB\SqlExpression('%s')
                ])
                ->registerRuntimeField('CLIENT_TASK_F', [
                        'data_type' => 'integer',
                        'expression' => ['SUM(%s)', 'PRICE'],
                    ]
                )
                ->setSelect([
                    'CLIENT_TASK_F'
                ])
                ->getQuery() . ')', 'CLIENT.ID']
    ])
    ->setGroup([
        'CLIENT.ID'
    ])
    ->exec();

$dbResultList = new CAdminUiResult(
    $query,
    TaskTable::getTableName()
);
$dbResultList->NavStart();
$lAdmin->NavText($dbResultList->GetNavPrint('Страница'));

$lAdmin->AddHeaders([
    [
        "id" => "IM0RG_TASK_CLIENT_ID",
        "content" => "ID клиента",
        "default" => true
    ],
    [
        "id" => "IM0RG_TASK_CLIENT_NAME",
        "content" => "Название клиента",
        "default" => true
    ],
    [
        "id" => "CLIENT_TASK_F_SUM",
        "content" => 'Сумма по задачам в статусе "Выполнено"',
        "default" => true
    ],
    [
        "id" => "CLIENT_TASK_P_SUM",
        "content" => 'Сумма по задачам в статусе "В процессе"',
        "default" => true
    ],
    [
        "id" => "CLIENT_TASK_COUNT",
        "content" => "Общее количество задач клиента",
        "default" => true
    ],
]);

while ($arCCard = $dbResultList->NavNext(false)) {
    $row =& $lAdmin->AddRow(
        $arCCard["IM0RG_TASK_CLIENT_ID"]
    );
    $row->AddField("IM0RG_TASK_CLIENT_ID", $arCCard["IM0RG_TASK_CLIENT_ID"]);
    $row->AddField("IM0RG_TASK_CLIENT_NAME", $arCCard["IM0RG_TASK_CLIENT_NAME"]);
    $row->AddField("CLIENT_TASK_F_SUM", $arCCard["CLIENT_TASK_F_SUM"]);
    $row->AddField("CLIENT_TASK_P_SUM", $arCCard["CLIENT_TASK_P_SUM"]);
    $row->AddField("CLIENT_TASK_COUNT", $arCCard["CLIENT_TASK_COUNT"]);

}


$lAdmin->setContextSettings([
    "pagePath" => $APPLICATION->GetCurPage()
]);


$APPLICATION->SetTitle('Тестовое задание PixelPlus');

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

$lAdmin->DisplayList();

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");

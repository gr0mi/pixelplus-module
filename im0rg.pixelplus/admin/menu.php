<?php

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

if (ModuleManager::isModuleInstalled('im0rg.pixelplus')) {
    Loader::includeModule('im0rg.pixelplus');
    $aMenu = [
        'parent_menu' => 'global_menu_marketing',
        'sort'        => 0,
        'text'        => 'Тестовое задание PixelPlus',
        'dynamic'     => false,
        'module_id'   => 'im0rg.pixelplus',
        'items_id'    => 'im0rg.pixelplus_panel',
        'url'  => '/bitrix/admin/pixel_plus_result.php',
    ];
    return $aMenu;
}
return false;
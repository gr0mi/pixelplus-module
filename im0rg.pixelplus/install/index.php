<?php

use Bitrix\Main\ArgumentException;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\SystemException;

class im0rg_pixelplus extends CModule
{
    public function __construct()
    {
        $this->MODULE_ID = str_replace("_", ".", get_class($this));
        $this->MODULE_VERSION = "1.0.0";
        $this->MODULE_VERSION_DATE = "2022-07-22";
        $this->MODULE_NAME = "CRM PixelPlus";
        $this->MODULE_DESCRIPTION = "Функционал для вывода таблицы с суммарными данными по каждому клиенту";
        return false;
    }

    /**
     * @throws LoaderException
     * @throws SystemException
     * @throws ArgumentException
     */
    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $this->installFiles();
    }

    /**
     * @return void
     * @throws ArgumentException
     * @throws LoaderException
     * @throws SqlQueryException
     * @throws SystemException
     */
    public function doUninstall()
    {
        $this->unInstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    /**
     * @return void
     */
    public function installFiles()
    {
        CopyDirFiles(
            Loader::getLocal('modules/' . $this->MODULE_ID . '/install/admin'),
            Loader::getLocal('admin'),
            True,
            True
        );
    }

    /**
     * @return void
     */
    public function unInstallFiles()
    {
        DeleteDirFiles(
            Loader::getLocal('modules/' . $this->MODULE_ID . '/install/admin'),
            Loader::getLocal('admin')
        );
    }
}

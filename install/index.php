<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

if (class_exists('maximaster_seositemappro')) {
    return;
}

class maximaster_seositemappro extends CModule
{
    /** @var string */
    public $MODULE_ID;

    /** @var string */
    public $MODULE_VERSION;

    /** @var string */
    public $MODULE_VERSION_DATE;

    /** @var string */
    public $MODULE_NAME;

    /** @var string */
    public $MODULE_DESCRIPTION;

    /** @var string */
    public $MODULE_GROUP_RIGHTS;

    /** @var string */
    public $PARTNER_NAME;

    /** @var string */
    public $PARTNER_URI;

    public function __construct()
    {
        $this->MODULE_ID = 'maximaster.seositemappro';
        $this->MODULE_VERSION = '0.1.0';
        $this->MODULE_VERSION_DATE = '2015-06-03 16:23:14';
        $this->MODULE_NAME = Loc::getMessage('SEOSITEMAPPRO_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('SEOSITEMAPPRO_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('SEOSITEMAPPRO_PARTNER_NAME');;
        $this->PARTNER_URI = "http://www.maximaster.ru/";
    }

    public function doInstall()
    {
        $this->installFiles();
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function installFiles()
    {
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . "/local/modules/maximaster.seositemappro/install/admin", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin", true, true);
        return true;
    }

    public function doUninstall()
    {
        $this->uninstallFiles();
        ModuleManager::unregisterModule($this->MODULE_ID);
    }

    public function uninstallFiles()
    {
        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/local/modules/maximaster.seositemappro/install/admin/", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin");
        return true;
    }
}

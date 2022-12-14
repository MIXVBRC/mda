<?
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class mda_test extends CModule
{
    var $MODULE_ID;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = 'Y';

    public function __construct()
    {
        $this->MODULE_ID = $this->getModuleID();

        $arModuleVersion = [];

        include(__DIR__.'/version.php');

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        $this->MODULE_NAME = Loc::getMessage("MDA_TEST_INSTALL_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("MDA_TEST_INSTALL_DESCRIPTION");
    }

    public function getModuleID() {
        return str_ireplace('_', '.', get_class($this));
    }

    function InstallDB($install_wizard = true)
    {
        RegisterModule($this->MODULE_ID);
        return true;
    }

    function UnInstallDB($arParams = Array())
    {
        UnRegisterModule($this->MODULE_ID);
        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        return true;
    }

    function UnInstallFiles()
    {
        return true;
    }

    function DoInstall()
    {
        $this->InstallFiles();
        $this->InstallDB(false);
    }

    function DoUninstall()
    {
        $this->UnInstallDB(false);
    }
}
?>
<?

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class mda_medusa extends CModule
{
    public $MODULE_ID;
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;
    public $MODULE_GROUP_RIGHTS = 'Y';
    public $MODULE_PATH;

    public $connection;

    public function __construct()
    {
        $this->MODULE_ID = $this->getModuleID();

        $this->MODULE_NAME = Loc::getMessage("MDA_MEDUSA_INSTALL_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("MDA_MEDUSA_INSTALL_DESCRIPTION");
        $this->MODULE_PATH = $this->getModulePath();

        $arModuleVersion = [];
        include __DIR__ . '/version.php';

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        $this->connection = Application::getConnection();
    }

    private function getModulePath(): string
    {
        $explode = explode('/', __FILE__);
        $arraySlice = array_slice($explode, 0, array_search($this->MODULE_ID, $explode) + 1);
        return implode('/', $arraySlice);
    }

    public function getModuleID() {
        return str_ireplace('_', '.', get_class($this));
    }

    function InstallDB()
    {
        $sqlBatch = file_get_contents($this->MODULE_PATH . '/install/db/mysql/install.sql');
        $sqlBatchErrors = $this->connection->executeSqlBatch($sqlBatch);
        if (sizeof($sqlBatchErrors) > 0) {
            return false;
        }
        return true;
    }

    function UnInstallDB()
    {
        $sqlBatch = file_get_contents($this->MODULE_PATH . '/install/db/mysql/uninstall.sql');
        $sqlBatchErrors = $this->connection->executeSqlBatch($sqlBatch);
        if (sizeof($sqlBatchErrors) > 0) {
            return false;
        }
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
        RegisterModule($this->MODULE_ID);

        $this->InstallFiles();
        $this->InstallDB();
    }

    function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallFiles();

        UnRegisterModule($this->MODULE_ID);
    }
}
?>
<?
namespace MDA;

class ScanDir
{
    private $arDir = [];
    private $arExtension = [];

    /**
     * ScanDir constructor.
     * @param array $arExtension
     */
    public function __construct()
    {

    }

    /**
     * @param $path
     * @param array $arExtension
     * @return array
     */
    public function scan($path, $arExtension = [])
    {
        if ($arExtension) {
            foreach ($arExtension as $extension) {
                $this->arExtension[] = mb_strtolower($extension);
            }
        }

        $this->checkDir($path);
        return $this->arDir;
    }

    /**
     * @param $path
     */
    private function scanDir($path)
    {
        $arDir = array_diff(scandir($path),['..','.']);
        foreach ($arDir as $file) {
            $this->checkDir($path."/".$file);
        }
    }

    /**
     * @param $path
     */
    private function checkDir($path)
    {
        if (is_dir($path)) {
            $this->scanDir($path);
        } else {
            $this->checkExtension($path);
        }
    }

    /**
     * @param $path
     */
    private function checkExtension($path)
    {
        if (!empty($this->arExtension)) {
            if (in_array(end(explode('.', $path)), $this->arExtension)) {
                $this->arDir[] = $path;
            }
        } else {
            $this->arDir[] = $path;
        }
    }
}
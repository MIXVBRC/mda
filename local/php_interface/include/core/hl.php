<?
namespace MDA;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock;
use Bitrix\Main\Entity;

Class HL
{
    private $hl;

    public function __construct($id)
    {
        Loader::includeModule("highloadblock");
        $this->hl = (Highloadblock\HighloadBlockTable::compileEntity(Highloadblock\HighloadBlockTable::getById($id)->fetch()))->getDataClass();
    }

    /**
     * @param array $filter
     * @param array $select
     * @param array $order
     * @return mixed
     */
    public function getList(array $filter=[], array $select=[], array $order=[])
    {
        return (($this->hl)::getList([
            'filter'=>$filter,
            'select'=>$select,
            'order'=>$order
        ]))->fetchAll();
    }

    public function get(array $filter=[], array $select=[], array $order=[])
    {
        return (($this->hl)::getList([
            'filter'=>$filter,
            'select'=>$select,
            'order'=>$order
        ]))->fetch();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return ($this->hl)::add($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return ($this->hl)::update($id, $data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        return ($this->hl)::Delete($id);
    }
}
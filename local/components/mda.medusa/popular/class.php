<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\ElementPropertyTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

class PopularComponent extends CBitrixComponent
{
    protected function getPopularItemIds(): array
    {
        $ids = [];

        $query = \Bitrix\Iblock\ElementTable::query();

        $query->setLimit($this->arParams['LIMIT']);

        $query->setSelect([
            'ID',
        ]);

        $query->setFilter([
            'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
        ]);

        $query->registerRuntimeField('PROPERTY', [
            'data_type' => PropertyTable::class,
            'reference' => Join::on('ref.IBLOCK_ID', 'this.IBLOCK_ID')
                ->whereIn('ref.CODE', [$this->arParams['POPULAR_FIELD']]),
            'join_type' => 'inner',
        ]);

        $query->registerRuntimeField('ELEMENT_PROPERTY', [
            'data_type' => ElementPropertyTable::class,
            'reference' => Join::on('ref.IBLOCK_PROPERTY_ID', 'this.PROPERTY.ID')
                ->whereColumn('ref.IBLOCK_ELEMENT_ID', 'this.ID'),
            'join_type' => 'inner',
        ]);

        foreach ($query->fetchAll() as $item) {
            $ids[] = $item['ID'];
        }

        return $ids;
    }

    protected function getItems(array $ids): array
    {
        if (empty($ids)) return [];

        $items = [];
        $dbItems = CIBlockElement::GetList(
            [],
            [
                "IBLOCK_ID" => $this->arParams['IBLOCK_ID'],
                "ID" => $ids,
                "ACTIVE_DATE" => "Y",
                "ACTIVE" => "Y",
            ],
            false,
            false,
            []
        );
        while($arItem = $dbItems->GetNextElement())
        {
            $arFields = $arItem->GetFields();

            $arFields['PREVIEW_PICTURE'] = CFile::GetFileArray($arFields['PREVIEW_PICTURE']);
            $arFields['DETAIL_PICTURE'] = CFile::GetFileArray($arFields['DETAIL_PICTURE']);

            $buttons = \CIBlock::GetPanelButtons(
                $this->arParams['IBLOCK_ID'],
                $arFields['ID'],
                false,
                []
            );

            $arFields['EDIT_LINK'] = $buttons['edit']['edit_element']['ACTION_URL'];

            $items[] = $arFields;
        }
        return $items;
    }

	public function executeComponent()
	{
        if($this->startResultCache((int) $this->arParams['CACHE_TIME'], [])) {

            $itemIds = $this->getPopularItemIds();
            $this->arResult['ITEMS'] = $this->getItems($itemIds);

            $this->includeComponentTemplate();
        }

	}
}
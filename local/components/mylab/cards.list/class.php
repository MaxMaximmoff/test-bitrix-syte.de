<?php

namespace MYLab\Components;

use Bitrix\Iblock\IblockTable;
use \Bitrix\Main\ArgumentException;
use \Bitrix\Main\Grid\Options as GridOptions;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
use \Bitrix\Main\UI\PageNavigation;
use \CBitrixComponent;
use \CIBlockElement;
use \Exception;
use \Bitrix\Main\UI\Filter\Options;

/**
 * Class CardsListComponent
 * @package MYLab\Components
 * Компонент отображения списка элементов нашего ИБ
 */
class CardsListComponent extends CBitrixComponent
{
    /** @var int $idIBlock ID информационного блока */
    private $idIBlock;

    /** @var string $templateName Имя шаблона компонента */
    private $templateName;

    /**
     * @param $arParams
     * @return array
     * @throws \Bitrix\Main\LoaderException
     */
    public function onPrepareComponentParams($arParams)
    {
        Loader::includeModule('iblock');

        $this->templateName = $this->GetTemplateName();

        return $arParams;
    }

    /**
     * Метод executeComponent
     *
     * @return mixed|void
     * @throws Exception
     */
    public function executeComponent()
    {
        $this->idIBlock = self::getIBlockIdByCode($this->arParams['IBLOCK_CODE']);

        if ($this->templateName == 'grid') {
            $this->showByGrid();
        } else {
            $this->arResult['ITEMS'] = $this->getElements();
        }


        $this->includeComponentTemplate();
    }

    /**
     * Получим элементы ИБ
     * @return array
     */
    public function getElements(): array
    {
        $result = [];

      // Фильтрация
        $arFilter = $this->getGridFilterValues();
      // Постраничная навигация
        if (!$this->getGridNav()->allRecordsShown()) {
          $arNav['iNumPage'] = $this->getGridNav()->getCurrentPage();
          $arNav['nPageSize'] = $this->getGridNav()->getPageSize();
        } else {
          $arNav = false;
        }
      // Сортировка
        $arCurSort = $this->getObGridParams()->getSorting(['sort' => ['ID' => 'DESC']])['sort'];

        $elements = CIBlockElement::GetList(
//            [],
            $arCurSort,
            $arFilter,
            false,
//            false,
            $arNav,
            ['ID', 'IBLOCK_ID', 'PROPERTY_CARD_NUMBER', 'PROPERTY_CARD_USER', 'PROPERTY_CARD_TYPE',
              'PROPERTY_CARD_MAINTENANCE_COST', 'PROPERTY_CARD_VALID_PERIOD', 'PROPERTY_CARD_EXPIRATION_DATE']
        );


        while ($element = $elements->GetNext()) {
            $cardSecret = md5($element['PROPERTY_CARD_NUMBER_VALUE']);
            $cardTotalCost = (int)$element['PROPERTY_CARD_MAINTENANCE_COST_VALUE'] * (int)$element['PROPERTY_CARD_VALID_PERIOD_VALUE'];

            $result[] = [
                'ID' => $element['ID'],
                'CARD_NUMBER' => $element['PROPERTY_CARD_NUMBER_VALUE'],
                'CARD_USER' => $element['PROPERTY_CARD_USER_VALUE'],
                'CARD_TYPE' => $element['PROPERTY_CARD_TYPE_VALUE'],
                'CARD_MAINTENANCE_COST' => $element['PROPERTY_CARD_MAINTENANCE_COST_VALUE'],
                'CARD_VALID_PERIOD' => $element['PROPERTY_CARD_VALID_PERIOD_VALUE'],
                'CARD_EXPIRATION_DATE' => $element['PROPERTY_CARD_EXPIRATION_DATE_VALUE'],
                'CARD_TOTAL_COST' => $cardTotalCost,
                'CARD_SECRET' => $cardSecret,
            ];
        }

        return $result;
    }

    /**
     * Отображение через грид
     */
    public function showByGrid()
    {
        $this->arResult['GRID_ID'] = $this->getGridId();

        $this->arResult['GRID_BODY'] = $this->getGridBody();
        $this->arResult['GRID_HEAD'] = $this->getGridHead();

        $this->arResult['GRID_NAV'] = $this->getGridNav();
        $this->arResult['GRID_FILTER'] = $this->getGridFilterParams();

        $this->arResult['BUTTONS']['ADD']['NAME'] = Loc::getMessage('MYLAB.CARD.LIST.CLASS.ADD');
    }

    /**
     * Возвращает содержимое (тело) таблицы.
     *
     * @return array
     */
    private function getGridBody(): array
    {
        $arBody = [];

        $arItems = $this->getElements();

        foreach ($arItems as $arItem) {
            $arGridElement = [];

            $arGridElement['data'] = [
                'ID' => $arItem['ID'],
                'CARD_NUMBER' => $arItem['CARD_NUMBER'],
                'CARD_USER' => $arItem['CARD_USER'],
                'CARD_TYPE' => $arItem['CARD_TYPE'],
                'CARD_MAINTENANCE_COST' => $arItem['CARD_MAINTENANCE_COST'],
                'CARD_VALID_PERIOD' => $arItem['CARD_VALID_PERIOD'],
                'CARD_EXPIRATION_DATE' => $arItem['CARD_EXPIRATION_DATE'],
                'CARD_TOTAL_COST' => $arItem['CARD_TOTAL_COST'],
                'CARD_SECRET' => $arItem['CARD_SECRET'],
            ];

            $arGridElement['actions'] = [
                [
                  'text' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.DELETE'),
                  'onclick' => 'document.location.href="/accountant/reports/'.$arItem['ID'].'/edit/"'
                ],
                [
                  'text' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.EDIT'),
                  'onclick' => 'document.location.href="/accountant/reports/'.$arItem['ID'].'/delete/"'
              ],
            ];
            $arBody[] = $arGridElement;
        }

        return $arBody;
    }

    /**
     * Возвращает идентификатор грида.
     *
     * @return string
     */
    private function getGridId(): string
    {
        return 'mylab_cards_list_' . $this->idIBlock;
    }

    /**
     * Возращает заголовки таблицы.
     *
     * @return array
     */
    private function getGridHead(): array
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'default' => true,
                'sort' => 'ID',
            ],
            [
                'id' => 'CARD_NUMBER',
                'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.NUMBER'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_NUMBER',
            ],
            [
                'id' => 'CARD_USER',
                'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.USER'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_USER',
            ],
            [
                'id' => 'CARD_TYPE',
                'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.TYPE'),
                'default' => true,
            ],
            [
              'id' => 'CARD_MAINTENANCE_COST',
              'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.COST'),
              'default' => true,
            ],
            [
              'id' => 'CARD_VALID_PERIOD',
              'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.PERIOD'),
              'default' => true,
            ],
            [
              'id' => 'CARD_EXPIRATION_DATE',
              'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.EXP_DATA'),
              'default' => true,
            ],
            [
              'id' => 'CARD_TOTAL_COST',
              'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.TOTAL_COST'),
              'default' => true,
            ],
            [
                'id' => 'CARD_SECRET',
                'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.SECRET'),
                'default' => true,
            ],
        ];
    }

    /**
     * Метод возвращает ID инфоблока по символьному коду
     *
     * @param $code
     *
     * @return int|void
     * @throws Exception
     */
    public static function getIBlockIdByCode($code)
    {
        $IB = IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['CODE' => $code],
            'limit' => '1',
            'cache' => ['ttl' => 3600],
        ]);
        $return = $IB->fetch();
        if (!$return) {
            throw new Exception('IBlock with code"' . $code . '" not found');
        }

        return $return['ID'];
    }

    /**
     * Возвращает настройки отображения грид фильтра.
     *
     * @return array
     */
    private function getGridFilterParams(): array
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'type' => 'number'
            ],
            [
              'id' => 'PROPERTY_CARD_MAINTENANCE_COST_VALUE',
              'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.COST'),
              'type' => 'number'
            ],
            [
              'id' => 'PROPERTY_CARD_EXPIRATION_DATE_VALUE',
              'name' => Loc::getMessage('MYLAB.CARD.LIST.CLASS.EXP_DATA'),
              'type' => 'date'
            ],
        ];
    }

    /**
     * Возвращает единственный экземпляр настроек грида.
     *
     * @return GridOptions
     */
    private function getObGridParams(): GridOptions
    {
        return $this->gridOption ?? $this->gridOption = new GridOptions($this->getGridId());
    }

    /**
     * Параметры навигации грида
     *
     * @return PageNavigation
     */
    private function getGridNav(): PageNavigation
    {
        if ($this->gridNav === null) {
            $this->gridNav = new PageNavigation($this->getGridId());
            $this->gridNav->allowAllRecords(true)->setPageSize($this->getObGridParams()->GetNavParams()['nPageSize'])
                ->initFromUri();
        }

        return $this->gridNav;
    }

    /**
     * Возвращает значения грид фильтра.
     *
     * @return array
     */
    public function getGridFilterValues(): array
    {
        $obFilterOption = new Options($this->getGridId());
        $arFilterData = $obFilterOption->getFilter([]);
        $baseFilter = array_intersect_key($arFilterData, array_flip($obFilterOption->getUsedFields()));
        $formatedFilter = $this->prepareFilter($arFilterData, $baseFilter);

        return array_merge(
            $baseFilter,
            $formatedFilter
        );
    }

    /**
     * Подготавливает параметры фильтра
     * @param array $arFilterData
     * @param array $baseFilter
     * @return array
     */
    public function prepareFilter(array $arFilterData, &$baseFilter = []): array
    {

//      var_dump($arFilterData);
        $arFilter = [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $this->idIBlock,
        ];

        if (!empty($arFilterData['ID_from'])) {
            $arFilter['>=ID'] = (int)$arFilterData['ID_from'];
        }
        if (!empty($arFilterData['ID_to'])) {
            $arFilter['<=ID'] = (int)$arFilterData['ID_to'];
        }

        if (!empty($arFilterData['PROPERTY_CARD_MAINTENANCE_COST_VALUE_from'])) {
          $arFilter['>=PROPERTY_CARD_MAINTENANCE_COST'] = (int)$arFilterData['PROPERTY_CARD_MAINTENANCE_COST_VALUE_from'];
        }
        if (!empty($arFilterData['PROPERTY_CARD_MAINTENANCE_COST_VALUE_to'])) {
          $arFilter['<=PROPERTY_CARD_MAINTENANCE_COST'] = (int)$arFilterData['PROPERTY_CARD_MAINTENANCE_COST_VALUE_to'];
        }

        if (!empty($arFilterData['PROPERTY_CARD_EXPIRATION_DATE_VALUE_from'])) {
          $arFilter['>=PROPERTY_CARD_EXPIRATION_DATE'] = date(
            "Y-m-d",
            strtotime($arFilterData['PROPERTY_CARD_EXPIRATION_DATE_VALUE_from']));
        }
        if (!empty($arFilterData['PROPERTY_CARD_EXPIRATION_DATE_VALUE_to'])) {
          $arFilter['<=PROPERTY_CARD_EXPIRATION_DATE'] = date(
            "Y-m-d",
            strtotime($arFilterData['PROPERTY_CARD_EXPIRATION_DATE_VALUE_to']));
        }

//        var_dump($arFilter);
        return $arFilter;
    }

}

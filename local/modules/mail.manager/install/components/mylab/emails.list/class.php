<?php

namespace MYLab\Components;

use Bitrix\Iblock\IblockTable;
use \Bitrix\Main\ArgumentException;
use \Bitrix\Main\Grid\Options as GridOptions;
use \Bitrix\Main\Localization\Loc;
use Mail\Manager\Profile;
use \Bitrix\Main\Loader;
use \Bitrix\Main\UI\PageNavigation;
use \CBitrixComponent;
use \CIBlockElement;
use \Exception;
use \Bitrix\Main\UI\Filter\Options;

/**
 * Class EmailsListComponent
 * @package MYLab\Components
 */
class EmailsListComponent extends CBitrixComponent
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
        Loader::includeModule('mail.manager');

        if ($this->templateName == 'grid') {
            $this->showByGrid();
        } else {

            $profile = new Profile();

            $this->arResult = $profile->getProfiles();

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

        $profile = new Profile();

        $arResult = $profile->getProfiles();

        foreach ($arResult['PROFILES'] as $profile) {

          $result[] = [
              'ID' => $profile['ID'],
              'NAME' => $profile['NAME'],
              'EMAIL' => $profile['EMAIL'],
              'CITY' => $profile['MAIL_MANAGER_ORM_EMAILS_ADDR_CITY'],
              'STREET' => $profile['MAIL_MANAGER_ORM_EMAILS_ADDR_STREET'],
              'HOUSE' => $profile['MAIL_MANAGER_ORM_EMAILS_ADDR_HOUSE']
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

        $this->arResult['BUTTONS']['ADD']['NAME'] = Loc::getMessage('MYLAB.EMAIL.LIST.CLASS.ADD');
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
                'NAME' => $arItem['NAME'],
                'EMAIL' => $arItem['EMAIL'],
                'CITY' => $arItem['CITY'],
                'STREET' => $arItem['STREET'],
                'HOUSE' => $arItem['HOUSE']
            ];

            $arGridElement['actions'] = [
                [
                  'text' => Loc::getMessage('MYLAB.EMAIL.LIST.CLASS.DELETE'),
                  'onclick' => 'document.location.href="/'.$arItem['ID'].'/edit/"'
//                'onclick' => 'if(confirm("Точно?")){document.location.href="?op=delete&id='.$arItem['ID'].'"}'
                ],
                [
                  'text' => Loc::getMessage('MYLAB.EMAIL.LIST.CLASS.EDIT'),
                  'onclick' => 'document.location.href="/'.$arItem['ID'].'/edit/"'
//                  'onclick' => "jsUtils.Redirect(arguments, '/bitrix/admin/user_edit.php')",
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
        return 'mylab_emails_list_' . $this->idIBlock;
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
                'id' => 'NAME',
                'name' => Loc::getMessage('MYLAB.EMAIL.LIST.CLASS.NAME'),
                'default' => true,
                'sort' => 'PROPERTY_NAME',
            ],
            [
                'id' => 'EMAIL',
                'name' => Loc::getMessage('MYLAB.EMAIL.LIST.CLASS.EMAIL'),
                'default' => true,
                'sort' => 'PROPERTY_EMAIL',
            ],
            [
                'id' => 'CITY',
                'name' => Loc::getMessage('MYLAB.EMAIL.LIST.CLASS.CITY'),
                'default' => true,
            ],
            [
              'id' => 'STREET',
              'name' => Loc::getMessage('MYLAB.EMAIL.LIST.CLASS.STREET'),
              'default' => true,
            ],
            [
              'id' => 'HOUSE',
              'name' => Loc::getMessage('MYLAB.EMAIL.LIST.CLASS.HOUSE'),
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

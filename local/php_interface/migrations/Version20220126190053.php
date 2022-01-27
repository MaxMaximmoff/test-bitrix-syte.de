<?php

namespace Sprint\Migration;


class Version20220126190053 extends Version
{
    protected $description = "Добавление свойств: Стоимость обслуживания, Срок действия карты, Дата окончания действия карты";

    protected $moduleVersion = "4.0.5";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->getIblockIdIfExists('credit_card', 'cards');
        $helper->Iblock()->saveProperty($iblockId, array (
  'NAME' => 'Стоимость обслуживания карты в месяц',
  'ACTIVE' => 'Y',
  'SORT' => '500',
  'CODE' => 'CARD_MAINTENANCE_COST',
  'DEFAULT_VALUE' => '',
  'PROPERTY_TYPE' => 'N',
  'ROW_COUNT' => '1',
  'COL_COUNT' => '30',
  'LIST_TYPE' => 'L',
  'MULTIPLE' => 'N',
  'XML_ID' => NULL,
  'FILE_TYPE' => '',
  'MULTIPLE_CNT' => '5',
  'LINK_IBLOCK_ID' => '0',
  'WITH_DESCRIPTION' => 'N',
  'SEARCHABLE' => 'N',
  'FILTRABLE' => 'N',
  'IS_REQUIRED' => 'N',
  'VERSION' => '2',
  'USER_TYPE' => NULL,
  'USER_TYPE_SETTINGS' => NULL,
  'HINT' => '',
));
            $helper->Iblock()->saveProperty($iblockId, array (
  'NAME' => 'Срок действия карты (в месяцах)',
  'ACTIVE' => 'Y',
  'SORT' => '500',
  'CODE' => 'CARD_VALID_PERIOD',
  'DEFAULT_VALUE' => '',
  'PROPERTY_TYPE' => 'N',
  'ROW_COUNT' => '1',
  'COL_COUNT' => '30',
  'LIST_TYPE' => 'L',
  'MULTIPLE' => 'N',
  'XML_ID' => NULL,
  'FILE_TYPE' => '',
  'MULTIPLE_CNT' => '5',
  'LINK_IBLOCK_ID' => '0',
  'WITH_DESCRIPTION' => 'N',
  'SEARCHABLE' => 'N',
  'FILTRABLE' => 'N',
  'IS_REQUIRED' => 'N',
  'VERSION' => '2',
  'USER_TYPE' => NULL,
  'USER_TYPE_SETTINGS' => NULL,
  'HINT' => '',
));
            $helper->Iblock()->saveProperty($iblockId, array (
  'NAME' => 'Дата окончания действия карты',
  'ACTIVE' => 'Y',
  'SORT' => '500',
  'CODE' => 'CARD_EXPIRATION_DATE',
  'DEFAULT_VALUE' => NULL,
  'PROPERTY_TYPE' => 'S',
  'ROW_COUNT' => '1',
  'COL_COUNT' => '30',
  'LIST_TYPE' => 'L',
  'MULTIPLE' => 'N',
  'XML_ID' => NULL,
  'FILE_TYPE' => '',
  'MULTIPLE_CNT' => '5',
  'LINK_IBLOCK_ID' => '0',
  'WITH_DESCRIPTION' => 'N',
  'SEARCHABLE' => 'N',
  'FILTRABLE' => 'N',
  'IS_REQUIRED' => 'N',
  'VERSION' => '2',
  'USER_TYPE' => 'Date',
  'USER_TYPE_SETTINGS' => NULL,
  'HINT' => '',
));
    
    }

    public function down()
    {
      $helper = $this->getHelperManager();

      $iblockId = $helper->Iblock()->getIblockIdIfExists('credit_card', 'cards');

      $helper->Iblock()->deletePropertyIfExists($iblockId, 'CARD_MAINTENANCE_COST');
      $helper->Iblock()->deletePropertyIfExists($iblockId, 'CARD_VALID_PERIOD');
      $helper->Iblock()->deletePropertyIfExists($iblockId, 'CARD_EXPIRATION_DATE');
    }
}

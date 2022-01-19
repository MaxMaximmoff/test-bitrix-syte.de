<?php

namespace Sprint\Migration;


class Version20220119121250 extends Version
{
    protected $description = "Миграция со свойством Скидка v2";

    protected $moduleVersion = "4.0.5";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->getIblockIdIfExists('sale_promotions', 'promotions');
        $helper->Iblock()->saveProperty($iblockId, array (
          'NAME' => 'Скидка',
          'ACTIVE' => 'Y',
          'SORT' => '500',
          'CODE' => 'DISCOUNT_AMOUNT',
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
    
    }

    public function down()
    {
      $helper = $this->getHelperManager();

      $iblockId = $helper->Iblock()->getIblockIdIfExists('sale_promotions', 'promotions');

      $helper->Iblock()->deletePropertyIfExists($iblockId , 'DISCOUNT_AMOUNT');
    }
}

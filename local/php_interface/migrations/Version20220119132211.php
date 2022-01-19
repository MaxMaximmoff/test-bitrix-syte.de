<?php

namespace Sprint\Migration;


class Version20220119132211 extends Version
{
    protected $description = "Тестовая миграция для инфоблока v2";

    protected $moduleVersion = "4.0.5";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Iblock()->saveIblockType(array (
          'ID' => 'promotions',
          'SECTIONS' => 'N',
          'EDIT_FILE_BEFORE' => NULL,
          'EDIT_FILE_AFTER' => NULL,
          'IN_RSS' => 'Y',
          'SORT' => '50',
          'LANG' =>
          array (
            'ru' =>
            array (
              'NAME' => 'Акции',
              'SECTION_NAME' => '',
              'ELEMENT_NAME' => 'Акции',
            ),
            'en' =>
            array (
              'NAME' => 'Promotions',
              'SECTION_NAME' => '',
              'ELEMENT_NAME' => 'Promotions',
            ),
          ),
        ));
        $iblockId = $helper->Iblock()->saveIblock(array (
          'IBLOCK_TYPE_ID' => 'promotions',
          'LID' =>
          array (
            0 => 's1',
          ),
          'CODE' => 'sale_promotions',
          'API_CODE' => NULL,
          'REST_ON' => 'N',
          'NAME' => 'Акции по распродажам',
          'ACTIVE' => 'Y',
          'SORT' => '500',
          'LIST_PAGE_URL' => '#SITE_DIR#/promotions/index.php?ID=#IBLOCK_ID#',
          'DETAIL_PAGE_URL' => '#SITE_DIR#/promotions/detail.php?ID=#ELEMENT_ID#',
          'SECTION_PAGE_URL' => NULL,
          'CANONICAL_PAGE_URL' => '',
          'PICTURE' => NULL,
          'DESCRIPTION' => '',
          'DESCRIPTION_TYPE' => 'text',
          'RSS_TTL' => '24',
          'RSS_ACTIVE' => 'N',
          'RSS_FILE_ACTIVE' => 'N',
          'RSS_FILE_LIMIT' => '10',
          'RSS_FILE_DAYS' => '7',
          'RSS_YANDEX_ACTIVE' => 'N',
          'XML_ID' => NULL,
          'INDEX_ELEMENT' => 'Y',
          'INDEX_SECTION' => 'N',
          'WORKFLOW' => 'N',
          'BIZPROC' => 'N',
          'SECTION_CHOOSER' => 'L',
          'LIST_MODE' => '',
          'RIGHTS_MODE' => 'S',
          'SECTION_PROPERTY' => 'Y',
          'PROPERTY_INDEX' => 'N',
          'VERSION' => '2',
          'LAST_CONV_ELEMENT' => '0',
          'SOCNET_GROUP_ID' => NULL,
          'EDIT_FILE_BEFORE' => '',
          'EDIT_FILE_AFTER' => '',
          'SECTIONS_NAME' => 'Разделы',
          'SECTION_NAME' => 'Раздел',
          'ELEMENTS_NAME' => 'Элементы',
          'ELEMENT_NAME' => 'Элемент',
          'EXTERNAL_ID' => NULL,
          'LANG_DIR' => '/',
          'SERVER_NAME' => NULL,
          'IPROPERTY_TEMPLATES' =>
          array (
          ),
          'ELEMENT_ADD' => 'Добавить элемент',
          'ELEMENT_EDIT' => 'Изменить элемент',
          'ELEMENT_DELETE' => 'Удалить элемент',
          'SECTION_ADD' => 'Добавить раздел',
          'SECTION_EDIT' => 'Изменить раздел',
          'SECTION_DELETE' => 'Удалить раздел',
        ));

    }

    public function down()
    {
      $helper = $this->getHelperManager();

      $helper->Iblock()->deleteIblockIfExists('sale_promotions');
    }
}

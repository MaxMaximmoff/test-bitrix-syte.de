<?php

namespace Mail\Manager\Orm;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

/**
 * Class ProfilesTable
 * @package app\Orm
 */
class AddressesTable extends Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     * @return string
     */
    public static function getTableName()
    {
        return 'y_addresses';
    }

    /**
     * Returns entity map definition.
     * @return array
     * @throws \Exception
     */
  public static function getMap()
  {
    return [
      new Entity\IntegerField('ID', [
        'primary' => true,
        'autocomplete' => true,
        'title' => 'ID',
      ]),
      new Entity\StringField('CITY', [
          'required' => true,
          'validation' => [__CLASS__, 'validateCity'],
          'title' => Loc::getMessage('YLAB_MAIL_MANAGER_PROFILE_CITY_FIELD')
        ]
      ),
      new Entity\StringField('STREET', [
          'required' => true,
          'validation' => [__CLASS__, 'validateStreet'],
          'title' => Loc::getMessage('YLAB_MAIL_MANAGER_PROFILE_STREET_FIELD')
        ]
      ),
      new Entity\IntegerField('HOUSE', [
          'required' => true,
          'title' => Loc::getMessage('YLAB_MAIL_MANAGER_PROFILE_HOUSE_FIELD')
        ]
      ),
    ];
  }

  /**
   * Returns validators for CITY field.
   * @throws \Bitrix\Main\ArgumentTypeException
   * @return array
   */
  public static function validateCity()
  {
    return [
      new Entity\Validator\Length(null, 255),
    ];
  }

  /**
   * Returns validators for STREET field.
   * @throws \Bitrix\Main\ArgumentTypeException
   * @return array
   */
  public static function validateStreet()
  {
    return [
      new Entity\Validator\Length(null, 255),
    ];
  }
}

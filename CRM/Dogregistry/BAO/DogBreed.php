<?php
// phpcs:disable
use CRM_Dogregistry_ExtensionUtil as E;
// phpcs:enable

class CRM_Dogregistry_BAO_DogBreed extends CRM_Dogregistry_DAO_DogBreed {

  /**
   * Create a new DogBreed based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Dogregistry_DAO_DogBreed|NULL
   */
  /*
  public static function create($params) {
    $className = 'CRM_Dogregistry_DAO_DogBreed';
    $entityName = 'DogBreed';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }
  */

}

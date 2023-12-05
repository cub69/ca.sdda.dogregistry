<?php
// phpcs:disable
use CRM_Dogregistry_ExtensionUtil as E;
// phpcs:enable

class CRM_Dogregistry_BAO_DogScores extends CRM_Dogregistry_DAO_DogScores {

  /**
   * Create a new DogScores based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Dogregistry_DAO_DogScores|NULL
   */
  /*
  public static function create($params) {
    $className = 'CRM_Dogregistry_DAO_DogScores';
    $entityName = 'DogScores';
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

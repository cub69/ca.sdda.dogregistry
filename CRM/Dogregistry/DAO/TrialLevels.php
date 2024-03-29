<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from ca.sdda.dogregistry/xml/schema/CRM/Dogregistry/TrialLevels.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:2a3fb8467f40f30582c0d5a473c376ac)
 */
use CRM_Dogregistry_ExtensionUtil as E;

/**
 * Database access object for the TrialLevels entity.
 */
class CRM_Dogregistry_DAO_TrialLevels extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_trial_levels';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique TrialLevels ID
   *
   * @var string|null
   *   (SQL type: text)
   *   Note that values will be retrieved from the database as a string.
   */
  public $id;

  /**
   * Description
   *
   * @var string|null
   *   (SQL type: varchar(50))
   *   Note that values will be retrieved from the database as a string.
   */
  public $Description;

  /**
   * Level
   *
   * @var string|null
   *   (SQL type: INT)
   *   Note that values will be retrieved from the database as a string.
   */
  public $Level;

  /**
   * Maximum points
   *
   * @var string|null
   *   (SQL type: INT)
   *   Note that values will be retrieved from the database as a string.
   */
  public $MaxPoints;

  /**
   * Pass points
   *
   * @var string|null
   *   (SQL type: INT)
   *   Note that values will be retrieved from the database as a string.
   */
  public $PassPoints;

  /**
   * Weight
   *
   * @var string|null
   *   (SQL type: INT)
   *   Note that values will be retrieved from the database as a string.
   */
  public $Weight;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_trial_levels';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Trial Levelses') : E::ts('Trial Levels');
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('ID'),
          'description' => E::ts('Unique TrialLevels ID'),
          'required' => TRUE,
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_trial_levels.id',
          'table_name' => 'civicrm_trial_levels',
          'entity' => 'TrialLevels',
          'bao' => 'CRM_Dogregistry_DAO_TrialLevels',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => NULL,
        ],
        'Description' => [
          'name' => 'Description',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Description'),
          'description' => E::ts('Description'),
          'maxlength' => 50,
          'size' => CRM_Utils_Type::BIG,
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_trial_levels.Description',
          'table_name' => 'civicrm_trial_levels',
          'entity' => 'TrialLevels',
          'bao' => 'CRM_Dogregistry_DAO_TrialLevels',
          'localizable' => 0,
          'html' => [
            'label' => E::ts("Description"),
          ],
          'add' => NULL,
        ],
        'Level' => [
          'name' => 'Level',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Level'),
          'description' => E::ts('Level'),
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_trial_levels.Level',
          'table_name' => 'civicrm_trial_levels',
          'entity' => 'TrialLevels',
          'bao' => 'CRM_Dogregistry_DAO_TrialLevels',
          'localizable' => 0,
          'html' => [
            'label' => E::ts("Level"),
          ],
          'add' => NULL,
        ],
        'MaxPoints' => [
          'name' => 'MaxPoints',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Maxpoints'),
          'description' => E::ts('Maximum points'),
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_trial_levels.MaxPoints',
          'table_name' => 'civicrm_trial_levels',
          'entity' => 'TrialLevels',
          'bao' => 'CRM_Dogregistry_DAO_TrialLevels',
          'localizable' => 0,
          'html' => [
            'label' => E::ts("Maximum points"),
          ],
          'add' => NULL,
        ],
        'PassPoints' => [
          'name' => 'PassPoints',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Passpoints'),
          'description' => E::ts('Pass points'),
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_trial_levels.PassPoints',
          'table_name' => 'civicrm_trial_levels',
          'entity' => 'TrialLevels',
          'bao' => 'CRM_Dogregistry_DAO_TrialLevels',
          'localizable' => 0,
          'html' => [
            'label' => E::ts("Pass points"),
          ],
          'add' => NULL,
        ],
        'Weight' => [
          'name' => 'Weight',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Weight'),
          'description' => E::ts('Weight'),
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_trial_levels.Weight',
          'table_name' => 'civicrm_trial_levels',
          'entity' => 'TrialLevels',
          'bao' => 'CRM_Dogregistry_DAO_TrialLevels',
          'localizable' => 0,
          'html' => [
            'label' => E::ts("Weight"),
          ],
          'add' => NULL,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'trial_levels', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'trial_levels', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}

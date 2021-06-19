<?php

require_once 'dogregistry.civix.php';
use CRM_Dogregistry_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function dogregistry_civicrm_config(&$config) {
  _dogregistry_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function dogregistry_civicrm_xmlMenu(&$files) {
  _dogregistry_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function dogregistry_civicrm_install() {
  _dogregistry_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function dogregistry_civicrm_postInstall() {
  _dogregistry_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function dogregistry_civicrm_uninstall() {
  _dogregistry_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function dogregistry_civicrm_enable() {
  _dogregistry_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function dogregistry_civicrm_disable() {
  _dogregistry_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function dogregistry_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _dogregistry_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function dogregistry_civicrm_managed(&$entities) {
  _dogregistry_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function dogregistry_civicrm_caseTypes(&$caseTypes) {
  _dogregistry_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function dogregistry_civicrm_angularModules(&$angularModules) {
  _dogregistry_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function dogregistry_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _dogregistry_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function dogregistry_civicrm_entityTypes(&$entityTypes) {
  _dogregistry_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function dogregistry_civicrm_preProcess($formName, &$form) {

} // */


function dogregistry_civicrm_tabset($tabsetName, &$tabs, $context) {
  
   if ($tabsetName == 'civicrm/contact/view') {
	$contactId = $context['contact_id'];

  $dogs = civicrm_api3('RegisteredDogs', 'getcount', ['contact_id' => $contactId,]);
	$url = CRM_Utils_System::url( 'civicrm/listregdogs', "reset=1&force=1&cid={$contactId}");
  	$tabs[] = array( 'id'    => 'Registered Dogs',
                   'url'   => $url,
                   'title' => 'Registered Dogs',
                   'count' => $dogs,
                   'weight' => 99 );
  }
}

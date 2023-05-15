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
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function dogregistry_civicrm_install() {
  _dogregistry_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function dogregistry_civicrm_enable() {
  _dogregistry_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *

 // */


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

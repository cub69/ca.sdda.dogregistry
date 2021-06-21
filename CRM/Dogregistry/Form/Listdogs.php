<?php

use CRM_Dogregistry_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Dogregistry_Form_Listdogs extends CRM_Core_Form {
  public $contactid;

  public function preprocess() {
    CRM_Utils_System::setTitle(E::ts('List Dogs'));
    $this->assign('url',$this->_url);
    if ( is_user_logged_in() ) { 
      $current_user = wp_get_current_user();
      global $current_user;
      $contact = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email]);
      $contactid = $contact['contact_id'];
      $this->assign('contactid', $contactid);
  
    } 
  }

  public function buildQuickForm() {
    //$this->add('text','dog_number','Dog number: ',array('size'=>5, 'maxlength' => 5));
    $this->add('select','dog_number','Dog for Card',$this->getOptions("dog"),FALSE);

      $this->addButtons(array(
        array(
          'type' => 'done',
          'name' => E::ts('Send Card'),
          'isDefault' => FALSE,
        ),
        
      ));
    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    error_log(print_r($values,TRUE));
    if ($values["_qf_Listdogs_done"]) {
      $dog = $values['dog_number'];
      error_log("Dog number pre: ".$dog);
      $result = sdda_display_dog_card($dog);
      CRM_Core_Session::setStatus(E::ts("An email with your dog's card has been sent!"));
      $url = CRM_Utils_System::url( 'civicrm/listdogs', "" );
      CRM_Core_Session::singleton()->pushUserContext($url);
    }

    parent::postProcess();
  }
  public function getOptions($optionType) {
    
  	if ($optionType =="dog") {
      $current_user = wp_get_current_user();
      $contact = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email]);
      $contactid = $contact['contact_id'];
      $result = civicrm_api3('Registered_dogs', 'get', ['contact_id' => $contactid]);
      $dogs=$result['values'];
      $options = array();
      foreach($dogs as $dog) {
        if (!$dog['inactive_date']) {
        $options[$dog['id']] = $dog['registered_name'];
        }
      }
 		return $options;
    }
  }
    /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */

  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

 
}

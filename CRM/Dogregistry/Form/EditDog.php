<?php

use CRM_Dogregistry_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */ 
class CRM_Dogregistry_Form_EditDog extends CRM_Core_Form {

public $_id;
public $_action;
public $_cid;

  public function preProcess() {
	// do prep work  
//$this->preventAjaxSubmit();

	CRM_Utils_System::setTitle(E::ts('Registered Dog'));
	$this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);	
	error_log($this->_action);
  if ($this->_action == 2) {
		$this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
		$dog = civicrm_api3('RegisteredDogs', 'get', ['id' => $this->_id,]);
		$dogEntry = $dog['values'][$this->_id];

		$this->setDefaults(array( 
	    	'registered_name' => $dogEntry['registered_name'],
   	 	'call_name' =>  $dogEntry['call_name'],
    		'preferred_name' => $dogEntry['preferred_name'],
    		'gender' => $dogEntry['sex'],
    		'altered' => $dogEntry['altered'],
    		'date_of_birth' => $dogEntry['date_of_birth'],
    		'active_date' => $dogEntry['active_date'],
    		'inactive_date' => $dogEntry['inactive_date'],
    		'breed_name' => $dogEntry['breed_name'],
		));
	} elseif ($this->_action == 1) {
		$this->_cid = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
	}
}

  public function buildQuickForm() {
	  
	 // add form elements
    $this->add(
    	'text',
		'registered_name',
		'Registered Name',
		 TRUE    	
    	);
	$this->add(
		'text',
		'call_name',
		'Call Name',
		TRUE
	);
	$this->add(
		'select',
		'preferred_name',
		'Preferred Name',
		$this->getOptions("preferred"),
		TRUE
	);
	
	$this->add(
		'select',
		'gender',
		'Gender',
		$this->getOptions("sex"),
		TRUE
	);
	$this->add(
		'checkbox',
		'altered',
		'Altered',
		TRUE
	);
		$this->add(
		'date',
		'date_of_birth',
		ts('Date of Birth'),
      CRM_Core_SelectValues::date(NULL, 'Y M d',15,1)
	);
	
	$this->add(
		'date',
		'active_date',
		'Active Date',
      CRM_Core_SelectValues::date(NULL, 'Y M d',15,1)
	);
	$this->add(
		'date',
		'inactive_date',
		'Inactive Date',
      CRM_Core_SelectValues::date(NULL, 'Y M d',15,1)
	);
	$this->add(
		'select',
		'breed_name',
		'Breed Name',
		$this->getOptions("breed"),
		TRUE
	);
		
    $this->addButtons(array(
      array(
        'type' => 'done',
        'name' => E::ts('Submit'),
        'isDefault' => FALSE,
      ),
      array(
        'type' => 'cancel',
        'name' => E::ts('Cancel'),
        'isDefault' => TRUE,
      ),
      
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    var_error_log($values);
    error_log($values['date_of_birth']['M']);
    if (strlen($values['date_of_birth']['M']) > 0) {
	if ($values['date_of_birth']['M'] < 10){$values['date_of_birth']['M']= '0'.$values['date_of_birth']['M'];}
    	if ($values['date_of_birth']['d'] < 10){$values['date_of_birth']['d']= '0'.$values['date_of_birth']['d'];}
    	$newdate = $values['date_of_birth']['Y']."-".$values['date_of_birth']['M']."-".$values['date_of_birth']['d'];
    } else {
        $newdate = "";
    }
    if (strlen($values['inactive_date']['M']) > 0) {
    	if ($values['inactive_date']['M'] < 10){$values['inactive_date']['M']= '0'.$values['inactive_date']['M'];}
    	if ($values['inactive_date']['d'] < 10){$values['inactive_date']['d']= '0'.$values['inactive_date']['d'];}
    	$incdate = $values['inactive_date']['Y']."-".$values['inactive_date']['M']."-".$values['inactive_date']['d'];
    } else {
	$incdate = "";
    }
    if ($values["_qf_EditDog_submit"] = "Submit") {
		error_log("Executing a save/update of data");
	  if ($this->_action == 2){
    	$values["id"] = $this->_id;
		$result = civicrm_api3('RegisteredDogs', 'create', [
		'id' 	=> $values['id'],
		'registered_name' => $values['registered_name'],
		'call_name' => $values['call_name'],
		'preferred_name' => $values['preferred_name'],
		'sex' => $values['gender'],
		'altered' => $values['altered'],
		'date_of_birth' => $newdate,
		'inactive_date' => $incdate,
		'breed_name' => $values['breed_name'],
		'other_titles' => $values['other_titles'],
		'other_title_description' => $values['other_title_description'],
		]); 
		var_error_log($result);
	 } elseif ($this->_action == 1) {
	 	$result = civicrm_api3('RegisteredDogs', 'create', [
	 	'contact_id' => $this->_cid,
		'registered_name' => $values['registered_name'],
		'call_name' => $values['call_name'],
		'preferred_name' => $values['preferred_name'],
		'sex' => $values['gender'],
		'altered' => $values['altered'],
		'date_of_birth' => $newdate,
		'inactive_date' => $incdate,
		'breed_name' => $values['breed_name'],
		'other_titles' => $values['other_titles'],
		'other_title_description' => $values['other_title_description'],
		]) ;
		var_error_log($result);

   }
}

     parent::postProcess();
  }

  public function getOptions($optionType) {
  	if ($optionType =="preferred") {
    	$options = array(
      '' => E::ts('- select -'),
      'Registered Name' => E::ts('Registered Name'),
      'Call Name' => E::ts('Call Name'),
    	);
 		return $options;
   
  }
  if ($optionType == "sex") {
  	$options = array(
      '' => E::ts('- select -'),
      'Male' => E::ts('Male'),
      'Female' => E::ts('Female'),
    	);
   return $options;
 }
  if ($optionType == "titles") {
  	$options = array(
      'none' => E::ts('- none -'),
      'CSSDF' => E::ts('CSSDF'),
      'CKC' => E::ts('CKC'),
      'C-WAGS' => E::ts('C-WAGS'),
      'NACSW' => E::ts('NACSW'),
      'Other' => E::ts('Other'),
    	);
   return $options;
 }
  if ($optionType == "breed") {
	$dogBreeds = civicrm_api4('DogBreed', 'get', [
		'select' => [
		  'Breed',
		]
	 ]);
	 $options = array(
		'' => E::ts('- select -'),
	  );

	 foreach ($dogBreeds as $result) {
		$options += array( $result["Breed"] => E::ts($result["Breed"]));
	}
	error_log("Finished options: ".print_r($options,true));

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

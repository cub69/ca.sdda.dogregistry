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
    		'other_titles' => $dogEntry['other_titles'],
    		'other_title_description' => $dogEntry['other_title_description'],
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
	$this->add(
		'select',
		'other_titles',
		'Other Titles',
		$this->getOptions("titles"),
		TRUE
	);
	$this->add(
		'text',
		'other_title_description', 
		'Other Title Description',
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
  	$options = array(
      '' => E::ts('- select -'),
      'Australian Cattle Dog' => E::ts('Australian Cattle Dog'),
'Afghan Hound' => E::ts('Afghan Hound'),
'Airedale Terrier' => E::ts('Airedale Terrier'),
'Akita' => E::ts('Akita'),
'Alaskan Husky' => E::ts('Alaskan Husky'),
'Alaskan Malamute' => E::ts('Alaskan Malamute'),
'All-American' => E::ts('All-American'),
'All-Canadian' => E::ts('All-Canadian'),
'American Bully' => E::ts('American Bully'),
'American Eskimo Dog (Miniature)' => E::ts('American Eskimo Dog (Miniature)'),
'American Eskimo Dog (Standard)' => E::ts('American Eskimo Dog (Standard)'),
'American Eskimo Dog (Toy)' => E::ts('American Eskimo Dog (Toy)'),
'American Pit Bull Terrier' => E::ts('American Pit Bull Terrier'),
'American Staffordshire Terrier' => E::ts('American Staffordshire Terrier'),
'Anatolian Shepherd Dog' => E::ts('Anatolian Shepherd Dog'),
'Australian Kelpie' => E::ts('Australian Kelpie'),
'Australian Shepherd' => E::ts('Australian Shepherd'),
'Australian Stumpy Tail Cattle Dog' => E::ts('Australian Stumpy Tail Cattle Dog'),
'Australian Terrier' => E::ts('Australian Terrier'),
'Barbet' => E::ts('Barbet'),
'Basenji' => E::ts('Basenji'),
'Basset_Art_sien_Normand' => E::ts('Basset Artesien Normand'),
'Basset Hound' => E::ts('Basset Hound'),
'Beagle' => E::ts('Beagle'),
'Bearded Collie' => E::ts('Bearded Collie'),
'Beauceron' => E::ts('Beauceron'),
'Bedlington Terrier' => E::ts('Bedlington Terrier'),
'Belgian Shepherd Dog (Groenendael)' => E::ts('Belgian Shepherd Dog (Groenendael)'),
'Belgian Shepherd Dog (Laekenois)' => E::ts('Belgian Shepherd Dog (Laekenois)'),
'Belgian Shepherd Dog (Malinois)' => E::ts('Belgian Shepherd Dog (Malinois)'),
'Belgian Shepherd Dog (Tervuren)' => E::ts('Belgian Shepherd Dog (Tervuren)'),
'Berger Allemand' => E::ts('Berger Allemand'),
'Berger Australien' => E::ts('Berger Australien'),
'Berger belge (Tervueren)' => E::ts('Berger belge (Tervueren)'),
'Berger Blanc Suisse' => E::ts('Berger Blanc Suisse'),
'Berger des Pyrenees' => E::ts('Berger des Pyrenees'),
'Berger Picard' => E::ts('Berger Picard'),
'Berger Polonais De Plaine' => E::ts('Berger Polonais De Plaine'),
'Berger Shetland' => E::ts('Berger Shetland'),
'Bernese Mountain Dog' => E::ts('Bernese Mountain Dog'),
'Bichon Frise' => E::ts('Bichon Frise'),
'Black Russian Terrier' => E::ts('Black Russian Terrier'),
'Bloodhound' => E::ts('Bloodhound'),
'Boerboel' => E::ts('Boerboel'),
'Bohemian Shepherd' => E::ts('Bohemian Shepherd'),
'Border Collie' => E::ts('Border Collie'),
'Border Terrier' => E::ts('Border Terrier'),
'Borzoi' => E::ts('Borzoi'),
'Boston Terrier' => E::ts('Boston Terrier'),
'Bouvier des Flandres' => E::ts('Bouvier des Flandres'),
'Boxer' => E::ts('Boxer'),
'Braque Fran?ais (Gascogne)' => E::ts('Braque Fran?ais (Gascogne)'),
'Braque Fran?ais (Pyrenees)' => E::ts('Braque Fran?ais (Pyrenees)'),
'Briard' => E::ts('Briard'),
'Bull Terrier' => E::ts('Bull Terrier'),
'Bull Terrier (Miniature)' => E::ts('Bull Terrier (Miniature)'),
'Bulldog (American)' => E::ts('Bulldog (American)'),
'Bulldog (English)' => E::ts('Bulldog (English)'),
'Bullmastiff' => E::ts('Bullmastiff'),
'Cairn Terrier' => E::ts('Cairn Terrier'),
'Canaan Dog' => E::ts('Canaan Dog'),
'Canadian Eskimo Dog' => E::ts('Canadian Eskimo Dog'),
'Cane Corso' => E::ts('Cane Corso'),
'Catahoula Leopard Dog' => E::ts('Catahoula Leopard Dog'),
'Cavalier King Charles Spaniel' => E::ts('Cavalier King Charles Spaniel'),
'Cesky Terrier' => E::ts('Cesky Terrier'),
'Chihuahua' => E::ts('Chihuahua'),
'Chihuahua (Long Coat)' => E::ts('Chihuahua (Long Coat)'),
'Chihuahua (Short Coat)' => E::ts('Chihuahua (Short Coat)'),
'Chinese Crested Dog' => E::ts('Chinese Crested Dog'),
'Chinese Shar-Pei' => E::ts('Chinese Shar-Pei'),
'Chow Chow' => E::ts('Chow Chow'),
'Collie (Rough)' => E::ts('Collie (Rough)'),
'Collie (Smooth)' => E::ts('Collie (Smooth)'),
'Collie-x' => E::ts('Collie-x'),
'Coolie' => E::ts('Coolie'),
'Coonhound (Black & Tan)' => E::ts('Coonhound (Black & Tan)'),
'Coonhound (Redbone)' => E::ts('Coonhound (Redbone)'),
'Coton de Tulear' => E::ts('Coton de Tulear'),
'Coydog' => E::ts('Coydog'),
'Dachshund (Miniature Long-Haired)' => E::ts('Dachshund (Miniature Long-Haired)'),
'Dachshund (Miniature Smooth)' => E::ts('Dachshund (Miniature Smooth)'),
'Dachshund (Miniature Wire-Haired)' => E::ts('Dachshund (Miniature Wire-Haired)'),
'Dachshund (Standard Long-Haired)' => E::ts('Dachshund (Standard Long-Haired)'),
'Dachshund (Standard Smooth)' => E::ts('Dachshund (Standard Smooth)'),
'Dachshund (Standard Wire-Haired)' => E::ts('Dachshund (Standard Wire-Haired)'),
'Dalmatian' => E::ts('Dalmatian'),
'Dandie Dinmont Terrier' => E::ts('Dandie Dinmont Terrier'),
'Deerhound (Scottish)' => E::ts('Deerhound (Scottish)'),
'Desi Dog' => E::ts('Desi Dog'),
'Deutscher Jagdterrier' => E::ts('Deutscher Jagdterrier'),
'Doberman Pinscher' => E::ts('Doberman Pinscher'),
'Donovan Pinscher' => E::ts('Donovan Pinscher'),
'Drever' => E::ts('Drever'),
'Dutch Sheepdog' => E::ts('Dutch Sheepdog'),
'Dutch Shepherd' => E::ts('Dutch Shepherd'),
'English Shepherd' => E::ts('English Shepherd'),
'English Toy Spaniel' => E::ts('English Toy Spaniel'),
'Entlebucher Mountain Dog' => E::ts('Entlebucher Mountain Dog'),
'Eurasier' => E::ts('Eurasier'),
'Finnish Lapphund' => E::ts('Finnish Lapphund'),
'Finnish Spitz' => E::ts('Finnish Spitz'),
'Fox Terrier (Smooth)' => E::ts('Fox Terrier (Smooth)'),
'Fox Terrier (Wire)' => E::ts('Fox Terrier (Wire)'),
'Foxhound (American)' => E::ts('Foxhound (American)'),
'Foxhound (English)' => E::ts('Foxhound (English)'),
'French Bulldog' => E::ts('French Bulldog'),
'German Coolie' => E::ts('German Coolie'),
'German Pinscher' => E::ts('German Pinscher'),
'German Shepherd Dog' => E::ts('German Shepherd Dog'),
'Glen of Imaal' => E::ts('Glen of Imaal'),
'Great Dane' => E::ts('Great Dane'),
'Great Pyrenees' => E::ts('Great Pyrenees'),
'Greater Swiss Mountain Dog' => E::ts('Greater Swiss Mountain Dog'),
'Greenland Dog' => E::ts('Greenland Dog'),
'Greyhound' => E::ts('Greyhound'),
'Griffon (Brussels)' => E::ts('Griffon (Brussels)'),
'Griffon (Wire-Haired Pointing)' => E::ts('Griffon (Wire-Haired Pointing)'),
'Harrier' => E::ts('Harrier'),
'Havanese' => E::ts('Havanese'),
'Hovawart' => E::ts('Hovawart'),
'Husky-x' => E::ts('Husky-x'),
'Ibizan Hound' => E::ts('Ibizan Hound'),
'Iceland Sheepdog' => E::ts('Iceland Sheepdog'),
'Irish Terrier' => E::ts('Irish Terrier'),
'Irish Wolfhound' => E::ts('Irish Wolfhound'),
'Italian Greyhound' => E::ts('Italian Greyhound'),
'Jack Russell Terrier' => E::ts('Jack Russell Terrier'),
'Jack Russell Terrier x' => E::ts('Jack Russell Terrier x'),
'Japanese Spaniel' => E::ts('Japanese Spaniel'),
'Japanese Spitz' => E::ts('Japanese Spitz'),
'Kai Ken' => E::ts('Kai Ken'),
'Karelian Bear Dog' => E::ts('Karelian Bear Dog'),
'Keeshond' => E::ts('Keeshond'),
'Kerry Blue Terrier' => E::ts('Kerry Blue Terrier'),
'Komondor' => E::ts('Komondor'),
'Kooikerhondje' => E::ts('Kooikerhondje'),
'Kuvasz' => E::ts('Kuvasz'),
'Lagotto Romagnolo' => E::ts('Lagotto Romagnolo'),
'Lakeland Terrier' => E::ts('Lakeland Terrier'),
'Lancashire Heeler' => E::ts('Lancashire Heeler'),
'Leonberger' => E::ts('Leonberger'),
'Lhasa Apso' => E::ts('Lhasa Apso'),
'Lowchen' => E::ts('Lowchen'),
'Maltese' => E::ts('Maltese'),
'Manchester Terrier' => E::ts('Manchester Terrier'),
'Mastiff' => E::ts('Mastiff'),
'McNab' => E::ts('McNab'),
'Miniature American Shepherd' => E::ts('Miniature American Shepherd'),
'Miniature Australian Shepherd' => E::ts('Miniature Australian Shepherd'),
'Miniature Pinscher' => E::ts('Miniature Pinscher'),
'Miniature Teckel' => E::ts('Miniature Teckel'),
'Mudi' => E::ts('Mudi'),
'Neapolitan Mastiff' => E::ts('Neapolitan Mastiff'),
'Newfoundland' => E::ts('Newfoundland'),
'Norfolk Terrier' => E::ts('Norfolk Terrier'),
'Norrbottenspets' => E::ts('Norrbottenspets'),
'Norwegian Buhund' => E::ts('Norwegian Buhund'),
'Norwegian Elkhound' => E::ts('Norwegian Elkhound'),
'Norwegian Lundehund' => E::ts('Norwegian Lundehund'),
'Norwich Terrier' => E::ts('Norwich Terrier'),
'Old English Sheepdog' => E::ts('Old English Sheepdog'),
'Otterhound' => E::ts('Otterhound'),
'Papillon' => E::ts('Papillon'),
'Parson Russell Terrier' => E::ts('Parson Russell Terrier'),
'Patterdale Terrier' => E::ts('Patterdale Terrier'),
'Pekingese' => E::ts('Pekingese'),
'Petit Basset Griffon Vendeen' => E::ts('Petit Basset Griffon Vendeen'),
'Pharaoh Hound' => E::ts('Pharaoh Hound'),
'Pharaoh_Hound_Miniature_' => E::ts('Pharaoh Hound (Miniature)'),
'Pointer' => E::ts('Pointer'),
'Pointer (English)' => E::ts('Pointer (English)'),
'Pointer (German Long-Haired)' => E::ts('Pointer (German Long-Haired)'),
'Pointer (German Short-Haired)' => E::ts('Pointer (German Short-Haired)'),
'Pointer (German Wire-Haired)' => E::ts('Pointer (German Wire-Haired)'),
'Polish Lowland Sheepdog' => E::ts('Polish Lowland Sheepdog'),
'Pomeranian' => E::ts('Pomeranian'),
'Poodle (Miniature)' => E::ts('Poodle (Miniature)'),
'Poodle (Moyen)' => E::ts('Poodle (Moyen)'),
'Poodle (Standard)' => E::ts('Poodle (Standard)'),
'Poodle (Toy)' => E::ts('Poodle (Toy)'),
'Poodle-x' => E::ts('Poodle-x'),
'Portuguese Sheepdog' => E::ts('Portuguese Sheepdog'),
'Portuguese Water Dog' => E::ts('Portuguese Water Dog'),
'Potcake' => E::ts('Potcake'),
'Presa Canario' => E::ts('Presa Canario'),
'Pudelpointer' => E::ts('Pudelpointer'),
'Pug' => E::ts('Pug'),
'Puli' => E::ts('Puli'),
'Pumi' => E::ts('Pumi'),
'Rat Terrier' => E::ts('Rat Terrier'),
'Redbone Coonhound' => E::ts('Redbone Coonhound'),
'Retriever (Chesapeake Bay)' => E::ts('Retriever (Chesapeake Bay)'),
'Retriever (Curly-Coated)' => E::ts('Retriever (Curly-Coated)'),
'Retriever (Flat-Coated)' => E::ts('Retriever (Flat-Coated)'),
'Retriever (Golden)' => E::ts('Retriever (Golden)'),
'Retriever (Labrador)' => E::ts('Retriever (Labrador)'),
'Retriever (Nova Scotia Duck Tolling)' => E::ts('Retriever (Nova Scotia Duck Tolling)'),
'Rhodesian Ridgeback' => E::ts('Rhodesian Ridgeback'),
'Rottweiler' => E::ts('Rottweiler'),
'Saluki' => E::ts('Saluki'),
'Samoyed' => E::ts('Samoyed'),
'Schapendoes' => E::ts('Schapendoes'),
'Schipperke' => E::ts('Schipperke'),
'Schnauzer (Miniature)' => E::ts('Schnauzer (Miniature)'),
'Schnauzer(Giant)' => E::ts('Schnauzer(Giant)'),
'Schnauzer(Standard)' => E::ts('Schnauzer(Standard)'),
'Scottish Terrier' => E::ts('Scottish Terrier'),
'Sealyham Terrier' => E::ts('Sealyham Terrier'),
'Setter (English)' => E::ts('Setter (English)'),
'Setter (Gordon)' => E::ts('Setter (Gordon)'),
'Setter (Irish Red & White)' => E::ts('Setter (Irish Red & White)'),
'Setter (Irish)' => E::ts('Setter (Irish)'),
'Shepherd-x' => E::ts('Shepherd-x'),
'Shetland Sheepdog' => E::ts('Shetland Sheepdog'),
'Shi-Tszu-x' => E::ts('Shi-Tszu-x'),
'Shiba Inu' => E::ts('Shiba Inu'),
'Shih Tzu' => E::ts('Shih Tzu'),
'Shiloh Shepherd' => E::ts('Shiloh Shepherd'),
'Siberian Husky' => E::ts('Siberian Husky'),
'Silken Windhound' => E::ts('Silken Windhound'),
'Silky Terrier' => E::ts('Silky Terrier'),
'Skye Terrier' => E::ts('Skye Terrier'),
'Small Munsterlander' => E::ts('Small Munsterlander'),
'Soft-Coated Wheaten Terrier' => E::ts('Soft-Coated Wheaten Terrier'),
'Spaniel (American Cocker)' => E::ts('Spaniel (American Cocker)'),
'Spaniel (American Water)' => E::ts('Spaniel (American Water)'),
'Spaniel (Blue Picardy)' => E::ts('Spaniel (Blue Picardy)'),
'Spaniel (Brittany)' => E::ts('Spaniel (Brittany)'),
'Spaniel (Clumber)' => E::ts('Spaniel (Clumber)'),
'Spaniel (English Cocker)' => E::ts('Spaniel (English Cocker)'),
'Spaniel (English Springer)' => E::ts('Spaniel (English Springer)'),
'Spaniel (Field)' => E::ts('Spaniel (Field)'),
'Spaniel (French)' => E::ts('Spaniel (French)'),
'Spaniel (Irish Water)' => E::ts('Spaniel (Irish Water)'),
'Spaniel (Sussex)' => E::ts('Spaniel (Sussex)'),
'Spaniel (Welsh Springer)' => E::ts('Spaniel (Welsh Springer)'),
'Spanish Water Dog' => E::ts('Spanish Water Dog'),
'Spinone Italiano' => E::ts('Spinone Italiano'),
'Springer Anglais' => E::ts('Springer Anglais'),
'St. Bernard' => E::ts('St. Bernard'),
'Stabyhouns' => E::ts('Stabyhouns'),
'Staffordshire Bull Terrier' => E::ts('Staffordshire Bull Terrier'),
'Swedish Vallhund' => E::ts('Swedish Vallhund'),
'Tatra Sheepdog' => E::ts('Tatra Sheepdog'),
'Terrier blanc du West Highland' => E::ts('Terrier blanc du West Highland'),
'Terrier Nu Americain' => E::ts('Terrier Nu Americain'),
'Terrier-x' => E::ts('Terrier-x'),
'Thai_Ridgeback' => E::ts('Thai Ridgeback'),
'Tibetan Mastiff' => E::ts('Tibetan Mastiff'),
'Tibetan Spaniel' => E::ts('Tibetan Spaniel'),
'Tibetan Terrier' => E::ts('Tibetan Terrier'),
'Toy Fox Terrier' => E::ts('Toy Fox Terrier'),
'Toy Manchester Terrier' => E::ts('Toy Manchester Terrier'),
'Vizsla (Smooth)' => E::ts('Vizsla (Smooth)'),
'Vizsla (Wire-Haired)' => E::ts('Vizsla (Wire-Haired)'),
'Weimaraner' => E::ts('Weimaraner'),
'Welsh Corgi (Cardigan)' => E::ts('Welsh Corgi (Cardigan)'),
'Welsh Corgi (Pembroke)' => E::ts('Welsh Corgi (Pembroke)'),
'Welsh Terrier' => E::ts('Welsh Terrier'),
'West Highland White Terrier' => E::ts('West Highland White Terrier'),
'Whippet' => E::ts('Whippet'),
'Xoloitzcuintli (Miniature & Standard)' => E::ts('Xoloitzcuintli (Miniature & Standard)'),
'Xoloitzcuintli(Toy)' => E::ts('Xoloitzcuintli(Toy)'),
'Yorkshire Terrier' => E::ts('Yorkshire Terrier'),
    	);
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

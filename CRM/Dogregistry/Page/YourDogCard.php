<?php
use CRM_Dogregistry_ExtensionUtil as E;

class CRM_Dogregistry_Page_YourDogCard extends CRM_Core_Page {

  public function run() {
   $this->dogid = CRM_Utils_Request::retrieve('dogid', 'Positive', $this, TRUE);
   error_log("Dog number pre: ".$this->dogid);
   $result = sdda_display_dog_card($this->dogid);
   //CRM_Core_Session::setStatus(E::ts("An email with your dog's card has been sent!"));
   parent::run();
  }

}

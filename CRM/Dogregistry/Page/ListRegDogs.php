<?php
use CRM_Dogregistry_ExtensionUtil as E;

class CRM_Dogregistry_Page_ListRegDogs extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('List Registered Dogs'));

    $this->_contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
	  $this->_url = CRM_Utils_System::url( 'civicrm/editdog', "");
    $this->_url2 = CRM_Utils_System::url( 'civicrm/transferdog', "");
    $this->assign('uid',$this->_contactId);
    $this->assign('url',$this->_url);
    parent::run();
  }

}

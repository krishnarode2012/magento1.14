<?php
class Perficient_Contact_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Contact Form"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("contact form", array(
                "label" => $this->__("Contact Form"),
                "title" => $this->__("Contact Form")
		   ));

      $this->renderLayout(); 
	  
    }
	
	public function PostAction(){
		$post_data=$this->getRequest()->getPost();
				if ($post_data) {
					try {
						$model = Mage::getModel("contact/contact")
						->addData($post_data)
						//->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("core/session")->addSuccess(Mage::helper("contact")->__("Contact was successfully saved"));
						Mage::getSingleton("core/session")->setContactData(false);

						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("core/session")->addError($e->getMessage());
						Mage::getSingleton("core/session")->setContactData($this->getRequest()->getPost());
						$this->_redirect("*/*/");
						//$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
	}
}
<?php
class Perficient_Faq_IndexController extends Mage_Core_Controller_Front_Action{
	public function IndexAction() {
//	Mage::helper('faq');
		echo "You are in ".__FUNCTION__. ' Function which is in '.__FILE__.'  FILE .';
		//exit;

		$this->loadLayout();
		$this->getLayout()->getBlock("head")->setTitle($this->__("FAQ Form"));
		$breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
		$breadcrumbs->addCrumb("home", array(
			"label" => $this->__("Home Page"),
			"title" => $this->__("Home Page"),
			"link"  => Mage::getBaseUrl()
		));

		$breadcrumbs->addCrumb("faq form", array(
			"label" => $this->__("FAQ Form"),
			"title" => $this->__("FAQ Form")
		));

		$this->renderLayout();
		return $this;
	}

	public function PostAction(){
		$post_data = $this->getRequest()->getPost();
		if ($post_data){
			try {

				$post_data['status'] = 0;
				$post_data['create_time'] = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
				$post_data['update_time'] = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');

				Mage::getModel("faq/faq")
					->addData($post_data)
					->save();

				Mage::getSingleton("core/session")->addSuccess(Mage::helper("faq")->__("We have received your request, we will get back to you ASAP."));
				Mage::getSingleton("core/session")->setContactData(false);

				$this->_redirect("*/*/");
				return;
			}
			catch (Exception $e) {
				Mage::getSingleton("core/session")->addError($e->getMessage());
				Mage::getSingleton("core/session")->setContactData($this->getRequest()->getPost());
				$this->_redirect("*/*/");
				return;
			}

		}else{
			Mage::getSingleton("core/session")->addError('Something went wrong while serving your request.');
		}
		$this->_redirect("*/*/");
		return;
	}
	public function XyzAction(){
		echo "You are in ".__FUNCTION__. ' Function which is in '.__FILE__.'  FILE .';
		exit;
	}

}
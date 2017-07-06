<?php

class Perficient_Faq_Adminhtml_FaqController extends Mage_Adminhtml_Controller_Action
{
	protected function _isAllowed()
	{
		//return Mage::getSingleton('admin/session')->isAllowed('faq/faq');
		return true;
	}

	protected function _initAction()
	{
		$this->loadLayout()->_setActiveMenu("faq/faq")->_addBreadcrumb(Mage::helper("adminhtml")->__("Faq Manager"),Mage::helper("adminhtml")->__("Faq Manager"));
		return $this;
	}
	public function indexAction()
	{
		$this->_title($this->__("Faq"));
		$this->_title($this->__("Manager Faq"));

		$this->_initAction();
		$this->renderLayout();
	}

}

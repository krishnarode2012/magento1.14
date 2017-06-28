<?php

class Perficient_Contact_Adminhtml_ContactController extends Mage_Adminhtml_Controller_Action
{
		protected function _isAllowed()
		{
		//return Mage::getSingleton('admin/session')->isAllowed('contact/contact');
			return true;
		}

		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("contact/contact")->_addBreadcrumb(Mage::helper("adminhtml")->__("Contact  Manager"),Mage::helper("adminhtml")->__("Contact Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Contact"));
			    $this->_title($this->__("Manager Contact"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Contact"));
				$this->_title($this->__("Contact"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("contact/contact")->load($id);
				if ($model->getId()) {
					Mage::register("contact_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("contact/contact");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Contact Manager"), Mage::helper("adminhtml")->__("Contact Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Contact Description"), Mage::helper("adminhtml")->__("Contact Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("contact/adminhtml_contact_edit"))->_addLeft($this->getLayout()->createBlock("contact/adminhtml_contact_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("contact")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Contact"));
		$this->_title($this->__("Contact"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("contact/contact")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("contact_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("contact/contact");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Contact Manager"), Mage::helper("adminhtml")->__("Contact Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Contact Description"), Mage::helper("adminhtml")->__("Contact Description"));


		$this->_addContent($this->getLayout()->createBlock("contact/adminhtml_contact_edit"))->_addLeft($this->getLayout()->createBlock("contact/adminhtml_contact_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {
						if(!$this->getRequest()->getParam("id")){
							$post_data['create_time'] = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
						}
						$post_data['update_time'] = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
						Mage::getModel('core/date')->gmtDate();
						$model = Mage::getModel("contact/contact")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Contact was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setContactData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setContactData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("contact/contact");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("contact/contact");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'contact.csv';
			$grid       = $this->getLayout()->createBlock('contact/adminhtml_contact_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'contact.xml';
			$grid       = $this->getLayout()->createBlock('contact/adminhtml_contact_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}

<?php
	
class Perficient_Contact_Block_Adminhtml_Contact_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "contact";
				$this->_controller = "adminhtml_contact";
				$this->_updateButton("save", "label", Mage::helper("contact")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("contact")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("contact")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("contact_data") && Mage::registry("contact_data")->getId() ){

				    return Mage::helper("contact")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("contact_data")->getId()));

				} 
				else{

				     return Mage::helper("contact")->__("Add Item");

				}
		}
}
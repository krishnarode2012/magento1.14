<?php


class Perficient_Contact_Block_Adminhtml_Contact extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_contact";
	$this->_blockGroup = "contact";
	$this->_headerText = Mage::helper("contact")->__("Contact Manager");
	$this->_addButtonLabel = Mage::helper("contact")->__("Add New Item");
	parent::__construct();
	
	}

}
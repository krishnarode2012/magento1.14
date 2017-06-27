<?php
class Perficient_Contact_Block_Adminhtml_Contact_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("contact_form", array("legend"=>Mage::helper("contact")->__("Item information")));

				
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("contact")->__("Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("contact")->__("Email"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "email",
						));
					
						$fieldset->addField("telephone", "text", array(
						"label" => Mage::helper("contact")->__("Telephone"),
						"name" => "telephone",
						));
					
						$fieldset->addField("comment", "textarea", array(
						"label" => Mage::helper("contact")->__("Comment"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "comment",
						));
									
						 $fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('contact')->__('Status'),
						'values'   => Perficient_Contact_Block_Adminhtml_Contact_Grid::getStatusOptionValue(),
						'name' => 'status',
						));
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('create_time', 'date', array(
						'label'        => Mage::helper('contact')->__('Create date/time'),
						'name'         => 'create_time',
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$fieldset->addField("update_time", "text", array(
						"label" => Mage::helper("contact")->__("Update date/time"),
						"name" => "update_time",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getContactData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getContactData());
					Mage::getSingleton("adminhtml/session")->setContactData(null);
				} 
				elseif(Mage::registry("contact_data")) {
				    $form->setValues(Mage::registry("contact_data")->getData());
				}
				return parent::_prepareForm();
		}
}

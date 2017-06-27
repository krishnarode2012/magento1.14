<?php
    class Perficient_Contact_Model_Resource_Contact_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
    {

		public function _construct(){
			$this->_init("contact/contact");
		}

    }
	 
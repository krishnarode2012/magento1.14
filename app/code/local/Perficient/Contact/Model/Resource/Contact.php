<?php
class Perficient_Contact_Model_Resource_Contact extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("contact/contact", "id");
    }
}
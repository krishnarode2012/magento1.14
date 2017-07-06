<?php
class Perficient_Faq_Model_Resource_Faq extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("faq/faq", "id");
    }
}
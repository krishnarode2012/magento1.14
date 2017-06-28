<?php
class Perficient_Contact_Block_Index extends Mage_Core_Block_Template{


    public function getFormActionUrl()
    {
       return  $this->getUrl('contact/index/post');
      // exit;
    }


}
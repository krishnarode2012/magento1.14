<?php
class Perficient_Faq_Block_Index extends Mage_Core_Block_Template{

     public function getFormActionUrl()
     {
        return  $this->getUrl('faq/index/post');

     }
}
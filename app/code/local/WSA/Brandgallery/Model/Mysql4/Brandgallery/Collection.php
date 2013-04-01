<?php

class WSA_Brandgallery_Model_Mysql4_Brandgallery_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('brandgallery/brandgallery');
    }
}
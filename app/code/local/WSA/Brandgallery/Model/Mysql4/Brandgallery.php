<?php

class WSA_Brandgallery_Model_Mysql4_Brandgallery extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the brandgallery_id refers to the key field in your database table.
        $this->_init('brandgallery/brandgallery', 'brandgallery_id');
    }
}
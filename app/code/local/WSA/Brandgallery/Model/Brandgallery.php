<?php

class WSA_Brandgallery_Model_Brandgallery extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('brandgallery/brandgallery');
    }
    
    public function loadGalleryByBrandId($brandId)
    {
        return $this->getCollection()
                ->addFieldToFilter('status', 1)
                ->addFieldToFilter('brand', $brandId);
    }
}
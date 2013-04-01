<?php

class WSA_Brandgallery_Block_Brandgallery extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

//    public function getBrandgallery() {
//        if (!$this->hasData('brandgallery')) {
//            $this->setData('brandgallery', Mage::registry('brandgallery'));
//        }
//        return $this->getData('brandgallery');
//    }
    
    public function getBrandgallery() {
        echo $this->getRequest()->getParam('id');
        $brandgallery = Mage::getModel('brandgallery/brandgallery')->getCollection()
                ->addFieldToFilter('status', 1)
                ->load();
        return $brandgallery;
    }
    
    public function getBrandgalleryByBrand() {
        if (!$this->hasData('brandGallery')) {
            $brandId = $this->getRequest()->getParam('id');
            $brandGallery = Mage::getModel('brandgallery/brandgallery')->loadGalleryByBrandId($brandId);
            $this->setData('brandGallery', $brandGallery);
        }
        return $this->getData('brandGallery');
    }
}
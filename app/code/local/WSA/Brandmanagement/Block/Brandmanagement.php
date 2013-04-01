<?php

/**
 * @category    WSA
 * @package     WSA_Brandmanagement
 * @author      bGlobal Core Team (abuzafar.wahid@gmail.com)
 */

/**
 * Block type for retrieving brand information
 */
class WSA_Brandmanagement_Block_Brandmanagement extends Mage_Core_Block_Template {


    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getBrandmanagement($brand) {
        $brands = explode('_', $brand);
        $brandmanagement = Mage::getModel('brandmanagement/brandmanagement')->getCollection()
                ->addStoreFilter(Mage::app()->getStore(true)->getId())
                ->addFieldToFilter('status', 1)
                ->addFieldToFilter('brand', array("in" => $brands))
                ->load();
        return $brandmanagement;
    }

    /**
    * Return All Brand List, if has country code then return specific country's brands.
    **/
    public function getBrandlist() {
        $brandList = Mage::getModel('brandmanagement/brandmanagement')->getCollection()
                ->addStoreFilter(Mage::app()->getStore(true)->getId())
                ->addFieldToFilter('status', 1)
                ->setOrder('title','ASC')
                ->load();
        return $brandList;
    }

    /**
    * Return Brand List by Country
    **/
    public function getBrandlistbycountry($countryCode) {
        $brandListbyCountry = Mage::getModel('brandmanagement/brandmanagement')->getCollection()
                ->addStoreFilter(Mage::app()->getStore(true)->getId())
                ->addFieldToFilter('status', 1)
                ->addFieldToFilter('brand_country', $countryCode)
                ->setOrder('title','ASC')
                ->load();
        return $brandListbyCountry;
    }
    
       /**
     * Retrieve brand instance
     *
     * @return WSA_Brandmanagement_Block_Brand
     */
    public function getBrand() {
        if (!$this->hasData('brand')) {
            $brandId = $this->getRequest()->getParam('id');
            $brand = Mage::getModel('brandmanagement/brandmanagement')->loadByBrandId($brandId, Mage::app()->getStore(true)->getId());
            $this->setData('brand', $brand);
        }
        return $this->getData('brand');
    }
}
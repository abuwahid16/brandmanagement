<?php

/**
 * @category    WSA
 * @package     WSA_Brandmanagement
 * @author      bGlobal Core Team (abuzafar.wahid@gmail.com)
 */

/**
 * Model type for retrieving brand information
 */
class WSA_Brandmanagement_Model_Brandmanagement extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('brandmanagement/brandmanagement');
    }

    /**
     * Check if the brand exist or not.
     */
    public function isBrandExist($brand) {
        foreach ($this->getConfiguredBrand() as $brandValue) {
            if ($brandValue[brand] == $brand) {
                return true;
                exit;
            }
        }
        return false;
    }

    /**
     * Return All Brand labels and values
     * @return array 
     */
    public function getBrandOptions() {
        $attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', 'brand');
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute->getSource()->getAllOptions();
        return $attributeOptions;
    }

    /**
     * Return All Wine Country label and values
     * @return array 
     */
    public function getWineCountry() {
        $attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', 'wine_country');
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute->getSource()->getAllOptions();
        if (is_array($attributeOptions) && isset($attributeOptions[0]['value']) && $attributeOptions[0]['value'] == '')
            unset($attributeOptions[0]);
        return $attributeOptions;
    }

    /**
     * Return All Wine Country label and values
     * @return array 
     */
    public function getWineRegion() {
        $attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', 'wine_region');
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute->getSource()->getAllOptions();
        if ($attributeOptions[0]['value'] == '')
            unset($attributeOptions[0]);
        return $attributeOptions;
    }

    /**
     * Retrun attribute set information for brand which are enabled.
     * @return type
     */
    public function getConfiguredBrand() {
        $brandmanagement = $this->getCollection()
                ->addStoreFilter(Mage::app()->getStore(true)->getId())
                ->addFieldToFilter('status', 1)
                ->addFieldToSelect('brand')
                ->load()
                ->getData();
        return $brandmanagement;
    }

    /**
     * Check identifier by url key for SEO friendly URL
     * @param type $identifier
     * @param type $storeId
     * @return type
     */
    public function checkIdentifier($identifier, $storeId) {
        return $this->getCollection()
                        ->addStoreFilter($storeId)
                        ->addFieldToFilter('status', 1)
                        ->addFieldToFilter('url_key', $identifier)
                        ->addFieldToSelect('brand')
                        ->setPageSize(1)
                        ->getFirstItem();
    }

    /**
     * Return brand info by brand id
     * @param type $brandId
     * @param type $storeId
     * @return type
     */
    public function loadByBrandId($brandId, $storeId) {
        return $this->getCollection()
                        ->addStoreFilter($storeId)
                        ->addFieldToFilter('status', 1)
                        ->addFieldToFilter('brand', $brandId)
                        ->setPageSize(1)
                        ->getFirstItem();
    }

    /**
     * Return brand info by query text
     * @param type $text
     * @return type
     */
    public function loadByQuery($text) {
        return $this->getCollection()->loadByQuery($text);
    }

}
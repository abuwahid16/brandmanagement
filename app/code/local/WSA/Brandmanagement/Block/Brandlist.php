<?php

/**
 * @category    WSA
 * @package     WSA_Brandmanagement
 * @author      bGlobal Core Team (abuzafar.wahid@gmail.com)
 */
class WSA_Brandmanagement_Block_Brandlist extends Mage_Catalog_Block_Product_List {

    /**
     * Prepare global layout
     *
     * @return WSA_Brandmanagement_Block_Brand
     */
    protected function _prepareLayout() {
        $brand = $this->getBrand();
        $this->getLayout()->getBlock('head')
                ->setTitle($brand->getMetaTitle() ? $brand->getMetaTitle() : $brand->getTitle())
                ->setKeywords($brand->getMetaKeywords() ? $brand->getMetaKeywords() : $brand->getTitle())
                ->setDescription($brand->getMetaDescription() ? $brand->getMetaDescription() : $brand->getTitle());
        $this->getLayout()->getBlock('breadcrumbs')
                ->addCrumb('home', array('label' => Mage::helper('brandmanagement')->__('Home'), 'title' => Mage::helper('brandmanagement')->__('Go to Home Page'), 'link' => Mage::getBaseUrl()))
                ->addCrumb('wine-info', array('label' => Mage::helper('brandmanagement')->__('Wine Info'), 'title' => Mage::helper('brandmanagement')->__('Wine Info'), 'link' => '/wine-info/'))
                ->addCrumb('brand-info', array('label' => Mage::helper('brandmanagement')->__('Brand Info'), 'title' => Mage::helper('brandmanagement')->__('Brand Info'), 'link' => '/wine-info/brand-info/'))
                ->addCrumb('brand', array('label' => $brand->getTitle(), 'title' => $brand->getTitle()));
        return parent::_prepareLayout();
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

    protected function _getProductCollection() {
        if (!$this->hasData('product_collection_by_brand')) {
            $storeId = Mage::app()->getStore()->getId();
            $productCollectionByBrand = Mage::getModel('catalog/product')->getCollection()
                    ->addAttributeToSelect('*')
                    ->setStoreId($storeId)
                    ->setOrder('price', 'desc')
                    ->addFieldToFilter(array(array('attribute' => 'brand', 'eq' => $this->getRequest()->getParam('id'))));
            $this->setData('product_collection_by_brand', $productCollectionByBrand);
        }
        return $this->getData('product_collection_by_brand');
    }

}
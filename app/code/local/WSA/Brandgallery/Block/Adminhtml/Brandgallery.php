<?php

class WSA_Brandgallery_Block_Adminhtml_Brandgallery extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_brandgallery';
        $this->_blockGroup = 'brandgallery';
        $this->_headerText = Mage::helper('brandgallery')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('brandgallery')->__('Add Item');
        parent::__construct();
    }

}
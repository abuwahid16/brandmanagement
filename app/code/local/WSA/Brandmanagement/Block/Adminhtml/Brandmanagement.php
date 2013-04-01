<?php

class WSA_Brandmanagement_Block_Adminhtml_Brandmanagement extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_brandmanagement';
        $this->_blockGroup = 'brandmanagement';
        $this->_headerText = Mage::helper('brandmanagement')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('brandmanagement')->__('Add Item');
        parent::__construct();
    }

}
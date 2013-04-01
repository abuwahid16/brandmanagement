<?php

class WSA_Brandmanagement_Block_Adminhtml_Brandmanagement_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('brandmanagement_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('brandmanagement')->__('Item Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('brandmanagement')->__('Item Information'),
            'title' => Mage::helper('brandmanagement')->__('Item Information'),
            'content' => $this->getLayout()->createBlock('brandmanagement/adminhtml_brandmanagement_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}
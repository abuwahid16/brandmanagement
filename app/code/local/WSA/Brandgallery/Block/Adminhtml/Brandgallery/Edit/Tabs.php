<?php

class WSA_Brandgallery_Block_Adminhtml_Brandgallery_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('brandgallery_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('brandgallery')->__('Item Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('brandgallery')->__('Item Information'),
            'title' => Mage::helper('brandgallery')->__('Item Information'),
            'content' => $this->getLayout()->createBlock('brandgallery/adminhtml_brandgallery_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}
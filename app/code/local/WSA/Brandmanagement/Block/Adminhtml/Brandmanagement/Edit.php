<?php

class WSA_Brandmanagement_Block_Adminhtml_Brandmanagement_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    protected function _prepareLayout() {

        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        parent::_prepareLayout();
    }

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'brandmanagement';
        $this->_controller = 'adminhtml_brandmanagement';

        $this->_updateButton('save', 'label', Mage::helper('brandmanagement')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('brandmanagement')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('brandmanagement_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'brandmanagement_text');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'brandmanagement_text');
                }
            }
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            $('brand').observe('change', function(e) {
                var sel = document.getElementById('brand');
                var selectedText = sel.options[sel.selectedIndex].text;
                $('title').value = selectedText;
                $('url_key').value = selectedText.replace(/[^a-z0-9]+/gi, '-').replace(/^-*|-*$/g, '').toLowerCase();
            }); 
        ";
    }

    public function getHeaderText() {
        if (Mage::registry('brandmanagement_data') && Mage::registry('brandmanagement_data')->getId()) {
            return Mage::helper('brandmanagement')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('brandmanagement_data')->getTitle()));
        } else {
            return Mage::helper('brandmanagement')->__('Add Item');
        }
    }

}
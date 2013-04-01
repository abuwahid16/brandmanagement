<?php

class WSA_Brandgallery_Block_Adminhtml_Brandgallery_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'brandgallery';
        $this->_controller = 'adminhtml_brandgallery';

        $this->_updateButton('save', 'label', Mage::helper('brandgallery')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('brandgallery')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('brandgallery_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'brandgallery_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'brandgallery_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            $('brand').observe('change', function(e) {
                var sel = document.getElementById('brand');
                var selectedText = sel.options[sel.selectedIndex].text;
                $('title').value = selectedText;
            }); 
        ";
    }

    public function getHeaderText() {
        if (Mage::registry('brandgallery_data') && Mage::registry('brandgallery_data')->getId()) {
            return Mage::helper('brandgallery')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('brandgallery_data')->getTitle()));
        } else {
            return Mage::helper('brandgallery')->__('Add Item');
        }
    }

}
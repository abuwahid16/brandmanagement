<?php

class WSA_Brandgallery_Block_Adminhtml_Brandgallery_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('brandgallery_form', array('legend' => Mage::helper('brandgallery')->__('Item information')));

        $fieldset->addField('title', 'hidden', array(
            'required' => false,
            'name' => 'title',
        ));

        $fieldset->addField('brand', 'select', array(
            'name' => 'brand',
            'label' => Mage::helper('brandgallery')->__('Select Brand'),
            'title' => Mage::helper('brandgallery')->__('Select Brand'),
            'required' => true,
            'values' => Mage::getModel('brandmanagement/brandmanagement')->getBrandOptions()
        ));

        $fieldset->addField('image_alt', 'text', array(
            'required' => false,
            'name' => 'image_alt',
            'label' => Mage::helper('brandgallery')->__('Image Title'),
            'title' => Mage::helper('brandgallery')->__('Image Title')
        ));

        $fieldset->addField('brandimage', 'file', array(
            'label' => Mage::helper('brandgallery')->__('Brand Image'),
            'required' => false,
            'name' => 'brandimage',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('brandgallery')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('brandgallery')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('brandgallery')->__('Disabled'),
                ),
            ),
        ));


        if (Mage::getSingleton('adminhtml/session')->getBrandgalleryData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBrandgalleryData());
            Mage::getSingleton('adminhtml/session')->setBrandgalleryData(null);
        } elseif (Mage::registry('brandgallery_data')) {
            $form->setValues(Mage::registry('brandgallery_data')->getData());
        }
        return parent::_prepareForm();
    }

}
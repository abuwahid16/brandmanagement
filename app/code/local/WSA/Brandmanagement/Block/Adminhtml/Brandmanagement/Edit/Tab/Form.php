<?php

/**
 * @category    WSA
 * @package     WSA_Brandmanagement
 * @author      bGlobal Core Team (abuzafar.wahid@gmail.com)
 */
class WSA_Brandmanagement_Block_Adminhtml_Brandmanagement_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('brandmanagement_form', array('legend' => Mage::helper('brandmanagement')->__('Item information')));
//        $country_list = Mage::getResourceModel('directory/country_collection')
//                ->loadData()
//                ->toOptionArray(false);

        $fieldset->addField('title', 'hidden', array(
            'required' => false,
            'name' => 'title',
        ));

        $fieldset->addField('url_key', 'hidden', array(
            'required' => false,
            'name' => 'url_key',
        ));

        $fieldset->addField('brand', 'select', array(
            'name' => 'brand',
            'label' => Mage::helper('brandmanagement')->__('Select Brand'),
            'title' => Mage::helper('brandmanagement')->__('Select Brand'),
            'required' => true,
            'values' => Mage::getModel('brandmanagement/brandmanagement')->getBrandOptions()
        ));

        $fieldset->addField('brand_country', 'select', array(
            'name' => 'brand_country',
            'label' => Mage::helper('brandmanagement')->__('Select Country'),
            'title' => Mage::helper('brandmanagement')->__('Select Country'),
            'required' => true,
            'values' => Mage::getModel('brandmanagement/brandmanagement')->getWineCountry()
        ));

        $fieldset->addField('brand_region', 'select', array(
            'name' => 'brand_region',
            'label' => Mage::helper('brandmanagement')->__('Select Region'),
            'title' => Mage::helper('brandmanagement')->__('Select Region'),
            'required' => true,
            'values' => Mage::getModel('brandmanagement/brandmanagement')->getWineRegion()
        ));

        $fieldset->addField('store_id', 'multiselect', array(
            'name' => 'stores[]',
            'label' => Mage::helper('brandmanagement')->__('Store View'),
            'title' => Mage::helper('brandmanagement')->__('Store View'),
            'required' => true,
            'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true)
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('brandmanagement')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('brandmanagement')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('brandmanagement')->__('Disabled'),
                ),
            ),
        ));

        $fieldset->addField('meta_title', 'text', array(
            'required' => false,
            'name' => 'meta_title',
            'style' => 'width:400px;',
            'label' => Mage::helper('brandmanagement')->__('Meta Title'),
            'title' => Mage::helper('brandmanagement')->__('Meta Title')
        ));

        $fieldset->addField('meta_keywords', 'editor', array(
            'required' => false,
            'name' => 'meta_keywords',
            'style' => 'width:400px; height:80px;',
            'label' => Mage::helper('brandmanagement')->__('Meta Keywords'),
            'title' => Mage::helper('brandmanagement')->__('Meta Keywords')
        ));

        $fieldset->addField('meta_description', 'editor', array(
            'required' => false,
            'name' => 'meta_description',
            'style' => 'width:400px; height:120px;',
            'label' => Mage::helper('brandmanagement')->__('Meta Description'),
            'title' => Mage::helper('brandmanagement')->__('Meta Description')
        ));

        $fieldset->addField('brandimagethumb', 'file', array(
            'label' => Mage::helper('brandmanagement')->__('Brand Thumbnail Image'),
            'required' => false,
            'name' => 'brandimagethumb',
        ));

        $fieldset->addField('brandimage', 'file', array(
            'label' => Mage::helper('brandmanagement')->__('Brand Image'),
            'required' => false,
            'name' => 'brandimage',
        ));


        $fieldset->addField('short_text', 'editor', array(
            'name' => 'short_text',
            'label' => Mage::helper('brandmanagement')->__('Short Description'),
            'title' => Mage::helper('brandmanagement')->__('Short Description'),
            'style' => 'width:300px; height:80px;',
            'wysiwyg' => true,
            'required' => true,
            'theme' => 'advanced',
        ));


        $fieldset->addField('text', 'editor', array(
            'name' => 'text',
            'label' => Mage::helper('brandmanagement')->__('Description'),
            'title' => Mage::helper('brandmanagement')->__('Description'),
            'style' => 'width:700px; height:400px;',
            'wysiwyg' => true,
            'required' => true,
            'theme' => 'advanced',
        ));

        if (Mage::getSingleton('adminhtml/session')->getBrandmanagementData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBrandmanagementData());
            Mage::getSingleton('adminhtml/session')->setBrandmanagementData(null);
        } elseif (Mage::registry('brandmanagement_data')) {
            $form->setValues(Mage::registry('brandmanagement_data')->getData());
        }
        return parent::_prepareForm();
    }

}
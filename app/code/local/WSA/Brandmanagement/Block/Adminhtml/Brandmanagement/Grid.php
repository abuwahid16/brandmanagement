<?php

class WSA_Brandmanagement_Block_Adminhtml_Brandmanagement_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('brandmanagementGrid');
        $this->setDefaultSort('brandmanagement_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('brandmanagement/brandmanagement')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('brandmanagement_id', array(
            'header' => Mage::helper('brandmanagement')->__('ID'),
            'align' => 'right',
            'width' => '80px',
            'index' => 'brandmanagement_id',
        ));

        $this->addColumn('brand', array(
            'header' => Mage::helper('brandmanagement')->__('Brand ID'),
            'width' => '100px',
            'index' => 'brand',
        ));

        $this->addColumn('url_key', array(
            'header' => Mage::helper('brandmanagement')->__('URL key'),
            'align' => 'left',
            'width' => '200px',
            'index' => 'url_key',
        ));
        
        $this->addColumn('title', array(
            'header' => Mage::helper('brandmanagement')->__('Title'),
            'align' => 'left',
            'width' => '200px',
            'index' => 'title',
        ));

        $this->addColumn('short_text', array(
            'header' => Mage::helper('brandmanagement')->__('Description'),
            'width' => '440px',
            'align' => 'left',
            'index' => 'short_text',
        ));

        /*$this->addColumn('brand_country', array(
            'header' => Mage::helper('brandmanagement')->__('Country'),
            'width' => '440px',
            'align' => 'left',
            'index' => 'brand_country',
        ));*/

        $this->addColumn('status', array(
            'header' => Mage::helper('brandmanagement')->__('Status'),
            'align' => 'left',
            'width' => '180px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('brandmanagement')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('brandmanagement')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('brandmanagement')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('brandmanagement')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('brandmanagement_id');
        $this->getMassactionBlock()->setFormFieldName('brandmanagement');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('brandmanagement')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('brandmanagement')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('brandmanagement/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('brandmanagement')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('brandmanagement')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
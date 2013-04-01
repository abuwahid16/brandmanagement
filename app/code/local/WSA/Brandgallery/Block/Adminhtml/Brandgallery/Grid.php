<?php

class WSA_Brandgallery_Block_Adminhtml_Brandgallery_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('brandgalleryGrid');
        $this->setDefaultSort('brandgallery_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('brandgallery/brandgallery')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $this->addColumn('brandgallery_id', array(
            'header' => Mage::helper('brandgallery')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'brandgallery_id',
        ));

        $this->addColumn('brandimage', array(
            'header' => Mage::helper('brandgallery')->__('Brand Image'),
            'align' => 'left',
            'index' => 'brandimage',
            'renderer' => 'brandgallery/adminhtml_brandgallery_renderer_image',
            'width' => '107'
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('brandgallery')->__('Brand'),
            'align' => 'left',
            'index' => 'title',
            'width' => '580'
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('brandgallery')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('brandgallery')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('brandgallery')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('brandgallery')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('brandgallery')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('brandgallery_id');
        $this->getMassactionBlock()->setFormFieldName('brandgallery');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('brandgallery')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('brandgallery')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('brandgallery/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('brandgallery')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('brandgallery')->__('Status'),
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
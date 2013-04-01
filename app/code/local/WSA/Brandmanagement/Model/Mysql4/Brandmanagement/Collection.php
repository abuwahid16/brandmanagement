<?php

class WSA_Brandmanagement_Model_Mysql4_Brandmanagement_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('brandmanagement/brandmanagement');
    }

    public function addStoreFilter($store) {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        $this->getSelect()->join(
                        array('store_table' => $this->getTable('brandmanagement_store')), 'main_table.brandmanagement_id = store_table.brandmanagement_id', array()
                )
                ->where('store_table.store_id in (?)', array(0, $store));

        return $this;
    }

    public function loadByQuery($text) {
        return $this->addStoreFilter(Mage::app()->getStore(true)->getId())
                        ->addFieldToFilter('status', 1)
                        ->addFieldToFilter('title', array("like" => $text . '%'))
                        ->load();
    }

}
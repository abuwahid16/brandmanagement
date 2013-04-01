<?php

class WSA_Brandmanagement_Model_Mysql4_Brandmanagement extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        // Note that the brandmanagement_id refers to the key field in your database table.
        $this->_init('brandmanagement/brandmanagement', 'brandmanagement_id');
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object) {

        $select = $this->_getReadAdapter()->select()
                ->from($this->getTable('brandmanagement_store'))
                ->where('brandmanagement_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }

        return parent::_afterLoad($object);
    }

    /**
     * Process page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object) {

        $condition = $this->_getWriteAdapter()->quoteInto('brandmanagement_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('brandmanagement_store'), $condition);

        foreach ((array) $object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['brandmanagement_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('brandmanagement_store'), $storeArray);
        }

        return parent::_afterSave($object);
    }

}
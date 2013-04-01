<?php

class WSA_Brandmanagement_Helper_Data extends Mage_Core_Helper_Abstract {

    public function checkBrand() {
        try {
            $queryText = Mage::helper('catalogsearch')->getQueryText();
            if ('' != $queryText) {
                $brandCollection = Mage::getModel('brandmanagement/brandmanagement')->loadByQuery($queryText);
                if ($brandCollection->getSize() > 0) {
                    $brandIds = array();
                    foreach ($brandCollection->getItems() as $_brand) {
                        array_push($brandIds, $_brand->getBrand());
                    }
                    return $brandIds;
                }
            }
        } catch (Exception $ex) {
            
        }
        return false;
    }

}
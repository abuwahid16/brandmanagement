<?php

class WSA_Brandmanagement_Model_Observer {

    public function searchBrand($observer) {
        $brandIds = Mage::helper('brandmanagement')->checkBrand();
        if ($brandIds !== false) {
            $controller = $observer->getControllerAction();
            $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
            $query = array(
                'brand' => implode('_', $brandIds),
                Mage::getBlockSingleton('page/html_pager')->getPageVarName() => null // exclude current page from urls
            );
            $url = Mage::getUrl('search-wine', array('_current' => true, '_use_rewrite' => true, '_query' => $query));
            $controller->getResponse()->setRedirect($url);
        }
        return $this;
    }

}

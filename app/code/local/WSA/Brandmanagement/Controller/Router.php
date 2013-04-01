<?php

/**
 * Brandmanagement Controller Router
 *
 * @category    WSA
 * @package     WSA_Brandmanagement
 * @author      Sajib Hassan <hassan@bglobalsourcing.com>
 */
class WSA_Brandmanagement_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract {

    /**
     * Initialize Controller Router
     *
     * @param Varien_Event_Observer $observer
     */
    public function initControllerRouters($observer) {
        /* @var $front Mage_Core_Controller_Varien_Front */
        $front = $observer->getEvent()->getFront();
        $front->addRouter('brandmanagement', $this);
    }

    /**
     * Validate and Match Brandmanagement Page and modify request
     *
     * @param Zend_Controller_Request_Http $request
     * @return bool
     */
    public function match(Zend_Controller_Request_Http $request) {
        if (!Mage::isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                    ->setRedirect(Mage::getUrl('install'))
                    ->sendResponse();
            exit;
        }
        
        $allowedPaths = array('brand-info'=>'winaryinfo','browse-wine'=>'browsewine');

        $_paths = trim($request->getPathInfo(), '/');
        $paths = explode('/', $_paths);
        
        if(count($paths) != 2 || !array_key_exists($paths[0], $allowedPaths)){
            return false;
        }else{
            $action = $allowedPaths[$paths[0]];
            $identifier = $paths[1];
        }       
        
        $brandmanagement = Mage::getModel('brandmanagement/brandmanagement')->checkIdentifier($identifier, Mage::app()->getStore()->getId());

        if (!$brandmanagement->getBrand()) {
            return false;
        }
       
//        $identifier = $paths[0].'/'.$paths[1];
        $request->setModuleName('brandmanagement')
                ->setControllerName('index')
                ->setActionName($action)
                ->setParam('id', $brandmanagement->getBrand());
        $request->setAlias(
                Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS, $_paths
        );

        return true;
    }

}

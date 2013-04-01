<?php

class WSA_Brandmanagement_Adminhtml_BrandmanagementController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('brandmanagement/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('brandmanagement/brandmanagement')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('brandmanagement_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('brandmanagement/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('brandmanagement/adminhtml_brandmanagement_edit'))
                    ->_addLeft($this->getLayout()->createBlock('brandmanagement/adminhtml_brandmanagement_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brandmanagement')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
//            if (isset($_FILES['brandimage']['name']) && $_FILES['brandimage']['name'] != '') {
//                //this way the name is saved in DB
//                $data['brandimage'] = $_FILES['brandimage']['name'];
//
//                //Save Image Tag in DB for GRID View
//                $imgName = $_FILES['brandimage']['name'];
//                $imgPath = Mage::getBaseUrl('media') . "brand/images/thumb/" . $imgName;
//                $data['filethumbgrid'] = '<img src="' . $imgPath . '" alt="'.$imgName.'" border="0" width="132" height="102" />';
//            }

            if (isset($_FILES['brandimage']['name']) && $_FILES['brandimage']['name'] != '') {
                try {

                    /* Starting upload */
                    $uploader = new Varien_File_Uploader('brandimage');

                    // Any extention would work
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(false);

                    // Set the file upload mode 
                    // false -> get the file directly in the specified folder
                    // true -> get the file in the product like folders 
                    //	(file.jpg will go in something like /media/f/i/file.jpg)
                    $uploader->setFilesDispersion(false);

                    // We set media as the upload dir
                    //$path = Mage::getBaseDir('media') . DS;
                    $path = Mage::getBaseDir('media') . "/brand" . DS . "images" . DS;
                    $uploader->save($path, $_FILES['brandimage']['name']);

                    //Create View Size and upload
                    $imgName = $_FILES['brandimage']['name'];
                    $imgPathFull = $path . $imgName;
                    $resizeFolder = "medium";
                    $imageResizedPath = $path . $resizeFolder . DS . $imgName;
                    $imageObj = new Varien_Image($imgPathFull);
                    $imageObj->constrainOnly(TRUE);
                    $imageObj->keepAspectRatio(TRUE);
                    $imageObj->resize(400, 400);
                    $imageObj->save($imageResizedPath);
                } catch (Exception $e) {
                    
                }

                //this way the name is saved in DB
                $data['brandimage'] = $_FILES['brandimage']['name'];
            }

            if (isset($_FILES['brandimagethumb']['name']) && $_FILES['brandimagethumb']['name'] != '') {
                try {

                    /* Starting upload */
                    $uploader = new Varien_File_Uploader('brandimagethumb');

                    // Any extention would work
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(false);

                    // Set the file upload mode 
                    // false -> get the file directly in the specified folder
                    // true -> get the file in the product like folders 
                    //	(file.jpg will go in something like /media/f/i/file.jpg)
                    $uploader->setFilesDispersion(false);

                    // We set media as the upload dir
                    //$path = Mage::getBaseDir('media') . DS;
                    $path = Mage::getBaseDir('media') . "/brand" . DS . "images" . DS;
                    $uploader->save($path, $_FILES['brandimagethumb']['name']);
                    //Create View Size and upload
                    $imgName = $_FILES['brandimagethumb']['name'];
                    $imgPathFull = $path . $imgName;
                    $resizeFolder = "thumb";
                    $imageResizedPath = $path . $resizeFolder . DS . $imgName;
                    $imageObj = new Varien_Image($imgPathFull);
                    $imageObj->constrainOnly(TRUE);
                    $imageObj->keepAspectRatio(TRUE);
                    $imageObj->resize(132, 102);
                    $imageObj->save($imageResizedPath);
                    //$uploader->save($thumbPath, $_FILES['brandimagethumb']['name']);
                } catch (Exception $e) {
                    
                }
                //this way the name is saved in DB
                $data['brandimagethumb'] = $_FILES['brandimagethumb']['name'];
            }

            $model = Mage::getModel('brandmanagement/brandmanagement');
            $model->setData($data)
                    ->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                            ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }
                if (!$this->getRequest()->getParam('id')) {
                    if ($model->isBrandExist($data[brand])) {
                        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brandmanagement')->__('This Brand is already configured. Choose another Brand.'));
                        throw new Exception();
                    }
                }
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brandmanagement')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brandmanagement')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('brandmanagement/brandmanagement');

                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $brandmanagementIds = $this->getRequest()->getParam('brandmanagement');
        if (!is_array($brandmanagementIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($brandmanagementIds as $brandmanagementId) {
                    $brandmanagement = Mage::getModel('brandmanagement/brandmanagement')->load($brandmanagementId);
                    $brandmanagement->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($brandmanagementIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction() {
        $brandmanagementIds = $this->getRequest()->getParam('brandmanagement');
        if (!is_array($brandmanagementIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($brandmanagementIds as $brandmanagementId) {
                    $brandmanagement = Mage::getSingleton('brandmanagement/brandmanagement')
                            ->load($brandmanagementId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($brandmanagementIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction() {
        $fileName = 'brandmanagement.csv';
        $content = $this->getLayout()->createBlock('brandmanagement/adminhtml_brandmanagement_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'brandmanagement.xml';
        $content = $this->getLayout()->createBlock('brandmanagement/adminhtml_brandmanagement_grid')
                ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream') {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

}
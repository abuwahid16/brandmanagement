<?php

class WSA_Brandgallery_Adminhtml_BrandgalleryController extends Mage_Adminhtml_Controller_Action {

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
        $model = Mage::getModel('brandgallery/brandgallery')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('brandgallery_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('brandgallery/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('brandgallery/adminhtml_brandgallery_edit'))
                    ->_addLeft($this->getLayout()->createBlock('brandgallery/adminhtml_brandgallery_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brandgallery')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {

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
                    $path = Mage::getBaseDir('media') . "/brand" . DS . "gallery" . DS;
                    $uploader->save($path, $_FILES['brandimage']['name']);

                    //Create Gallery View Size and upload
                    $imgName = $_FILES['brandimage']['name'];
                    $imgPathFull = $path . $imgName;
                    $galleryFolder = "gallery";
                    $imageResizedPath = $path . $galleryFolder . DS . $imgName;
                    $imageObj = new Varien_Image($imgPathFull);
                    $imageObj->constrainOnly(TRUE);
                    $imageObj->keepAspectRatio(TRUE);
                    //$imageObj->resize(750, 470);
                    $imageObj->resize(750);
                    $imageObj->save($imageResizedPath);

                    //Create View Size and upload
                    //$imgName = $_FILES['brandimage']['name'];
                    $imgPathFull = $path . $imgName;
                    $resizeFolder = "resize";
                    $imageResizedPath = $path . $resizeFolder . DS . $imgName;
                    $imageResizeObj = new Varien_Image($imgPathFull);
                    $imageResizeObj->constrainOnly(TRUE);
                    $imageResizeObj->keepAspectRatio(TRUE);
                    //$imageResizeObj->resize(350, 230);
                    $imageResizeObj->resize(350);
                    $imageResizeObj->save($imageResizedPath);
                } catch (Exception $e) {
                    
                }

                //this way the name is saved in DB
                $data['brandimage'] = $_FILES['brandimage']['name'];
            }


            $model = Mage::getModel('brandgallery/brandgallery');
            $model->setData($data)
                    ->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                            ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brandgallery')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brandgallery')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('brandgallery/brandgallery');

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
        $brandgalleryIds = $this->getRequest()->getParam('brandgallery');
        if (!is_array($brandgalleryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($brandgalleryIds as $brandgalleryId) {
                    $brandgallery = Mage::getModel('brandgallery/brandgallery')->load($brandgalleryId);
                    $brandgallery->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($brandgalleryIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction() {
        $brandgalleryIds = $this->getRequest()->getParam('brandgallery');
        if (!is_array($brandgalleryIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($brandgalleryIds as $brandgalleryId) {
                    $brandgallery = Mage::getSingleton('brandgallery/brandgallery')
                            ->load($brandgalleryId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($brandgalleryIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction() {
        $fileName = 'brandgallery.csv';
        $content = $this->getLayout()->createBlock('brandgallery/adminhtml_brandgallery_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'brandgallery.xml';
        $content = $this->getLayout()->createBlock('brandgallery/adminhtml_brandgallery_grid')
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
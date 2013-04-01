<?php

class WSA_Brandgallery_Block_Adminhtml_Brandgallery_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $html = '<img ';
        $html .= 'id="' . $this->getColumn()->getId() . '" ';
        $html .= 'width="' . $this->getColumn()->getWidth() . '" ';
        $html .= 'src="' . Mage::getBaseUrl("media") . 'brand/gallery/resize/' . $row->getData($this->getColumn()->getIndex()) . '"';
        $html .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '"/>';
        return $html;
    }

}
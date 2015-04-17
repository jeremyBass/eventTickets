<?php
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Renderer_Preview extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
    public function render(Varien_Object $row) {
		$product_id = $row->getData('entity_id');
		$_product = Mage::getModel('catalog/product')->load($product_id); 
 		$href = $_product->getProductUrl();
    	$html = '<a href="'.$href.'" target="_blank"><i class="fa fa-eye"></i> View</a>';
        return $html;
    }
}
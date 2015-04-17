<?php

class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Preview extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
		$product_id = $row->getData('entity_id');
		/*$product_collection = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToFilter('entity_id', $id)
			->addUrlRewrite();
		$href = $product_collection->getFirstItem()->getProductUrl();*/
		$_product = Mage::getModel('catalog/product')->load($product_id); 
 		$href = $_product->getProductUrl();
		//$href = Mage::getResourceSingleton('catalog/product')->getAttributeRawValue($id, 'url_key', Mage::app()->getStore());
		
		
		//$href = Mage::helper('adminhtml')->getUrl('adminhtml/catalog_product/edit/') .'id/$entity_id';
    	$html = '<a href="'.$href.'" target="_blank"><i class="fa fa-eye"></i>View</a>';
	   
	   
	   
//	   'caption' => Mage::helper('wsu_eventtickets')->__('View'),//
//                    'url'     => array('base' => '*/*/registrants'),
//                    'field'   => 'id'
        return $html;
    }

}
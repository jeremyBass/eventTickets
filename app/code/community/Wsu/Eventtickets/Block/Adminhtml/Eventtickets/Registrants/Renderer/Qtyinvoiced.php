<?php

class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Renderer_Qtyinvoiced extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $id = $row->getData('entity_id');
		
		$request = Mage::app()->getRequest();
		$requestData = Mage::helper('adminhtml')->prepareFilterString($request->getParam('filter'));
		
		$model = Mage::getModel('sales/order')->load($id);
		
		if(isset( $requestData['sku'] )){
			 $html =  '0';
			 
			foreach ($model->getAllVisibleItems() as $item) {
				if( strtolower($requestData['sku'])==strtolower($item->getSku()) ){	
					 $html = $item->getQtyInvoiced();
				}
			}
		}else{
			$model->getFirstItem();
			if ((int) $model->getQtyInvoiced() == 0) {
				$html = '0';
			} else {
				$html = (int) $model->getQtyInvoiced();
			}
		}
        return $html;
    }

}
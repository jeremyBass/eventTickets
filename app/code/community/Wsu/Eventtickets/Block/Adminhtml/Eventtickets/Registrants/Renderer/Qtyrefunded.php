<?php

class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Renderer_Qtyrefunded extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $id = $row->getData('entity_id');


		$request = Mage::app()->getRequest();
		$requestData = Mage::helper('adminhtml')->prepareFilterString($request->getParam('filter'));
		
		$model = Mage::getModel('sales/order')->load($id);
		
		if(isset( $requestData['sku'] )){
			 $html =  '0';
			 
			foreach ($model->getAllVisibleItems() as $item) {
				if( strtolower($requestData['sku'])==strtolower($item->getSku()) ){	
					 $html = $item->getQtyRefunded();
				}
			}
		}else{
			$model->getFirstItem();
			if ((int) $model->getQtyRefunded() == 0) {
				$html = '0';
			} else {
				$html = (int) $model->getQtyRefunded();
			}
		}

        return $html;
    }

}
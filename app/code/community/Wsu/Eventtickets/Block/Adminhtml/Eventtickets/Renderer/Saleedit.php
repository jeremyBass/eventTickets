<?php
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Renderer_Saleedit extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
    public function render(Varien_Object $row) {
		$order_id = $row->getData('entity_id');
		$href = Mage::helper("adminhtml")->getUrl('*/sales_order/view',array('order_id'=>$order_id));
    	$html = '<a href="'.$href.'" target="_blank"><i class="fa fa-pencil"></i> Edit</a>';
        return $html;
    }
}
<?php
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Renderer_Getlist extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
    public function render(Varien_Object $row) {
		$product_id = $row->getData('entity_id');
 		$href = Mage::helper("adminhtml")->getUrl('*/*/registrants',array('id'=>$product_id));
    	$html = '<a href="'.$href.'" target="_blank"><i class="fa fa-user-times"></i> Get list</a>';
        return $html;
    }
}
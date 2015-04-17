<?php

class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Renderer_Option extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $id = $row->getData('entity_id');
		$index = $this->getColumn()->getIndex();
		$id = $row->getData($index);

        return $id;
    }

}
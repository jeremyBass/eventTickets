<?php

class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct() {
        $this->_blockGroup = 'wsu_eventtickets';
        $this->_controller = 'adminhtml_eventtickets';
        $this->_headerText = Mage::helper('wsu_eventtickets')->__('Guest Report');
        parent::__construct();
        $this->_removeButton('add');
    }
}
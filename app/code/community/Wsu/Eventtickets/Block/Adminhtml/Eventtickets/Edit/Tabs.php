<?php
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize tabs and define tabs block settings
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('wsu_eventtickets')->__('Ticket Profile'));
		//$this->addTab('categories', array(
//			'label' => Mage::helper('wsu_eventtickets')->__('Associated categories'),
//			'url'   => $this->getUrl('*/*/categories', array('_current' => true)),
//			'class'    => 'ajax'
//		));
    }
}

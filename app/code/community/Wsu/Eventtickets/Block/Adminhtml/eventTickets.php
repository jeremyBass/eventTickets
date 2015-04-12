<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets extends Mage_Adminhtml_Block_Widget_Grid_Container {
    /**
     * Block constructor
     */
    public function __construct() {
        $this->_blockGroup = 'wsu_eventtickets';
        $this->_controller = 'adminhtml_eventtickets';
        $this->_headerText = Mage::helper('wsu_eventtickets')->__('Manage Eventtickets');

        parent::__construct();

        if (Mage::helper('wsu_eventtickets/admin')->isActionAllowed('save')) {
            $this->_updateButton('add', 'label', Mage::helper('wsu_eventtickets')->__('Add New Event'));
        } else {
            $this->_removeButton('add');
        }
//        $this->addButton(
//            'eventtickets_flush_images_cache',
//            array(
//                'label'      => Mage::helper('wsu_eventtickets')->__('Flush Images Cache'),
//                'onclick'    => 'setLocation(\'' . $this->getUrl('*/*/flush') . '\')',
//            )
//        );

    }
}

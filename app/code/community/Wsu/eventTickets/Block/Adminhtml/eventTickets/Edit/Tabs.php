<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize tabs and define tabs block settings
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('wsu_eventtickets')->__('Event Item Info'));
    }
}

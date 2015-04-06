<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * Initialize edit form container
     *
     */
    public function __construct() {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'wsu_eventtickets';
        $this->_controller = 'adminhtml_eventtickets';

        parent::__construct();

        if (Mage::helper('wsu_eventtickets/admin')->isActionAllowed('save')) {
            $this->_updateButton('save', 'label', Mage::helper('wsu_eventtickets')->__('Save Ticket'));
            $this->_addButton('saveandcontinue', array(
                'label'   => Mage::helper('adminhtml')->__('Save and Continue'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ), -100);
        } else {
            $this->_removeButton('save');
        }

        if (Mage::helper('wsu_eventtickets/admin')->isActionAllowed('delete')) {
            $this->_updateButton('delete', 'label', Mage::helper('wsu_eventtickets')->__('Delete Ticket'));
        } else {
            $this->_removeButton('delete');
        }

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'page_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'page_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText() {
        $model = Mage::helper('wsu_eventtickets')->getEventticketsItemInstance();
        if ($model->getId()) {
            return Mage::helper('wsu_eventtickets')->__("Edit Event ticket item '%s'",
                 $this->escapeHtml($model->getTitle()));
        } else {
            return Mage::helper('wsu_eventtickets')->__('New Event ticket item');
        }
    }
}

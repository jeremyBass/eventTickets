<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form action
     *
     * @return Wsu_Eventtickets_Block_Adminhtml_News_Edit_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/save'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}

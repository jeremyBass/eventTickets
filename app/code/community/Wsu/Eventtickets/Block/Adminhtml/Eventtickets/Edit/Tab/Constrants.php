<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit_Tab_Constrants extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface {
    /**
     * Prepare form elements for tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {
        $model = Mage::helper('wsu_eventtickets')->getEventticketsItemInstance();

        /**
         * Checking if user have permissions to save information
         */
        if (Mage::helper('wsu_eventtickets/admin')->isActionAllowed('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('news_main_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('wsu_eventtickets')->__('Eventtickets Item Info')
        ));
		
        if ($model->getId()) {
            $fieldset->addField('eventtickets_id', 'hidden', array(
                'name' => 'eventtickets_id',
            ));
        }
		/*
        $fieldset->addField('title', 'text', array(
            'name'     => 'title',
            'label'    => Mage::helper('wsu_eventtickets')->__('Eventtickets Title'),
            'title'    => Mage::helper('wsu_eventtickets')->__('Eventtickets Title'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('venue', 'text', array(
            'name'     => 'venue',
            'label'    => Mage::helper('wsu_eventtickets')->__('Venue'),
            'title'    => Mage::helper('wsu_eventtickets')->__('Venue'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));
		
		 $fieldset->addField('entry_fee', 'text', array(
            'name'     => 'entry_fee',
            'label'    => Mage::helper('wsu_eventtickets')->__('Entry Fee'),
            'title'    => Mage::helper('wsu_eventtickets')->__('Entry Fee'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('published_at', 'date', array(
            'name'     => 'published_at',
            'format'   => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image'    => $this->getSkinUrl('images/grid-cal.gif'),
            'label'    => Mage::helper('wsu_eventtickets')->__('Publishing Date'),
            'title'    => Mage::helper('wsu_eventtickets')->__('Publishing Date'),
            'required' => true
        ));*/

        Mage::dispatchEvent('adminhtml_eventtickets_edit_tab_constrants_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()  {
        return Mage::helper('wsu_eventtickets')->__('Sales constrants');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('wsu_eventtickets')->__('Sales constrants');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab() {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden() {
        return false;
    }
}

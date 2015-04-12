<?php
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit_Tab_Inforequest extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface {
    /**
     * Prepare form elements for tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {
        $model = Mage::helper('wsu_eventtickets')->getEventticketsItemInstance();
		$webforms_enabled = Mage::helper('core')->isModuleEnabled('Wsu_WebForms');
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
            'legend' => Mage::helper('wsu_eventtickets')->__('Info Request')
        ));
		
        if ($model->getId()) {
            $fieldset->addField('eventtickets_id', 'hidden', array(
                'name' => 'eventtickets_id',
            ));
        }

        Mage::dispatchEvent('adminhtml_eventtickets_edit_tab_inforequest_prepare_form', array('form' => $form));

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
        return Mage::helper('wsu_eventtickets')->__('Info Request');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('wsu_eventtickets')->__('Info Request');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab() {
        return Mage::helper('core')->isModuleOutputEnabled('Wsu_WebForms');
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

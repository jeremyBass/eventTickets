<?php
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface {
    /**
     * Load WYSIWYG on demand and prepare layout
     *
     * @return Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit_Tab_Content
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        return $this;
    }
    /**
     * Prepares tab form
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
        $form->setHtmlIdPrefix('eventtickets_content_');
        $wysiwygConfig    = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array(
            'tab_id' => $this->getTabId()
        ));
        $fieldset         = $form->addFieldset('eligibility_fieldset', array(
            'legend' => Mage::helper('wsu_eventtickets')->__('Eventtickets Short description'),
            'class' => 'fieldset-wide'
        ));
        $eligibilityField = $fieldset->addField('short_description', 'editor', array(
            'name' => 'short_description',
            'style' => 'height:6em;',
            'required' => true,
            'disabled' => $isElementDisabled,
            'config' => $wysiwygConfig
        ));
        $fieldset         = $form->addFieldset('content_fieldset', array(
            'legend' => Mage::helper('wsu_eventtickets')->__('Eventtickets Description'),
            'class' => 'fieldset-wide'
        ));
        $contentField     = $fieldset->addField('description', 'editor', array(
            'name' => 'description',
            'style' => 'height:16em;',
            'required' => true,
            'disabled' => $isElementDisabled,
            'config' => $wysiwygConfig
        ));
        // Setting custom renderer for content field to remove label column
        $renderer         = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset_element')->setTemplate('cms/page/edit/form/renderer/content.phtml');
        $contentField->setRenderer($renderer);
        $eligibilityField->setRenderer($renderer);
        $form->setValues($model->getData());
        $this->setForm($form);
        Mage::dispatchEvent('adminhtml_eventtickets_edit_tab_content_prepare_form', array(
            'form' => $form
        ));
        return parent::_prepareForm();
    }
    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel() {
        return Mage::helper('wsu_eventtickets')->__('Content');
    }
    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('wsu_eventtickets')->__('Content');
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

<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit_Tab_Image
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare form elements
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        /**
         * Checking if user have permissions to save information
         */
        if (Mage::helper('wsu_eventtickets/admin')->isActionAllowed('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('eventtickets_image_');

        $model = Mage::helper('wsu_eventtickets')->getEventticketsItemInstance();


        $fieldset = $form->addFieldset('image_fieldset', array(
            'legend'    => Mage::helper('wsu_eventtickets')->__('Image Thumbnail'), 'class' => 'fieldset-wide'
        ));

        $this->_addElementTypes($fieldset);

        $fieldset->addField('image', 'image', array(
            'name'      => 'image',
            'label'     => Mage::helper('wsu_eventtickets')->__('Image'),
            'title'     => Mage::helper('wsu_eventtickets')->__('Image'),
            'required'  => false,
            'disabled'  => $isElementDisabled
        ));

        Mage::dispatchEvent('adminhtml_news_edit_tab_image_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('wsu_eventtickets')->__('Image Thumbnail');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('wsu_eventtickets')->__('Image Thumbnail');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Retrieve predefined additional element types
     *
     * @return array
     */
     protected function _getAdditionalElementTypes()
     {
         return array(
            'image' => Mage::getConfig()->getBlockClassName('wsu_eventtickets/adminhtml_eventtickets_edit_form_element_image')
        );
     }
}

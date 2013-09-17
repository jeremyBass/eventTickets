<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_eventTickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_eventTickets_Adminhtml_eventTicketsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Wsu_eventTickets_Adminhtml_eventTicketsController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('eventtickets/manage')
            ->_addBreadcrumb(
                  Mage::helper('wsu_eventtickets')->__('eventTickets'),
                  Mage::helper('wsu_eventtickets')->__('eventTickets')
              )
            ->_addBreadcrumb(
                  Mage::helper('wsu_eventtickets')->__('Manage eventTickets'),
                  Mage::helper('wsu_eventtickets')->__('Manage eventTickets')
              )
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('eventTickets'))
             ->_title($this->__('Manage eventTickets'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new eventTickets item
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit eventTickets item
     */
    public function editAction()
    {
        $this->_title($this->__('eventTickets'))
             ->_title($this->__('Manage eventTickets'));

        // 1. instance eventtickets model
        /* @var $model Wsu_eventTickets_Model_Item */
        $model = Mage::getModel('wsu_eventtickets/eventtickets');

        // 2. if exists id, check it and load data
        $eventticketsId = $this->getRequest()->getParam('id');
        if ($eventticketsId) {
            $model->load($eventticketsId);

            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('wsu_eventtickets')->__('eventTickets item does not exist.')
                );
                return $this->_redirect('*/*/');
            }
            // prepare title
            $this->_title($model->getTitle());
            $breadCrumb = Mage::helper('wsu_eventtickets')->__('Edit Item');
        } else {
            $this->_title(Mage::helper('wsu_eventtickets')->__('New Item'));
            $breadCrumb = Mage::helper('wsu_eventtickets')->__('New Item');
        }

        // Init breadcrumbs
        $this->_initAction()->_addBreadcrumb($breadCrumb, $breadCrumb);

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('eventtickets_item', $model);

        // 5. render layout
        $this->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $redirectPath   = '*/*';
        $redirectParams = array();

        // check if data sent
        $data = $this->getRequest()->getPost();
        if ($data) {
            $data = $this->_filterPostData($data);
            // init model and set data
            /* @var $model Wsu_eventTickets_Model_Item */
            $model = Mage::getModel('wsu_eventtickets/eventtickets');

            // if eventtickets item exists, try to load it
            $eventticketsId = $this->getRequest()->getParam('eventtickets_id');
            if ($eventticketsId) {
                $model->load($eventticketsId);
            }
            // save image data and remove from data array
            if (isset($data['image'])) {
                $imageData = $data['image'];
                unset($data['image']);
            } else {
                $imageData = array();
            }
            $model->addData($data);

            try {
                $hasError = false;
                /* @var $imageHelper Wsu_eventTickets_Helper_Image */
                $imageHelper = Mage::helper('wsu_eventtickets/image');
                // remove image

                if (isset($imageData['delete']) && $model->getImage()) {
                    $imageHelper->removeImage($model->getImage());
                    $model->setImage(null);
                }

                // upload new image
                $imageFile = $imageHelper->uploadImage('image');
                if ($imageFile) {
                    if ($model->getImage()) {
                        $imageHelper->removeImage($model->getImage());
                    }
                    $model->setImage($imageFile);
                }
                // save the data
                $model->save();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('wsu_eventtickets')->__('The eventtickets item has been saved.')
                );

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $redirectPath   = '*/*/edit';
                    $redirectParams = array('id' => $model->getId());
                }
            } catch (Mage_Core_Exception $e) {
                $hasError = true;
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $hasError = true;
                $this->_getSession()->addException($e,
                    Mage::helper('wsu_eventtickets')->__('An error occurred while saving the eventtickets item.')
                );
            }

            if ($hasError) {
                $this->_getSession()->setFormData($data);
                $redirectPath   = '*/*/edit';
                $redirectParams = array('id' => $this->getRequest()->getParam('id'));
            }
        }

        $this->_redirect($redirectPath, $redirectParams);
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        $itemId = $this->getRequest()->getParam('id');
        if ($itemId) {
            try {
                // init model and delete
                /** @var $model Wsu_eventTickets_Model_Item */
                $model = Mage::getModel('wsu_eventtickets/eventtickets');
                $model->load($itemId);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('wsu_eventtickets')->__('Unable to find a event item.'));
                }
                $model->delete();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('wsu_eventtickets')->__('The event item has been deleted.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('wsu_eventtickets')->__('An error occurred while deleting the event item.')
                );
            }
        }

        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'new':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('eventtickets/manage/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('eventtickets/manage/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('eventtickets/manage');
                break;
        }
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array
     * @return array
     */
    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array('time_published'));
        return $data;
    }

    /**
     * Grid ajax action
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Flush eventTickets Posts Images Cache action
     */
    public function flushAction()
    {
        if (Mage::helper('wsu_eventtickets/image')->flushImagesCache()) {
            $this->_getSession()->addSuccess('Cache successfully flushed');
        } else {
            $this->_getSession()->addError('There was error during flushing cache');
        }
        $this->_forward('index');
    }
}

<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Adminhtml_EventticketsController extends Mage_Adminhtml_Controller_Action {
	
    /**
     * Init actions
     *
     * @return Wsu_Eventtickets_Adminhtml_EventticketsController
     */
    protected function _initAction() {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('eventtickets/manage')
            ->_addBreadcrumb(
                  Mage::helper('wsu_eventtickets')->__('Eventtickets'),
                  Mage::helper('wsu_eventtickets')->__('Eventtickets')
              )
            ->_addBreadcrumb(
                  Mage::helper('wsu_eventtickets')->__('Manage Eventtickets'),
                  Mage::helper('wsu_eventtickets')->__('Manage Eventtickets')
              )
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()  {
        $this->_title($this->__('Eventtickets'))
             ->_title($this->__('Manage Eventtickets'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new Eventtickets item
     */
    public function newAction() {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit Eventtickets item
     */
    public function editAction() {
        $this->_title($this->__('Eventtickets'))
             ->_title($this->__('Manage Eventtickets'));

        $model = Mage::getModel('catalog/product');

		
        // 2. if exists id, check it and load data
        $id = $this->getRequest()->getParam('id');
        if ($id) {
			$model->load($id);

            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('wsu_eventtickets')->__('Eventtickets item does not exist.')
                );
                return $this->_redirect('*/*/');
            }
            // prepare title
            $this->_title($model->getName());
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
    public function saveAction() {
        $redirectPath   = '*/*';
        $redirectParams = array();

        // check if data sent
        $data = $this->getRequest()->getPost();

		
		$data = array(
			array(
				'sku' => 'event1',
				'_type' => Wsu_eventTickets_Model_Product_Type::TYPE_CP_PRODUCT,//'simple',
				'product_type' => 'main product',
				'_attribute_set' => 'Entertainment Events',
				//'_product_websites' => $websiteCodes,
				//'website' => $websiteCodeId,
				'name' => $data['product']['name'],
				'price' => 0,
				//'_category' => $eventsCatId,
				'description' => $data['details'],
				'short_description' => $data['details'],
				'event_start_date' =>$data['product']['event_start_date'],
				'event_start_time' =>$data['product']['event_start_time'],
				'event_end_date' =>$data['product']['event_end_date'],
				'event_end_time' =>$data['product']['event_end_time'],
				'registration_closes_date' =>$data['product']['registration_closes_date'],
				'registration_closed_time' =>$data['product']['registration_closes_time'],
				'has_access_validation' =>$data['product']['has_access_validation'],
				'access_code' =>$data['product']['access_code'],
				'food_options' =>$data['product']['food_options'],
				'request_seating' =>$data['product']['request_seating'],
				'custom_accommodation_response' =>$data['product']['custom_accommodation_response'],
				'has_sales_limit' =>$data['product']['has_sales_limit'],
				'collect_guest_info' =>$data['product']['collect_guest_info'],
				//'event_relative_end_time' =>$data['product']['event_relative_end_time'],
				'meta_title' => 'Default',
				'meta_description' => 'Default',
				'meta_keywords' => 'Default',
				'status' => 1,
				'visibility' => 4,
				'tax_class_id' => 2,
				'qty' => 50,
				'is_in_stock' => 1,
				'enable_googlecheckout' => '0',
				'gift_message_available' => '0',
				'url_key' => strtolower(str_replace(' ','-',$data['product']['name'])),
				/*'media_gallery' => $media_gallery_id,
				"_media_attribute_id" => $media_gallery_id,
				"_media_lable" =>"Game Day",
				"_media_position" => 1,
				"_media_is_disabled" => 0,
				"_media_image" => "http://football-weekends.wsu.edu/Content/images/Landing05.jpg",
				'image' => basename("http://football-weekends.wsu.edu/Content/images/Landing05.jpg"),
				'small_image' => basename("http://football-weekends.wsu.edu/Content/images/Landing05.jpg"),
				'thumbnail' => basename("http://football-weekends.wsu.edu/Content/images/Landing05.jpg"),*/
			),
		);	
		
		


$import = Mage::getModel('fastsimpleimport/import');
/*
var_dump($data);
$import
	->setPartialIndexing(true)
	->setBehavior(Mage_ImportExport_Model_Import::BEHAVIOR_APPEND)
	->dryrunProductImport($data);

*/
$import
	->setPartialIndexing(true)
	->setBehavior(Mage_ImportExport_Model_Import::BEHAVIOR_APPEND)
	->processProductImport($data);

		
		
		
//
//		
//        if ($data) {
//            $data = $this->_filterPostData($data);
//            // init model and set data
//            // @var $model Wsu_Eventtickets_Model_Item 
//            $model = Mage::getModel('wsu_eventtickets/eventtickets');
//
//            // if eventtickets item exists, try to load it
//            $eventticketsId = $this->getRequest()->getParam('eventtickets_id');
//            if ($eventticketsId) {
//                $model->load($eventticketsId);
//            }
//            // save image data and remove from data array
//            if (isset($data['image'])) {
//                $imageData = $data['image'];
//                unset($data['image']);
//            } else {
//                $imageData = array();
//            }
//            $model->addData($data);
//
//            try {
//                $hasError = false;
//                // @var $imageHelper Wsu_Eventtickets_Helper_Image 
//                $imageHelper = Mage::helper('wsu_eventtickets/image');
//                // remove image
//
//                if (isset($imageData['delete']) && $model->getImage()) {
//                    $imageHelper->removeImage($model->getImage());
//                    $model->setImage(null);
//                }
//
//                // upload new image
//                $imageFile = $imageHelper->uploadImage('image');
//                if ($imageFile) {
//                    if ($model->getImage()) {
//                        $imageHelper->removeImage($model->getImage());
//                    }
//                    $model->setImage($imageFile);
//                }
//                // save the data
//                $model->save();
//
//                // display success message
//                $this->_getSession()->addSuccess(
//                    Mage::helper('wsu_eventtickets')->__('The eventtickets item has been saved.')
//                );
//
//                // check if 'Save and Continue'
//                if ($this->getRequest()->getParam('back')) {
//                    $redirectPath   = '*/*/edit';
//                    $redirectParams = array('id' => $model->getId());
//                }
//            } catch (Mage_Core_Exception $e) {
//                $hasError = true;
//                $this->_getSession()->addError($e->getMessage());
//            } catch (Exception $e) {
//                $hasError = true;
//                $this->_getSession()->addException($e,
//                    Mage::helper('wsu_eventtickets')->__('An error occurred while saving the eventtickets item.')
//                );
//            }
//
//            if ($hasError) {
//                $this->_getSession()->setFormData($data);
//                $redirectPath   = '*/*/edit';
//                $redirectParams = array('id' => $this->getRequest()->getParam('id'));
//            }
//        }
//
//        $this->_redirect($redirectPath, $redirectParams);
$this->_redirect('*/*/');
    }

    /**
     * Delete action
     */
    public function deleteAction() {
        // check if we know what should be deleted
        $itemId = $this->getRequest()->getParam('id');
        if ($itemId) {
            try {
                // init model and delete
                /** @var $model Wsu_Eventtickets_Model_Item */
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
    protected function _isAllowed() {
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
    protected function _filterPostData($data) {
        $data = $this->_filterDates($data, array('time_published'));
        return $data;
    }

    /**
     * Grid ajax action
     */
    public function gridAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Flush Eventtickets Posts Images Cache action
     */
    public function flushAction() {
        if (Mage::helper('wsu_eventtickets/image')->flushImagesCache()) {
            $this->_getSession()->addSuccess('Cache successfully flushed');
        } else {
            $this->_getSession()->addError('There was error during flushing cache');
        }
        $this->_forward('index');
    }
}

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
	
	public function categoriesAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function categoriesJsonAction(){
		$this->_initProduct();
		$this->getResponse()->setBody(
			$this->getLayout()->createBlock('wsu_eventtickets/adminhtml_eventtickets_edit_tab_categories')
				->getCategoryChildrenJson($this->getRequest()->getParam('category'))
		);
	}
	protected function _initProduct(){
		$productId  = (int) $this->getRequest()->getParam('id');
		$product    = Mage::getModel('catalog/product');
	
		if ($productId) {
			$product->load($productId);
		}
		Mage::register('current_product', $product);
		return $product;
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

		Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
		$product = Mage::getModel('catalog/product');
		
		$su = Mage::helper('storeutilities/utilities');
		
		$new = true;
		$product->load($data['product']['id']);
		if($product->getId()){
			$new = false;
		}
		try{
			$product
			//->setStoreId(1) //you can set data in store scope
			->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
			->setAttributeSetId($su->getAttributeSetId($data['product']['attribute_set'])) //ID of a attribute set named 'default'
			->setTypeId(Wsu_eventTickets_Model_Product_Type::TYPE_CP_PRODUCT) //product type

			->setSku( $data['product']['sku'] ) //SKU
			->setName( $data['product']['name'] ) //product name
			->setUrl_key( strtolower( str_replace( ' ', '-', $data['product']['name'] ) ) )
			
			//required parts to work
			->setWeight(0)
			->setStatus(1) //product status (1 - enabled, 2 - disabled)
			->setTaxClassId(0) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
			->setVisibility( Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH ) //catalog and search visibility
			->setPrice( $data['product']['price'] )//$data['product']['price'])
			->setCost(0)
			->setDescription( $data['description'] )
			->setShortDescription( $data['short_description'] )
			//->setMetaTitle('test meta title 2')
			//->setMetaKeyword('test meta keyword 2')
			//->setMetaDescription('test meta description 2')

		 	//event data
		 	->setEventStartDate( $data['product']['event_start_date'] )
			->setEventStartTime( $data['product']['event_start_time'] )
			->setEventEndDate( $data['product']['event_end_date'] )
			->setEventEndTime( $data['product']['event_end_time'] )
			->setRegistrationClosesDate( $data['product']['registration_closes_date'] )
			->setRegistrationClosedTime( $data['product']['registration_closes_time'] )
			->setHasAccessValidation( $data['product']['has_access_validation'] )
			->setAccessCode( $data['product']['access_code'] )
			->setFoodOptions( $data['product']['food_options'] )
			->setRequestSeating( $data['product']['request_seating'] )
			->setCustomAccommodationResponse( $data['product']['custom_accommodation_response'] )
			->setHasSalesLimit( $data['product']['has_sales_limit'] )
			->setCollectGuestInfo( $data['product']['collect_guest_info'] )

			//->setMediaGallery (array('images'=>array (), 'values'=>array ())) //media gallery initialization
			//->addImageToMediaGallery('media/catalog/product/1/0/10243-1.png', array('image','thumbnail','small_image'), false, false) //assigning image, thumb and small image to media gallery
		 /*
			->setStockData(array(
							   'use_config_manage_stock' => 0, //'Use config settings' checkbox
							   'manage_stock'=>1, //manage stock
							   'min_sale_qty'=>1, //Minimum Qty Allowed in Shopping Cart
							   'max_sale_qty'=>2, //Maximum Qty Allowed in Shopping Cart
							   'is_in_stock' => 1, //Stock Availability
							   'qty' => 999 //qty
						   )
			)*/
		 
			//->setCategoryIds(array(3, 10))
			; //assign product to categories
			if($new){
				$product->setCreatedAt(strtotime('now')); //product creation time
			}
			$product->setUpdatedAt(strtotime('now')); //product update time
			$product->save();
		}catch(Exception $e){
			Mage::log($e->getMessage());
		}
		
//
//            try {
//                $hasError = false;
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

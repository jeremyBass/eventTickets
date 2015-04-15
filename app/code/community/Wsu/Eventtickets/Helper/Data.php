<?php
class Wsu_Eventtickets_Helper_Data extends Mage_Core_Helper_Data {

    /**
     * Path to store config if front-end output is enabled
     *
     * @var string
     */
    const XML_PATH_ENABLED            = 'eventtickets/view/enabled';

    /**
     * Path to store config where count of eventtickets posts per page is stored
     *
     * @var string
     */
    const XML_PATH_ITEMS_PER_PAGE     = 'eventtickets/view/items_per_page';

    /**
     * Path to store config where count of days while eventtickets is still recently added is stored
     *
     * @var string
     */
    const XML_PATH_DAYS_DIFFERENCE    = 'eventtickets/view/days_difference';

    /**
     * Eventtickets Item instance for lazy loading
     *
     * @var Wsu_Eventtickets_Model_Eventtickets
     */
    protected $_eventticketsItemInstance;

	public $_ET_ATTRSET_NAME_GENERAL		= "Events";
	public $_ET_ATTRSET_NAME_SPORTS			= "Sports Events";
	public $_ET_ATTRSET_NAME_ENTERTAINMENT	= "Entertainment Events";


    /**
     * Checks whether eventtickets can be displayed in the frontend
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function isEnabled($store = null){
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }

    /**
     * Return the number of items per page
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return int
     */
    public function getEventticketsPerPage($store = null){
        return abs((int)Mage::getStoreConfig(self::XML_PATH_ITEMS_PER_PAGE, $store));
    }

    /**
     * Return difference in days while eventtickets is recently added
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return int
     */
    public function getDaysDifference($store = null){
        return abs((int)Mage::getStoreConfig(self::XML_PATH_DAYS_DIFFERENCE, $store));
    }

    /**
     * Return current eventtickets item instance from the Registry
     *
     * @return Wsu_Eventtickets_Model_Eventtickets
     */
    public function getEventticketsItemInstance(){
        if (!$this->_eventticketsItemInstance) {
            $this->_eventticketsItemInstance = Mage::registry('eventtickets_item');

            if (!$this->_eventticketsItemInstance) {
                Mage::throwException($this->__('Eventtickets item instance does not exist in Registry'));
            }
        }

        return $this->_eventticketsItemInstance;
    }
	
	public function getDateTimeDisplay($product){
		//this would be a block with in the event ext
		$eventStart = Mage::getModel('core/date')->timestamp($product->getEventStartDateTime());
		$eventEnd = Mage::getModel('core/date')->timestamp($product->getEventEndDateTime());

		$eventStart_date = date('l jS \of F Y',$eventStart);
		$eventEnd_date = date('l jS \of F Y',$eventEnd);

		$eventStart_time = date('h:i A',$eventStart);
		$eventEnd_time = date('h:i A',$eventEnd);		
		
		$dateTimeStr="";
		$current_time = date("Y-m-d H:i:s");
		
		if($eventStart_date==$eventEnd_date){
		// Starting at 7:00 PM on Thursday 1st of January 1970 
		// Starting on Thursday 1st of January 1970 
		// Starting at 7:00 PM on Thursday 1st of January 1970 <br/> Till  7:00 PM
			$dateTimeStr .= "Starting";
			if($eventStart_time!=$eventEnd_time || $eventStart_time!="12:00 AM"){
				$dateTimeStr .= " at ".$eventStart_time;
			}
			$dateTimeStr .= " on ".$eventStart_date;
			if($eventStart_time!=$eventEnd_time){
				$dateTimeStr .= "<br/> Till ".$eventEnd_time;
			}
		}else{
		// Starting at 7:00 PM on Thursday 1st of January 1970 
		// Starting on Thursday 1st of January 1970 
		// Starting at 7:00 PM on Thursday 1st of January 1970 <br/> Till  7:00 PM
			$dateTimeStr .= "Starting on ".$eventStart_date;
			if($eventStart_time!=$eventEnd_time){
				$dateTimeStr .= " at ".$eventStart_time;
			}
			$dateTimeStr .= "<br/> Through ";
			if($eventStart_time!=$eventEnd_time){
				$dateTimeStr .= $eventEnd_time." on ";
			}
			$dateTimeStr .= $eventEnd_date;
		}	
		return $dateTimeStr;
	}
	
	
	public function _findCollection($id=0){
		$request = Mage::app()->getRequest();
        $requestData = Mage::helper('adminhtml')->prepareFilterString($request->getParam('filter'));
		
		//var_dump($requestData);die();
		
		
		$collection = Mage::getModel('sales/order')->getCollection();

		$fromDate = date('Y-m-d H:i:s', strtotime("-1 year", time()));
		$toDate = date('Y-m-d H:i:s', strtotime('now'));
		if (!empty($requestData) && isset($requestData['created_at'])) {
			if( isset($requestData['created_at']['from'])
				 && strtotime($requestData['created_at']['from'].' 00:00:00' ) < strtotime('now')
				 && strtotime($requestData['created_at']['from'].' 00:00:00' ) < strtotime($requestData['created_at']['to'].' 23:59:59' )
			){
				$fromDate=date('Y-m-d H:i:s', strtotime( $requestData['created_at']['from'].' 00:00:00' ));
			}
			if( isset($requestData['created_at']['to']) 
			    && strtotime($requestData['created_at']['to'].' 23:59:59' )<strtotime('now')
			){
				$toDate=date('Y-m-d H:i:s', strtotime($requestData['created_at']['to'].' 23:59:59' ));
			}
		}
		$collection->addAttributeToFilter('main_table.created_at', array('from'=>$fromDate,'to'=>$toDate));

		$collection->getSelect()->join(
				Mage::getSingleton('core/resource')->getTableName('sales_flat_order_address'),
				'main_table.billing_address_id = ' . Mage::getSingleton('core/resource')->getTableName('sales_flat_order_address') . '.entity_id',
					array('country_id',
						'region',
						'city',
						'postcode',
						'main_table.total_qty_ordered',
						'main_table.subtotal',
						'main_table.tax_amount',
						'main_table.discount_amount',
						'main_table.grand_total',
						'main_table.total_invoiced',
						'main_table.total_refunded'
					 )
			);
		$collection->join(
				'sales/order_item', '`sales/order_item`.order_id=`main_table`.entity_id', array(
					'skus' => new Zend_Db_Expr('group_concat(`sales/order_item`.sku SEPARATOR ",")'),
					'names' => new Zend_Db_Expr('group_concat(`sales/order_item`.name SEPARATOR ",")'),
					'product_id',
					'product_type',
					'qty_invoiced',
					'qty_shipped',
					'qty_refunded',
				)
		);
		$collection->getSelect()->group('main_table.entity_id');

		$storeIds = $request->getParam('store_ids');
		if (!is_null($storeIds)) {
			$arrStoreIds = explode(',', $storeIds);
			$collection->getSelect()->where('main_table.store_id IN(?)', $arrStoreIds);
		}
		if (!empty($requestData)) {
			if(isset( $requestData['status'] )){
				$collection->getSelect()->Where('main_table.status = ?',$requestData['status']);
			}
			if(isset( $requestData['customer_email'] )){
				$collection->getSelect()->Where('main_table.customer_email LIKE CONCAT(?,\'%\')',$requestData['customer_email']);
			}
			if(isset( $requestData['customer_firstname'] )){
				$collection->getSelect()->Where('main_table.customer_firstname LIKE CONCAT(?,\'%\')',$requestData['customer_firstname']);
			}
			if(isset( $requestData['customer_lastname'] )){
				$collection->getSelect()->Where('main_table.customer_lastname LIKE CONCAT(?,\'%\')',$requestData['customer_lastname']);
			}
			if(isset( $requestData['name'] )){
				$collection->getSelect()->Having('names LIKE CONCAT(\'%\',?,\'%\')',$requestData['name']);
			}
			if(isset( $requestData['sku'] )){
				$collection->getSelect()->Having('skus LIKE CONCAT(\'%\',?,\'%\')', $requestData['sku']);
			}
			if(isset( $requestData['product_id'] )){
				$collection->getSelect()->Where('product_id = ?', $requestData['product_id']);
			}
        }
		if(isset( $id ) && $id>0){
			$collection->getSelect()->Where('product_id = ?', $id);
		}
		
		$collection->getSelect()->Where('product_type = ?', Wsu_eventTickets_Model_Product_Type::TYPE_CP_PRODUCT);
		//print(Wsu_eventTickets_Model_Product_Type::TYPE_CP_PRODUCT);
		//print((string) $collection->getSelect());die();
		
		set_time_limit ('600');
			Mage::unregister('dyno_col'); 
			Mage::register('dyno_col', Mage::helper('wsu_eventtickets')->dynoColCallback($collection));
			$newCollection = new Varien_Data_Collection();
			$dyno_col=(array)Mage::registry('dyno_col');
			$collection=Mage::registry('collection');
			if(!empty($collection)){
				foreach($collection as $item){
					foreach($dyno_col as $keyed){
						$value=Mage::helper('wsu_eventtickets')->dynoColValue($item,$keyed);
						$item->setData("${keyed}",$value);
					 }
					 $newCollection->addItem($item);
				}
			}
		set_time_limit ('60');
		return $newCollection;
	}


	// callback method
	public function dynoColValue($_item,$key) {
		$finalResult = array();
		$dynoResult = $_item->getData('dynoresult');
		if(isset($dynoResult)){
			$finalResult=$dynoResult;
		}else{
			$model = Mage::getModel('sales/order')->load($_item->getId());
			// Loop through all items in the cart
			foreach ($model->getAllVisibleItems() as $item) {
				$product = $item->getProduct();
				// Array to hold the item's options
				$result = array();
				// Load the configured product options
				$options = $item->getProductOptions();
				//$finalResult = array_merge($finalResult, $options);
				// Check for options
				if (isset($options['info_buyRequest'])){
					$info = $options['info_buyRequest'];
					if (isset($info['options'])){
					//	$result = array_merge($result, $info['options']);
					}
					if (isset($info['options']['additional_options'])){
						$result = array_merge($result, unserialize($info['options']['additional_options']) );
					}
					if (!empty($info['attributes_info'])){
						$result = array_merge($info['attributes_info'], $result);
					}
				}
				$finalResult = array_merge($finalResult, $result);
			}
		}
		foreach ($finalResult as $_option){
			$label = trim($this->escapeHtml($_option['label']));
			if ($label==$key){
				return $_option['value'];
			}
		}
		return "";
	}


	// callback method
	public function dynoColCallback($collection) {
		$optionkeyarray=array();
		$request = Mage::app()->getRequest();
		$requestData = Mage::helper('adminhtml')->prepareFilterString($request->getParam('filter'));
		try{
			$newCollection = new Varien_Data_Collection();
			foreach($collection as $_item){
				$finalResult = array();
				$model = Mage::getModel('sales/order')->load($_item->getId());
				
				// Loop through all items in the cart
				foreach ($model->getAllVisibleItems() as $item) {
					$product = $item->getProduct();
					$result = array();
					if(isset( $requestData['sku'] ) && strtolower($requestData['sku'])==strtolower($item->getSku()) || !isset( $requestData['sku'] )){
						// Array to hold the item's options
						
						// Load the configured product options
						$options = $item->getProductOptions();
						//$finalResult = array_merge($finalResult, $options);
						// Check for options
						if (isset($options['info_buyRequest'])){
							$info = $options['info_buyRequest'];
							if (isset($info['options'])){
							//	$result = array_merge($result, $info['options']);
							}
							if (isset($info['options']['additional_options'])){
								$result = array_merge($result, unserialize($info['options']['additional_options']) );
							}
							if (!empty($info['attributes_info'])){
								$result = array_merge($info['attributes_info'], $result);
							}
						}
						$finalResult = array_merge($finalResult, $result);
					}
				}
					/*if($_item->getId()==94){
						
						var_dump($requestData['sku']);
						var_dump($finalResult);
						var_dump($model->getAllVisibleItems());
						die('94');	
					}*/
				foreach ($finalResult as $_option){
					$label = trim($this->escapeHtml($_option['label']));
					if ($label!=="" && strpos($label,'guest_')===false ){
						$optionkeyarray[]=$label;
					}
					if ( $label!=="" && strpos($label,'guest_')!==false && strpos($label,'_{%d%}_')===false ){
						$optionkeyarray[]=$label;
					}
				}
				
				$_item->setData("dynoresult",$finalResult);
				$newCollection->addItem($_item);
			}
			Mage::unregister('collection'); 
			Mage::register('collection', $newCollection);
		}catch(Exception $e){
			Mage::log($e,Zend_Log::ERR,"xRport.txt");
		}
		$optionkeyarray=array_unique($optionkeyarray);
		return $optionkeyarray;
	}



	
}

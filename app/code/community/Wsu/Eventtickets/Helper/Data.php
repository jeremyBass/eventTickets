<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Helper_Data extends Mage_Core_Helper_Data
{
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

    /**
     * Checks whether eventtickets can be displayed in the frontend
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function isEnabled($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }

    /**
     * Return the number of items per page
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return int
     */
    public function getEventticketsPerPage($store = null)
    {
        return abs((int)Mage::getStoreConfig(self::XML_PATH_ITEMS_PER_PAGE, $store));
    }

    /**
     * Return difference in days while eventtickets is recently added
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return int
     */
    public function getDaysDifference($store = null)
    {
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
		$eventStart = strtotime($product->getEventStartDateTime());
		$eventEnd = strtotime($product->getEventEndDateTime());

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
	
	
	
	
}

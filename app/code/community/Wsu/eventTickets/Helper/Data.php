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
    public function getEventticketsItemInstance()
    {
        if (!$this->_eventticketsItemInstance) {
            $this->_eventticketsItemInstance = Mage::registry('eventtickets_item');

            if (!$this->_eventticketsItemInstance) {
                Mage::throwException($this->__('Eventtickets item instance does not exist in Registry'));
            }
        }

        return $this->_eventticketsItemInstance;
    }
}

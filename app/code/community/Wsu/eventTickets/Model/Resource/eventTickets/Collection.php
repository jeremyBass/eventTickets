<?php
class Wsu_Eventtickets_Model_Resource_Eventtickets_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    /**
     * Define collection model
     */
    protected function _construct() {
        $this->_init('wsu_eventtickets/eventtickets');
    }

    /**
     * Prepare for displaying in list
     *
     * @param integer $page
     * @return Wsu_Eventtickets_Model_Resource_Eventtickets_Collection
     */
    public function prepareForList($page) {
        $this->setPageSize(Mage::helper('wsu_eventtickets')->getEventticketsPerPage());
        $this->setCurPage($page)->setOrder('published_at', Varien_Data_Collection::SORT_ORDER_DESC);
        return $this;
    }
}

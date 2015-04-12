<?php
class Wsu_Eventtickets_Block_List extends Mage_Core_Block_Template {
    /**
     * Eventtickets collection
     *
     * @var Wsu_Eventtickets_Model_Resource_Eventtickets_Collection
     */
    protected $_eventticketsCollection = null;
    /**
     * Retrieve eventtickets collection
     *
     * @return Wsu_Eventtickets_Model_Resource_Eventtickets_Collection
     */
    protected function _getCollection() {
        return Mage::getResourceModel('catalog/product_collection')
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('type_id', Wsu_eventTickets_Model_Product_Type::TYPE_CP_PRODUCT);
    }
    /**
     * Retrieve prepared eventtickets collection
     *
     * @return Wsu_Eventtickets_Model_Resource_Eventtickets_Collection
     */
    public function getCollection() {
        if (is_null($this->_eventticketsCollection)) {
            $this->_eventticketsCollection = $this->_getCollection();
            $this->_eventticketsCollection->prepareForList($this->getCurrentPage());
        }
        return $this->_eventticketsCollection;
    }
    /**
     * Return URL to item's view page
     *
     * @param Wsu_Eventtickets_Model_Eventtickets $eventticketsItem
     * @return string
     */
    public function getItemUrl($eventticketsItem) {
        return $this->getUrl('*/*/view', array(
            'id' => $eventticketsItem->getId()
        ));
    }
    /**
     * Fetch the current page for the eventtickets list
     *
     * @return int
     */
    public function getCurrentPage() {
        return $this->getData('current_page') ? $this->getData('current_page') : 1;
    }
    /**
     * Get a pager
     *
     * @return string|null
     */
    public function getPager() {
        $pager = $this->getChild('eventtickets_list_pager');
        if ($pager) {
            $eventticketsPerPage = Mage::helper('wsu_eventtickets')->getEventticketsPerPage();
            $pager->setAvailableLimit(array(
                $eventticketsPerPage => $eventticketsPerPage
            ));
            $pager->setTotalNum($this->getCollection()->getSize());
            $pager->setCollection($this->getCollection());
            $pager->setShowPerPage(true);
            return $pager->toHtml();
        }
        return null;
    }
    /**
     * Return URL for resized Eventtickets Item image
     *
     * @param Wsu_Eventtickets_Model_Eventtickets $item
     * @param integer $width
     * @return string|false
     */
    public function getImageUrl($item, $width) {
        return Mage::helper('wsu_eventtickets/image')->resize($item, $width);
    }
}

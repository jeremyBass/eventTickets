<?php
class Wsu_Eventtickets_Block_Item extends Mage_Core_Block_Template {
    /**
     * Current news item instance
     *
     * @var Wsu_Eventtickets_Model_Eventtickets
     */
    protected $_item;
    /**
     * Return parameters for back url
     *
     * @param array $additionalParams
     * @return array
     */
    protected function _getBackUrlQueryParams($additionalParams = array()) {
        return array_merge(array(
            'p' => $this->getPage()
        ), $additionalParams);
    }
    /**
     * Return URL to the news list page
     *
     * @return string
     */
    public function getBackUrl() {
        return $this->getUrl('*/', array(
            '_query' => $this->_getBackUrlQueryParams()
        ));
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

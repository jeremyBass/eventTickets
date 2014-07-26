<?php
class Wsu_Eventtickets_Model_Eventtickets extends Mage_Core_Model_Abstract {
    /**
     * Define resource model
     */
    protected function _construct(){
        $this->_init('wsu_eventtickets/eventtickets');
    }

    /**
     * If object is new adds creation date
     *
     * @return Wsu_Eventtickets_Model_Eventtickets
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        if ($this->isObjectNew()) {
            $this->setData('created_at', Varien_Date::now());
        }
        return $this;
    }
}

<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_eventTickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_eventTickets_Model_Observer
{
    /**
     * Event before show event item on frontend
     * If specified new post was added recently (term is defined in config) we'll see message about this on front-end.
     *
     * @param Varien_Event_Observer $observer
     */
    public function beforeeventTicketsDisplayed(Varien_Event_Observer $observer)
    {
        $eventticketsItem = $observer->getEvent()->geteventTicketsItem();
        $currentDate = Mage::app()->getLocale()->date();
        $eventticketsCreatedAt = Mage::app()->getLocale()->date(strtotime($eventticketsItem->getCreatedAt()));
        $daysDifference = $currentDate->sub($eventticketsCreatedAt)->getTimestamp() / (60 * 60 * 24);
        /*if ($daysDifference < Mage::helper('wsu_eventtickets')->getDaysDifference()) {
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('wsu_eventtickets')->__('Recently added'));
        }*/
    }
}

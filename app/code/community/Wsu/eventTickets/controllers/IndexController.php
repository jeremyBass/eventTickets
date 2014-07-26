 <?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Pre dispatch action that allows to redirect to no route page in case of disabled extension through admin panel
     */
    public function preDispatch()
    {
        parent::preDispatch();
        
        if (!Mage::helper('wsu_eventtickets')->isEnabled()) {
            $this->setFlag('', 'no-dispatch', true);
            $this->_redirect('noRoute');
        }        
    }
    
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->loadLayout();

        $listBlock = $this->getLayout()->getBlock('eventtickets.list');

        if ($listBlock) {
            $currentPage = abs(intval($this->getRequest()->getParam('p')));
            if ($currentPage < 1) {
                $currentPage = 1;
            }
            $listBlock->setCurrentPage($currentPage);
        }

        $this->renderLayout();
    }

    /**
     * Eventtickets view action
     */
    public function viewAction()
    {
        $eventticketsId = $this->getRequest()->getParam('id');
        if (!$eventticketsId) {
            return $this->_forward('noRoute');
        }

        /** @var $model Wsu_Eventtickets_Model_Eventtickets */
        $model = Mage::getModel('wsu_eventtickets/eventtickets');
        $model->load($eventticketsId);

        if (!$model->getId()) {
            return $this->_forward('noRoute');
        }

        Mage::register('eventtickets_item', $model);
        
        Mage::dispatchEvent('before_eventtickets_item_display', array('eventtickets_item' => $model));

        $this->loadLayout();
        $itemBlock = $this->getLayout()->getBlock('eventtickets.item');
        if ($itemBlock) {
            $listBlock = $this->getLayout()->getBlock('eventtickets.list');
            if ($listBlock) {
                $page = (int)$listBlock->getCurrentPage() ? (int)$listBlock->getCurrentPage() : 1;
            } else {
                $page = 1;
            }
            $itemBlock->setPage($page);
        }
        $this->renderLayout();
    }
}

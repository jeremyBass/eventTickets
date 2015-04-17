<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * Init Grid default properties
     *
     */
    public function __construct() {
        parent::__construct();
                /*$this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);*/
		
        $this->setTemplate('wsu/eventtickets/report/guestreport/grid.phtml');
        $this->setId('eventtickets_list_registrants');
        $this->setPagerVisibility(false);
        //$this->setCountTotals(true);
        $this->setDefaultSort('increment_id');
        $this->setDefaultDir('DESC');
        $this->setDefaultLimit(999999999);
        $this->setSaveParametersInSession(true);
		
		
		
		
    }

    /**
     * Prepare collection for Grid
     *
     * @return Wsu_Eventtickets_Block_Adminhtml_Grid
     */
    protected function _prepareCollection() {
		$id = $this->getRequest()->getParam('id');
        $collection = Mage::helper('wsu_eventtickets')->_findCollection($id);

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }




    protected function _addColumnFilterToCollection($column){
        $filterArr = Mage::registry('preparedFilter');
        /*if (($column->getId() === 'store_id' || $column->getId() === 'status') 
			&& $column->getFilter()->getValue() && strpos($column->getFilter()->getValue(), ',')) {
            $_inNin = explode(',', $column->getFilter()->getValue());
            $inNin = array();
            foreach ($_inNin as $k => $v) {
                if (is_string($v) && strlen(trim($v))) {
                    $inNin[] = trim($v);
                }
            }
            if (count($inNin)>1 && in_array($inNin[0], array('in', 'nin'))) {
                $in = $inNin[0];
                $values = array_slice($inNin, 1);
                $this->getCollection()->addFieldToFilter($column->getId(), array($in => $values));
            } else {
                parent::_addColumnFilterToCollection($column);
            }
        } elseif (is_array($filterArr) && array_key_exists($column->getId(), $filterArr) && isset($filterArr[$column->getId()])) {
            $this->getCollection()->addFieldToFilter($column->getId(), $filterArr[$column->getId()]);
        } else {
            parent::_addColumnFilterToCollection($column);
        }*/
		
		//print((string)$this->getCollection()->getSelect());
		//var_dump($filterArr);
        //Zend_Debug::dump((string)$this->getCollection()->getSelect(), 'Prepared filter:');
		
		/*
		Mage::unregister('dyno_col'); 
		Mage::register('dyno_col', Mage::helper('xreports')->dynoColCallback($this->getCollection()));
		$newCollection = new Varien_Data_Collection();
		$dyno_col=(array)Mage::registry('dyno_col');
		
		foreach($this->getCollection() as $item){
			foreach($dyno_col as $keyed){
				$item->setData("${keyed}",Mage::helper('xreports')->dynoColValue($item,$keyed));
			 }
			 $newCollection->addItem($item);
		}
		
		$this->setCollection($newCollection);
		var_dump($newCollection);
		
		die();*/

        return $this;
    }



    /**
     * Prepare Grid columns
     *
     * @return Mage_Adminhtml_Block_Catalog_Search_Grid
     */
    protected function _prepareColumns()  {
		$_col = $this->getRequest()->getParam('_col');
		$_col = Mage::getSingleton('core/session')->getFilteredCol();
		$post_col = $this->getRequest()->getParam('_col');
		
		$currencyCode = $this->getCurrentCurrencyCode();
		
		if(!empty($post_col)){
			$_col = $post_col;
			Mage::getSingleton('core/session')->setFilteredCol($_col);
		}
		if(!isset($_col)){
			$_col=array();
		}/**/
		

		//*/
		//var_dump($_col);die();
		if(empty($_col) || isset($_col['increment_id'])){
			$this->addColumn('increment_id', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Order #'),
				'index' => 'increment_id',
				'width' => '80',
				'type' => 'text',
				'sortable' => true,
				'totals_label' => Mage::helper('wsu_eventtickets')->__('Total'),
				'html_decorators' => array('nobr')
			));
			//var_dump($this);
			//die('should have added the increment_id col');
		}
		if(empty($_col) || isset($_col['sku'])){
			$this->addColumn('sku', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Sku'),
				'align' => 'left',
				'index' => 'sku',
				'type' => 'text',
				'width' => '200',
				'renderer' => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Sku',
				'sortable' => true
			));
		}
		if(empty($_col) || isset($_col['name'])){
			$this->addColumn('name', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Name'),
				'align' => 'left',
				'index' => 'name',
				'type' => 'text',
				'width' => '200',
				'renderer' => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Productname',
				'sortable' => true
			));
		}		
		if(empty($_col) || isset($_col['customer_firstname'])){
			$this->addColumn('customer_firstname', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Customer first name'),
				'align' => 'left',
				'width' => '250',
				'index' => 'customer_firstname',
				'type' => 'text',
				'sortable' => true
			));
		}
		if(empty($_col) || isset($_col['customer_lastname'])){
			$this->addColumn('customer_lastname', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Customer last name'),
				'align' => 'left',
				'width' => '250',
				'index' => 'customer_lastname',
				'type' => 'text',
				'sortable' => true
			));
		}
		if(empty($_col) || isset($_col['total_qty_ordered'])){
			$this->addColumn('total_qty_ordered', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Qty. Ordered'),
				'align' => 'left',
				'index' => 'total_qty_ordered',
				'type' => 'number',
				'total' => 'sum',
				'sortable' => true,
				'renderer'          => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Qtyordered',
			));
		}
		$dyno_col=(array)Mage::registry('dyno_col');
		foreach($dyno_col as $keyed){
			$this->addColumn("option_${keyed}", array(
				'header' => Mage::helper('wsu_eventtickets')->__('Option').' '.str_replace('_',' ',$keyed),
				'index' => "${keyed}",
				'type' => 'text',
				'width' => '100',
				'sortable' => true,
				'filter' => false,
				'renderer' => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Option'
			));	
		}
		
		
		
		if(empty($_col) || isset($_col['created_at'])){
			$this->addColumn('created_at', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Order Date'),
				'index' => 'main_table.created_at',
				'type' => 'datetime',
				'width' => '100',
				'sortable' => true,
				'renderer' => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Createdat',
				'filter_condition_callback' => array($this, '_fromFilter'),
			));
		}
		
		if(empty($_col) || isset($_col['status'])){
			$this->addColumn('status', array(
				'header' => Mage::helper('sales')->__('Status'),
				'index' => 'status',
				'type' => 'options',
				'width' => '70px',
				'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
			));
		}
		

		if(empty($_col) || isset($_col['dyno_options'])){
			$this->addColumn('dyno_options', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Item options'),
				'align' => 'left',
				'width' => '250',
				'index' => 'increment_id',
				'type' => 'text',
				'renderer' => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Item',
				'sortable' => true
			));
		}

		
		if(empty($_col) || isset($_col['qty_invoiced'])){
			$this->addColumn('qty_invoiced', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Qty. Invoiced'),
				'align' => 'left',
				'index' => 'qty_invoiced',
				'type' => 'number',
				'total' => 'sum',
				'sortable' => true,
				'renderer'          => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Qtyinvoiced',
			));
		}
		
		if(empty($_col) || isset($_col['qty_shipped'])){
			$this->addColumn('qty_shipped', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Qty. Shipped'),
				'align' => 'left',
				'index' => 'qty_shipped',
				'type' => 'number',
				'total' => 'sum',
				'sortable' => true,
				'renderer'          => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Qtyshipped',
			));
		}
		
		if(empty($_col) || isset($_col['qty_refunded'])){
			$this->addColumn('qty_refunded', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Qty. Refunded'),
				'align' => 'left',
				'index' => 'qty_refunded',
				'type' => 'number',
				'total' => 'sum',
				'sortable' => true,
				'renderer'          => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Qtyrefunded',
			));
		}
		
		if(empty($_col) || isset($_col['subtotal'])){
			$this->addColumn('subtotal', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Subtotal'),
				'align' => 'right',
				'index' => 'subtotal',
				'currency_code' => $currencyCode,
				'width' => '100px',
				'type' => 'currency',
				'total' => 'sum',
				'sortable' => true
			));
		}
		
				
		if(empty($_col) || isset($_col['customer_email'])){
			$this->addColumn('customer_email', array(
				'header' => Mage::helper('wsu_eventtickets')->__('Customer Email'),
				'align' => 'left',
				'width' => '250',
				'index' => 'customer_email',
				'type' => 'text',
				'sortable' => true
			));
		}
        $this->addColumn('edit',
            array(
                'header'    => Mage::helper('wsu_eventtickets')->__('Edit'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'    => 'getId',
                'filter'    => false,
                'sortable'  => false,
				'renderer'  => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Renderer_Saleedit',
                'index'     => 'news',
        ));
		//$this->addExportType('*/*/exportCsvEnhanced', Mage::helper('wsu_eventtickets')->__('Guest List'));
        $this->addExportType('*/*/exportGuestReportCsv', Mage::helper('wsu_eventtickets')->__('CSV'));
        //$this->addExportType('*/*/exportGuestReportExcel', Mage::helper('wsu_eventtickets')->__('Excel XML'));

        //return parent::_prepareColumns();
    }

    /**
     * Return row URL for js event handlers
     *
     * @return string
     */
    //public function getRowUrl($row) {
    //    return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
    //}

    /**
     * Grid url getter
     *
     * @return string current grid url
     */
    //public function getGridUrl() {
    //    return $this->getUrl('*/*/registrants', array('_current' => true));
    //}
	public function getCurrentCurrencyCode() {
        return Mage::app()->getStore()->getBaseCurrencyCode();
    }
	protected function _fromFilter($collection, $column) {
        /* if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
		
		var_dump($value);
		
		
		if(isset($value['from'])){
        	//$this->getCollection()->getSelect()->where( "main_table.created_at >= ?" , $value['from']->toString('Y-m-d H:i:s') );
		}
		
		
		Format our dates */

		
		
		
		
		
        return $this;
    }


}

<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * Init Grid default properties
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId('eventtickets_list_grid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare collection for Grid
     *
     * @return Wsu_Eventtickets_Block_Adminhtml_Grid
     */
    protected function _prepareCollection() {
        $collection = Mage::getResourceModel('catalog/product_collection')
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('type_id', Wsu_eventTickets_Model_Product_Type::TYPE_CP_PRODUCT);//Mage::getModel('wsu_eventtickets/eventtickets')->getResourceCollection();
		//echo "<pre>";var_dump($collection);echo "</pre>";

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare Grid columns
     *
     * @return Mage_Adminhtml_Block_Catalog_Search_Grid
     */
    protected function _prepareColumns()  {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('wsu_eventtickets')->__('ID #'),
            'width'     => '50px',
            'index'     => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('wsu_eventtickets')->__('Title'),
            'index'     => 'name',
        ));

		$this->addColumn('event_start_date', array(
            'header'    => Mage::helper('wsu_eventtickets')->__('Starting on'),
            'sortable' => true,
            'width'    => '170px',
            'index'     => 'event_start_date',
            'type'     => 'date',
        ));

        $this->addColumn('location', array(
            'header'    => Mage::helper('wsu_eventtickets')->__('Location'),
            'index'     => 'location',
        ));

        $this->addColumn('registration_closes', array(
            'header'   => Mage::helper('wsu_eventtickets')->__('reg closes on'),
            'sortable' => true,
            'width'    => '170px',
            'index'    => 'registration_closes',
            'type'     => 'date',
        ));

        $this->addColumn('created_at', array(
            'header'   => Mage::helper('wsu_eventtickets')->__('Created'),
            'sortable' => true,
            'width'    => '170px',
            'index'    => 'created_at',
            'type'     => 'datetime',
        ));
        $this->addColumn('preview',
            array(
                'header'    => Mage::helper('wsu_eventtickets')->__('Preview'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'    => 'getId',
                'filter'    => false,
                'sortable'  => false,
				'renderer'  => 'Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Registrants_Renderer_Preview',
                'index'     => 'news',
        ));
        $this->addColumn('registered',
            array(
                'header'    => Mage::helper('wsu_eventtickets')->__('Registrants'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(array(
                    'caption' => Mage::helper('wsu_eventtickets')->__('Get list'),//<i class="fa fa-user-times"></i>
                    'url'     => array('base' => '*/*/registrants'),
                    'field'   => 'id'
                )),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'news',
        ));
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('wsu_eventtickets')->__('Action'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(array(
                    'caption' => Mage::helper('wsu_eventtickets')->__('Edit'),
                    'url'     => array('base' => '*/*/edit'),
                    'field'   => 'id'
                )),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'news',
        ));

        return parent::_prepareColumns();
    }

    /**
     * Return row URL for js event handlers
     *
     * @return string
     */
    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * Grid url getter
     *
     * @return string current grid url
     */
    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}

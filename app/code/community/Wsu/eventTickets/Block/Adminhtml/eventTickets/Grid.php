<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_eventTickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */
class Wsu_eventTickets_Block_Adminhtml_eventTickets_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Init Grid default properties
     *
     */
    public function __construct()
    {
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
     * @return Wsu_eventTickets_Block_Adminhtml_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('wsu_eventtickets/eventtickets')->getResourceCollection();
		//echo "<pre>";var_dump($collection);echo "</pre>";

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare Grid columns
     *
     * @return Mage_Adminhtml_Block_Catalog_Search_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('eventtickets_id', array(
            'header'    => Mage::helper('wsu_eventtickets')->__('ID #'),
            'width'     => '50px',
            'index'     => 'eventtickets_id',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('wsu_eventtickets')->__('Title'),
            'index'     => 'title',
        ));
		
		/*$this->addColumn('details', array(
            'header'    => Mage::helper('wsu_eventtickets')->__('Details'),
            'index'     => 'details',
        ));*/
		$this->addColumn('entry_fee', array(
            'header'    => Mage::helper('wsu_eventtickets')->__('Entry Fee'),
            'index'     => 'entry_fee',
        ));

        $this->addColumn('venue', array(
            'header'    => Mage::helper('wsu_eventtickets')->__('Venue'),
            'index'     => 'venue',
        ));

        $this->addColumn('published_at', array(
            'header'   => Mage::helper('wsu_eventtickets')->__('Published On'),
            'sortable' => true,
            'width'    => '170px',
            'index'    => 'published_at',
            'type'     => 'date',
        ));

        $this->addColumn('created_at', array(
            'header'   => Mage::helper('wsu_eventtickets')->__('Created'),
            'sortable' => true,
            'width'    => '170px',
            'index'    => 'created_at',
            'type'     => 'datetime',
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
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * Grid url getter
     *
     * @return string current grid url
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}

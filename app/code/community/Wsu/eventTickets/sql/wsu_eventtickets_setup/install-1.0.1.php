<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_eventTickets 
 * @author    Jeremy Bass <jeremy.bass@wsu.edu>
 * @license   MIT/GPL
 * @link N/A 
 */

/**
 * @var $installer Mage_Core_Model_Resource_Setup
 */
$installer = $this;

/**
 * Creating table wsu_eventtickets
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('wsu_eventtickets/eventtickets'))
    ->addColumn('eventtickets_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'identity' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Entity id')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
    ), 'Title')
	 ->addColumn('details', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
        'default'  => null,
    ), 'Details')
    ->addColumn('venue', Varien_Db_Ddl_Table::TYPE_TEXT, 63, array(
        'nullable' => true,
        'default'  => null,
    ), 'Venue')
	->addColumn('eligibility', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
        'default'  => null,
    ), 'Eligibility')
    ->addColumn('entry_fee', Varien_Db_Ddl_Table::TYPE_INTEGER, 100, array(
        'nullable' => true,
        'default'  => null,
    ), 'Entry Fee')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
        'default'  => null,
    ), 'eventTickets image media path')
    ->addColumn('published_at', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        'nullable' => true,
        'default'  => null,
    ), 'World publish date')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => true,
        'default'  => null,
    ), 'Creation Time')
    ->addIndex($installer->getIdxName(
            $installer->getTable('wsu_eventtickets/eventtickets'),
            array('published_at'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
        ),
        array('published_at'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
    )
    ->setComment('Event item');

$installer->getConnection()->createTable($table);

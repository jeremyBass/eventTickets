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
$installer->startSetup();

/*

if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'attribute_name')) {
    $installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'attribute_name', array(         // TABLE.COLUMN:                                       DESCRIPTION:
        'label'                      => 'Label',                                                  // eav_attribute.frontend_label                        admin input label
        'group'                      => 'General',                                                // (not a column)                                      tab in product edit screen
        'sort_order'                 => 0  ,                                                       // eav_entity_attribute.sort_order                     sort order in group
        'backend'                    => 'module/class_name',                                      // eav_attribute.backend_model                         backend class (module/class_name format)
        'type'                       => 'varchar',                                                // eav_attribute.backend_type                          backend storage type (varchar, text etc)
        'frontend'                   => 'module/class_name',                                      // eav_attribute.frontend_model                        admin class (module/class_name format)
        'note'                       => null,                                                     // eav_attribute.note                                  admin input note (shows below input)
        'default'                    => null,                                                     // eav_attribute.default_value                         admin input default value
        'wysiwyg_enabled'            => false,                                                    // catalog_eav_attribute.is_wysiwyg_enabled            (products only) admin input wysiwyg enabled
        'input'                      => 'input_name',                                             // eav_attribute.frontend_input                        admin input type (select, text, textarea etc)
        'input_renderer'             => 'module/class_name',                                      // catalog_eav_attribute.frontend_input_renderer       (products only) admin input renderer (otherwise input is used to resolve renderer)
        'source'                     => null,                                                     // eav_attribute.source_model                          admin input source model (for selects) (module/class_name format)
        'required'                   => true,                                                     // eav_attribute.is_required                           required in admin
        'user_defined'               => false,                                                    // eav_attribute.is_user_defined                       editable in admin attributes section, false for not
        'unique'                     => false,                                                    // eav_attribute.is_unique                             unique value required
        'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,  // catalog_eav_attribute.is_global                     (products only) scope
        'visible'                    => true,                                                     // catalog_eav_attribute.is_visible                    (products only) visible on admin
        'visible_on_front'           => false,                                                    // catalog_eav_attribute.is_visible_on_front           (products only) visible on frontend (store) attribute table
        'used_in_product_listing'    => false,                                                    // catalog_eav_attribute.used_in_product_listing       (products only) made available in product listing
        'searchable'                 => false,                                                    // catalog_eav_attribute.is_searchable                 (products only) searchable via basic search
        'visible_in_advanced_search' => false,                                                    // catalog_eav_attribute.is_visible_in_advanced_search (products only) searchable via advanced search
        'filterable'                 => false,                                                    // catalog_eav_attribute.is_filterable                 (products only) use in layered nav
        'filterable_in_search'       => false,                                                    // catalog_eav_attribute.is_filterable_in_search       (products only) use in search results layered nav
        'comparable'                 => false,                                                    // catalog_eav_attribute.is_comparable                 (products only) comparable on frontend
        'is_html_allowed_on_front'   => true,                                                     // catalog_eav_attribute.is_visible_on_front           (products only) seems obvious, but also see visible
        'apply_to'                   => 'simple,configurable',                                    // catalog_eav_attribute.apply_to                      (products only) which product types to apply to
        'is_configurable'            => false,                                                    // catalog_eav_attribute.is_configurable               (products only) used for configurable products or not
        'used_for_sort_by'           => false,                                                    // catalog_eav_attribute.used_for_sort_by              (products only) available in the 'sort by' menu
        'position'                   => 0,                                                        // catalog_eav_attribute.position                      (products only) position in layered naviagtion
        'used_for_promo_rules'       => false,                                                    // catalog_eav_attribute.is_used_for_promo_rules       (products only) available for use in promo rules
    ));
}
*/





/**
 * Creating table wsu_eventtickets
 */
 $table_eventtickets = $installer->getTable('wsu_eventtickets/eventtickets');
$installer->run("
	DROP TABLE IF EXISTS `{$table_eventtickets}`;
	CREATE TABLE `{$table_eventtickets}` (
		`eventtickets_id` int(10) NOT NULL AUTO_INCREMENT,
		`title` varchar(255) NULL,
		`details` text NULL,
		`venue` text NULL,
		`eligibility` text NULL,
		`entry_fee` varchar(255) NOT NULL DEFAULT '0.0.0.0',
		`image` text NULL,
		`published_at` timestamp,
		`created_at` timestamp,
		`reported_at` timestamp,
		`updated_at` timestamp,
	  PRIMARY KEY (`eventtickets_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");
 
/* $connection = $this->getConnection();
$connection->addColumn($this->getTable('wsu_eventtickets/eventtickets'), "spam","TINYINT(1) UNSIGNED DEFAULT 0");
 
 
$table = $installer->getConnection()
    ->newTable($installer->getTable('wsu_eventtickets/eventtickets'))->addIndex($installer->getIdxName(
            $installer->getTable('wsu_eventtickets/eventtickets'),
            array('published_at'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
        ),
        array('published_at'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
    )
    ->setComment('Event item');

$installer->getConnection()->createTable($table);


$installer->addAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'affiliate_link',
    array(
        'type'                    => 'text',
        'backend'                 => '',
        'frontend'                => '',
        'label'                   => 'Affiliate Link',
        'input'                   => 'text',
        'class'                   => '',
        'source'                  => '',
        'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible'                 => true,
        'required'                => true,
        'user_defined'            => false,
        'default'                 => '',
        'searchable'              => false,
        'filterable'              => false,
        'comparable'              => false,
        'visible_on_front'        => false,
        'unique'                  => false,
        'apply_to'                => 'event',
        'is_configurable'         => false,
        'used_in_product_listing' => false
    )
);
*/
	$fieldList = array(
		'price',
		'special_price',
		'special_from_date',
		'special_to_date',
		'minimal_price',
		'cost',
		'tier_price',
		'weight',
		'tax_class_id'
	);

	// make these attributes applicable to downloadable products
	foreach ($fieldList as $field) {
		$applyTo = explode(',',$installer->getAttribute('catalog_product', $field, 'apply_to'));
		if (!in_array('event', $applyTo)) {
			$applyTo[] = 'event';
			$installer->updateAttribute('catalog_product', $field, 'apply_to', join(',', $applyTo));
		}
	}
/*
	$installer->addAttribute(
		Mage_Catalog_Model_Product::ENTITY,
		'product_type', array(
			'group'             => 'Product Options',
			'label'             => 'Product Type',
			'note'              => '',
			'type'              => 'int',    //backend_type
			'input'             => 'select', //frontend_input
			'frontend_class'    => '',
			'source'            => 'wsu_eventtickets/attribute_source_type',
			'backend'           => '',
			'frontend'          => '',
			'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
			'required'          => true,
			'visible_on_front'  => false,
			'apply_to'          => 'simple',
			'is_configurable'   => false,
			'used_in_product_listing'   => false,
			'sort_order'        => 5,
    ));
*/

$SU_helper = Mage::helper('storeutilities/utilities');


$defaultAttrSetId = Mage::getModel('catalog/product')->getDefaultAttributeSetId();




$SportingAttrSetInfo = $SU_helper->createAttributeSet("Sporting Events",
	$defaultAttrSetId,
	array('Gift Options','Recurring Profile'),
	array('enable_googlecheckout','weight','country_of_manufacture','manufacturer','color','msrp_enabled','msrp_display_actual_price_type','msrp')
); 



$EntertainmentSetInfo = $SU_helper->createAttributeSet("Entertainment Events",
	$defaultAttrSetId,
	array('Gift Options','Recurring Profile'),
	array('enable_googlecheckout','weight','country_of_manufacture','manufacturer','color','msrp_enabled','msrp_display_actual_price_type','msrp')
);


if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'event_start_date_time')) {
	 $installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'event_start_date_time', array(
		 'input'         => 'datetime',
		 'type'          => 'datetime',
		 'time'          => true,
		 'label'         => 'Date & Time',
		 'input_renderer'=> 'wsu_eventtickets/adminhtml_renderer_attribute_datetime',
		 'visible'       => true,
		 'required'      => false,
		 'user_defined'  => true,
		 'visible_on_front' => true,
		 'backend'       => 'eav/entity_attribute_backend_time_created',
		 'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL
	 ));
}

if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'event_end_date_time')) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'event_end_date_time', array(
		'input'         => 'datetime',
		'type'          => 'datetime',
		'time'          => true,
		'label'         => 'Date & Time',
		'input_renderer'=> 'wsu_eventtickets/adminhtml_renderer_attribute_datetime',
		'visible'       => true,
		'required'      => false,
		'user_defined'  => true,
		'visible_on_front' => true,
		'backend'       => 'eav/entity_attribute_backend_time_created',
		'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL
	));
}
 
if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'guest_limit')) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'guest_limit', array(
		'attribute_model' => NULL,
		'backend'       => 'eav/entity_attribute_backend_array',
		'type'          => 'int',
		'table'         => '',
		'frontend'      => '',
		'input'         => 'select',
		'label'         => 'Date & Time',
		'input_renderer'=> 'wsu_eventtickets/adminhtml_renderer_attribute_datetime',
		'visible'       => true,
		'required'      => false,
		'user_defined'  => true,
		'visible_on_front' => true,
		'backend'       => 'eav/entity_attribute_backend_time_created',
		'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'option'        =>  array ( 'values' => 
								array (
									0 => 'unlimited',
									1 => '1',
									2 => '2',
									3 => '3',
									4 => '4',
									5 => '5',
									6 => '6',
									7 => '7',
									8 => '8',
									9 => '9',
									10 => '10',
								),
							),
	));
}
 
if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'allow_guests')) {
	$installer->addAttribute('catalog_product', 'allow_guests', array(
			'input'                     => 'select',
			'type'                      => 'int',
			'label'                     => 'Allow Guests',
			'source'                    => 'eav/entity_attribute_source_boolean',
			'global'                    => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible'                   => 1,
			'required'                  => 0,
			'visible_on_front'          => 0,
			'is_html_allowed_on_front'  => 0,
			'is_configurable'           => 0,
			'searchable'                => 0,
			'filterable'                => 0,
			'comparable'                => 0,
			'unique'                    => false,
			'user_defined'              => false,
			'default'					=> '',
			'is_user_defined'           => false,
			'used_in_product_listing'   => true
	));
}






				 
$allEventSets = array($SportingAttrSetInfo,$EntertainmentSetInfo);			 

			 
$SU_helper->createAttribute("Event start date","eventstartdate", array(
		'is_global'                     => '0',
		'frontend_input'                => 'date',
		'default_value_text'            => '',
		'default_value_yesno'           => '0',
		'default_value_date'            => '',
		'default_value_textarea'        => '',
		'is_unique'                     => '0',
		'is_required'                   => '0',
		'frontend_class'                => '',
		'is_searchable'                 => '1',
		'is_visible_in_advanced_search' => '1',
		'is_comparable'                 => '0',
		'is_used_for_promo_rules'       => '0',
		'is_html_allowed_on_front'      => '1',
		'is_visible_on_front'           => '0',
		'used_in_product_listing'       => '1',
		'used_for_sort_by'              => '1',
		'is_configurable'               => '0',
		'is_filterable'                 => '0',
		'is_filterable_in_search'       => '0',
		'backend_type'                  => 'datetime',
		'default_value'                 => ''
	),array("event"), $allEventSets);
	
$SU_helper->createAttribute("Event start time","eventstarttime", array(
		'is_global'                     => '0',
		'frontend_input'                => 'time',
		'default_value_text'            => '',
		'default_value_yesno'           => '0',
		'default_value_date'            => '',
		'default_value_textarea'        => '',
		'is_unique'                     => '0',
		'is_required'                   => '0',
		'frontend_class'                => '',
		'is_searchable'                 => '1',
		'is_visible_in_advanced_search' => '1',
		'is_comparable'                 => '0',
		'is_used_for_promo_rules'       => '0',
		'is_html_allowed_on_front'      => '1',
		'is_visible_on_front'           => '0',
		'used_in_product_listing'       => '1',
		'used_for_sort_by'              => '1',
		'is_configurable'               => '0',
		'is_filterable'                 => '0',
		'is_filterable_in_search'       => '0',
		'backend_type'                  => 'datetime',
		'default_value'                 => ''
	),array("event"), $allEventSets);

$SU_helper->createAttribute("Event end date","eventenddate", array(
		'is_global'                     => '0',
		'frontend_input'                => 'date',
		'default_value_text'            => '',
		'default_value_yesno'           => '0',
		'default_value_date'            => '',
		'default_value_textarea'        => '',
		'is_unique'                     => '0',
		'is_required'                   => '0',
		'frontend_class'                => '',
		'is_searchable'                 => '1',
		'is_visible_in_advanced_search' => '1',
		'is_comparable'                 => '0',
		'is_used_for_promo_rules'       => '0',
		'is_html_allowed_on_front'      => '1',
		'is_visible_on_front'           => '0',
		'used_in_product_listing'       => '0',
		'used_for_sort_by'              => '1',
		'is_configurable'               => '0',
		'is_filterable'                 => '0',
		'is_filterable_in_search'       => '0',
		'backend_type'                  => 'datetime',
		'default_value'                 => ''
	),array("event"), $allEventSets);

$SU_helper->createAttribute("Event end time","eventendtime", array(
		'is_global'                     => '0',
		'frontend_input'                => 'time',
		'default_value_text'            => '',
		'default_value_yesno'           => '0',
		'default_value_date'            => '',
		'default_value_textarea'        => '',
		'is_unique'                     => '0',
		'is_required'                   => '0',
		'frontend_class'                => '',
		'is_searchable'                 => '1',
		'is_visible_in_advanced_search' => '1',
		'is_comparable'                 => '0',
		'is_used_for_promo_rules'       => '0',
		'is_html_allowed_on_front'      => '1',
		'is_visible_on_front'           => '0',
		'used_in_product_listing'       => '0',
		'used_for_sort_by'              => '1',
		'is_configurable'               => '0',
		'is_filterable'                 => '0',
		'is_filterable_in_search'       => '0',
		'backend_type'                  => 'datetime',
		'default_value'                 => ''
	),array("event"), $allEventSets);

Mage::helper('storeutilities/utilities')->createAttribute("Location","location", array(
		'is_global'                     => '0',
		'frontend_input'                => 'text',
		'default_value_text'            => '',
		'default_value_yesno'           => '0',
		'default_value_date'            => '',
		'default_value_textarea'        => '',
		'is_unique'                     => '0',
		'is_required'                   => '0',
		'frontend_class'                => '',
		'is_searchable'                 => '1',
		'is_visible_in_advanced_search' => '1',
		'is_comparable'                 => '0',
		'is_used_for_promo_rules'       => '0',
		'is_html_allowed_on_front'      => '1',
		'is_visible_on_front'           => '0',
		'used_in_product_listing'       => '0',
		'used_for_sort_by'              => '1',
		'is_configurable'               => '0',
		'is_filterable'                 => '0',
		'is_filterable_in_search'       => '0',
		'backend_type'                  => 'text',
		'default_value'                 => ''
	),array("event"), $allEventSets);

Mage::helper('storeutilities/utilities')->createAttribute("Opponent","opponent", array(
		'is_global'                     => '0',
		'frontend_input'                => 'text',
		'default_value_text'            => '',
		'default_value_yesno'           => '0',
		'default_value_date'            => '',
		'default_value_textarea'        => '',
		'is_unique'                     => '0',
		'is_required'                   => '0',
		'frontend_class'                => '',
		'is_searchable'                 => '1',
		'is_visible_in_advanced_search' => '1',
		'is_comparable'                 => '0',
		'is_used_for_promo_rules'       => '0',
		'is_html_allowed_on_front'      => '1',
		'is_visible_on_front'           => '0',
		'used_in_product_listing'       => '0',
		'used_for_sort_by'              => '1',
		'is_configurable'               => '0',
		'is_filterable'                 => '0',
		'is_filterable_in_search'       => '0',
		'backend_type'                  => 'text',
		'default_value'                 => ''
	),array("event"), $SportingAttrSetInfo);

Mage::helper('storeutilities/utilities')->createAttribute("Away Game","awaygame", array(
		'is_global'                     => '0',
		'frontend_input'                => 'boolean',
		'default_value_text'            => '',
		'default_value_yesno'           => '0',
		'default_value_date'            => '',
		'default_value_textarea'        => '',
		'is_unique'                     => '0',
		'is_required'                   => '0',
		'frontend_class'                => '',
		'is_searchable'                 => '1',
		'is_visible_in_advanced_search' => '1',
		'is_comparable'                 => '0',
		'is_used_for_promo_rules'       => '0',
		'is_html_allowed_on_front'      => '1',
		'is_visible_on_front'           => '0',
		'used_in_product_listing'       => '1',
		'used_for_sort_by'              => '1',
		'is_configurable'               => '0',
		'is_filterable'                 => '0',
		'is_filterable_in_search'       => '0',
		'backend_type'                  => 'int',
		'default_value'                 => ''
	),array("event"), $SportingAttrSetInfo);			
	
























/* http://schema.org/Place
$table_venues = $installer->getTable('wsu_events_venue');
$installer->run("
    DROP TABLE IF EXISTS `{$table_venues}`;
    CREATE TABLE `{$table_venues}` (
	`venue_id` int(10) NOT NULL AUTO_INCREMENT,
	`updated_at` timestamp,
	`name` varchar(255) NULL,
	`description` text NULL,
	`sameAs` varchar(255) NULL,
	`capacity`  int(10) NOT NULL DEFAULT '1',
	`address` text NULL,
	`telephone` varchar(255) NULL,
	`faxNumber` varchar(255) NULL,
	`geo` text NULL,
	`globalLocationNumber` varchar(255) NULL,
	`isicV4` varchar(255) NULL,
	`logo` varchar(255) NULL,
	`map` varchar(255) NULL,
	PRIMARY KEY (`spamlog_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
");








$installer->addAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'affiliate_link',
    array(
        'type'                    => 'text',
        'backend'                 => '',
        'frontend'                => '',
        'label'                   => 'Affiliate Link',
        'input'                   => 'text',
        'class'                   => '',
        'source'                  => '',
        'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible'                 => true,
        'required'                => true,
        'user_defined'            => false,
        'default'                 => '',
        'searchable'              => false,
        'filterable'              => false,
        'comparable'              => false,
        'visible_on_front'        => false,
        'unique'                  => false,
        'apply_to'                => 'event',
        'is_configurable'         => false,
        'used_in_product_listing' => false
    )
);





 */



<?php
/* 
 * @category  Event Manager Module
 * @package   Wsu_Eventtickets 
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

$entityTypeID = Mage::getModel('catalog/product')->getResource()->getTypeId();
$defaultAttrSetId = $installer->getDefaultAttributeSetId($entityTypeID);

$SportingAttrSetInfo=null;
$attributeSetName="Sporting Events";
$attribute_set = new Varien_Object($installer->getAttributeSet($entityTypeID , $attributeSetName));
$attribute_set_id = $attribute_set->getAttributeSetId();//Mage::getModel('eav/entity_setup','core_setup')->getAttributeSetId('catalog_product',$attributeSetName);	
if($attribute_set_id<=0){
	$SportingAttrSetInfo = $SU_helper->createAttributeSet($attributeSetName,
		$defaultAttrSetId,
		array('Gift Options','Recurring Profile'),
		array('enable_googlecheckout','weight','country_of_manufacture','manufacturer','color','msrp_enabled','msrp_display_actual_price_type','msrp')
	); 
}else{
	$groupID= $SU_helper->getAttributeGroupId($attributeSetName,"Event Details");
	$SportingAttrSetInfo=array( 'SetID' => $attribute_set_id, 'GroupID' => $groupID, );
}



$EntertainmentSetInfo=null;
$attributeSetName="Entertainment Events";
$attribute_set = new Varien_Object($installer->getAttributeSet($entityTypeID , $attributeSetName));
$attribute_set_id = $attribute_set->getAttributeSetId();//Mage::getModel('eav/entity_setup','core_setup')->getAttributeSetId('catalog_product',$attributeSetName);	
if($attribute_set_id<=0){
	$EntertainmentSetInfo = $SU_helper->createAttributeSet($attributeSetName,
		$defaultAttrSetId,
		array('Gift Options','Recurring Profile'),
		array('enable_googlecheckout','weight','country_of_manufacture','manufacturer','color','msrp_enabled','msrp_display_actual_price_type','msrp')
	);
}else{
	$groupID = $SU_helper->getAttributeGroupId($attributeSetName,"Event Details");
	$EntertainmentSetInfo=array( 'SetID'  => $attribute_set_id, 'GroupID' => $groupID, );
}

/*
if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'event_start_time')) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'event_start_time', array(
		'input'         => 'datetime',
		'type'          => 'datetime',
		'time'          => true,
		'label'         => 'Start Time',
		'input_renderer'=> 'wsu_eventtickets/adminhtml_renderer_attribute_datetime',
		'visible'       => true,
		'required'      => false,
		'user_defined'  => true,
		'visible_on_front' => true,
		'backend'       => 'eav/entity_attribute_backend_time_created',
		'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL
	));
}

if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'event_end_date')) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'event_end_date', array(
		'input'         => 'datetime',
		'type'          => 'datetime',
		'time'          => true,
		'label'         => 'End date',
		'input_renderer'=> 'wsu_eventtickets/adminhtml_renderer_attribute_datetime',
		'visible'       => true,
		'required'      => false,
		'user_defined'  => true,
		'visible_on_front' => true,
		'backend'       => 'eav/entity_attribute_backend_time_created',
		'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL
	));
}


if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'event_end_time')) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'event_end_time', array(
		'input'         => 'datetime',
		'type'          => 'datetime',
		'time'          => true,
		'label'         => 'End Time',
		'input_renderer'=> 'wsu_eventtickets/adminhtml_renderer_attribute_datetime',
		'visible'       => true,
		'required'      => false,
		'user_defined'  => true,
		'visible_on_front' => true,
		'backend'       => 'eav/entity_attribute_backend_time_created',
		'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL
	));
}
*/
/*
	'event_start_date' =>$data['product']['event_start_date'],
	'event_start_time' =>$data['product']['event_start_time'],
	'event_end_date' =>$data['product']['event_end_date'],
	'event_end_time' =>$data['product']['event_end_time'],
	'registration_closed' =>$data['product']['registration_closed'],
	'registration_closed_time' =>$data['product']['registration_closed_time'],
	'has_access_validation' =>$data['product']['has_access_validation'],
	'access_code' =>$data['product']['access_code'],
*/

 
if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'guest_limit')) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'guest_limit', array(
		'attribute_model' => NULL,
		'backend'       => 'eav/entity_attribute_backend_array',
		'type'          => 'int',
		'table'         => '',
		'frontend'      => '',
		'input'         => 'select',
		'label'         => 'Guest Limit',
		//'input_renderer'=> 'wsu_eventtickets/adminhtml_renderer_attribute_datetime',
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
 
$allEventSets = array($SportingAttrSetInfo,$EntertainmentSetInfo);			 

$yes_no_inputs = array(
	'has_access_validation'=>'Has access validation',
	'allow_guests'=>'Allow Guests',
	'food_options'=>'has a food option',
	'request_seating'=>'Able to make seating request',
	'custom_accommodation_response'=>'Allow custom responses',
	'custom_accommodation_response'=>'Allow custom responses',
	'has_sales_limit'=>'Limit sales per order',
	'collect_guest_info'=>'Collect Guest info'
	);

foreach($yes_no_inputs as $key=>$name){
	if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $key)) {
		$SU_helper->createAttribute($name,$key, array(
			'is_global'                     => '1',
			'frontend_input'                => 'boolean',
			'source_model'					=> 'eav/entity_attribute_source_boolean',
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
			'backend_type'                  => 'int',
			'default_value'                 => ''
		),array("event"), $allEventSets);
	}
}

if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'event_relative_end_time')) {	
	$SU_helper->createAttribute("Relative start time","event_relative_start_time", array(
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
}


$date_inputs = array(
	'event_start_date'=>'Event start date',
	'event_end_date'=>'Event end date',
	'registration_closes_date'=>'Registration end Date'
	);

foreach($date_inputs as $key=>$name){
	if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $key)) {			 
		$SU_helper->createAttribute($name,$key, array(
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
	}
}

$time_inputs = array(
	//'event_start_time'=>'Event start time',
	//'event_end_time'=>'Event end time',
	//'registration_closes_time'=>'Registration end time'
	);

foreach($time_inputs as $key=>$name){
	if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $key)) {		
		$SU_helper->createAttribute($name,$key, array(
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
	}
}


$text_inputs = array(
	'location_name'=>'Location Name',
	'location_street'=>'Street Address',
	'location_city'=>'City',
	'location_state'=>'State',
	'location_zip'=>'Zip',
	'location_lat'=>'Latitude',
	'location_long'=>'Longitude',
	'location_url'=>'Url'
);

foreach($text_inputs as $key=>$name){
	if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $key)) {			 
		$SU_helper->createAttribute($name,$key, array(
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
	}
}

if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'opponent')) {	
	$SU_helper->createAttribute("Opponent","opponent", array(
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
}

if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'awaygame')) {	
	$SU_helper->createAttribute("Away Game","awaygame", array(
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
}





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



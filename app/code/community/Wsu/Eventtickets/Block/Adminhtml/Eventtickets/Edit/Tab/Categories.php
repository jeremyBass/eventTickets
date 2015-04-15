<?php
class Wsu_Eventtickets_Block_Adminhtml_Eventtickets_Edit_Tab_Categories extends Mage_Adminhtml_Block_Catalog_Category_Tree implements Mage_Adminhtml_Block_Widget_Tab_Interface  {
    protected $_categoryIds = null;
    protected $_selectedNodes = null;
    public function __construct() {
        parent::__construct();
        $this->setTemplate('wsu/eventtickets/product/edit/tab/categories.phtml');
        $this->_withProductCount = false;
    }
	
    /**
     * Prepare form elements for tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {


        Mage::dispatchEvent('adminhtml_eventtickets_edit_tab_categories_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()  {
        return Mage::helper('wsu_eventtickets')->__('Categories');
    }
	

    /**
     * Prepare url for tab
     *
     * @return string
     */
    public function getTabUrl()  {
        return $this->getUrl('*/*/categories', array('_current' => true));
    }

    /**
     * Prepare url for tab
     *
     * @return string
     */
    public function getTabClass()  {
        return 'ajax';
    }	

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('wsu_eventtickets')->__('Associated categories');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab() {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden() {
        return false;
    }
	
	
	
    public function getProduct(){ 
        return Mage::helper('wsu_eventtickets')->getEventticketsItemInstance(); //use other registration key if you have one
    }

    public function getCategoryIds(){
        if (is_null($this->_categoryIds)){
            $this->_categoryIds = $this->getProduct()->getCategoryIds();
        }
        return $this->_categoryIds;
    }
    public function getIdsString(){
        return is_null($this->_categoryIds) ? '' : implode(',', $this->getCategoryIds());
    }
    public function getRootNode(){
        $root = $this->getRoot();
        if ($root && is_array($this->getCategoryIds()) && in_array($root->getId(), $this->getCategoryIds())) {
            $root->setChecked(true);
        }
        return $root;
    }

    public function getRoot($parentNodeCategory = null, $recursionLevel = 3){
        if (!is_null($parentNodeCategory) && $parentNodeCategory->getId()) {
            return $this->getNode($parentNodeCategory, $recursionLevel);
        }
        $root = Mage::registry('category_root');
        if (is_null($root)) {
            $rootId = Mage_Catalog_Model_Category::TREE_ROOT_ID;
            $ids = $this->getSelectedCategotyPathIds($rootId);
            $tree = Mage::getResourceSingleton('catalog/category_tree')
                ->loadByIds($ids, false, false);
            if ($this->getCategory()) {
                $tree->loadEnsuredNodes($this->getCategory(), $tree->getNodeById($rootId));
            }
            $tree->addCollectionData($this->getCategoryCollection());
            $root = $tree->getNodeById($rootId);
            Mage::register('category_root', $root);
        }
        return $root;
    }
    protected function _getNodeJson($node, $level = 1){
        $item = parent::_getNodeJson($node, $level);
        if ($this->_isParentSelectedCategory($node)) {
            $item['expanded'] = true;
        }
        if ( is_array($this->getCategoryIds()) && in_array($node->getId(), $this->getCategoryIds())) {
            $item['checked'] = true;
        }
        return $item;
    }
    protected function _isParentSelectedCategory($node){
        $result = false;
        // Contains string with all category IDs of children (not exactly direct) of the node
        $allChildren = $node->getAllChildren();
        if ($allChildren) {
            $selectedCategoryIds = $this->getCategoryIds();
            $allChildrenArr = explode(',', $allChildren);
            for ($i = 0, $cnt = count($selectedCategoryIds); $i < $cnt; $i++) {
                $isSelf = $node->getId() == $selectedCategoryIds[$i];
                if (!$isSelf && in_array($selectedCategoryIds[$i], $allChildrenArr)) {
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }
    protected function _getSelectedNodes(){
        if ($this->_selectedNodes === null) {
            $this->_selectedNodes = array();
            $root = $this->getRoot();
            foreach ($this->getCategoryIds() as $categoryId) {
                if ($root) {
                    $this->_selectedNodes[] = $root->getTree()->getNodeById($categoryId);
                }
            }
        }
        return $this->_selectedNodes;
    }

    public function getCategoryChildrenJson($categoryId){
        $category = Mage::getModel('catalog/category')->load($categoryId);
        $node = $this->getRoot($category, 1)->getTree()->getNodeById($categoryId);
        if (!$node || !$node->hasChildren()) {
            return '[]';
        }
        $children = array();
        foreach ($node->getChildren() as $child) {
            $children[] = $this->_getNodeJson($child);
        }
        return Mage::helper('core')->jsonEncode($children);
    }
    public function getLoadTreeUrl($expanded = null){
        return $this->getUrl('*/*/categoriesJson', array('_current' => true));
    }
    public function getSelectedCategoryPathIds($rootId = false){
        $ids = array();
        $categoryIds = $this->getCategoryIds();
        if (empty($categoryIds)) {
            return array();
        }
        $collection = Mage::getResourceModel('catalog/category_collection');
        if ($rootId) {
            $collection->addFieldToFilter('parent_id', $rootId);
        }
        else {
            $collection->addFieldToFilter('entity_id', array('in'=>$categoryIds));
        }

        foreach ($collection as $item) {
            if ($rootId && !in_array($rootId, $item->getPathIds())) {
                continue;
            }
            foreach ($item->getPathIds() as $id) {
                if (!in_array($id, $ids)) {
                    $ids[] = $id;
                }
            }
        }
        return $ids;
    }
}


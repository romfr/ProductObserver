<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Rom
 * @package    Rom_ProductObserver
 * @copyright  Copyright (c) 2013 ROM Agence de communication <rom@rom.fr>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     André Herrn <andre.herrn@rom.fr>
 */

/**
 * Log Entity
 * 
 * @category   Rom
 * @package    Rom_ProductObserver
 * @author     André Herrn <andre.herrn@rom.fr>
 */
class Rom_ProductObserver_Model_Log extends Mage_Core_Model_Abstract
{
    /**
     * @const ACTION_TYPE_ADD Type for add actions
     */
    const ACTION_TYPE_ADD = "add";

    /**
     * @const ACTION_TYPE_UPDATE Type for update actions
     */
    const ACTION_TYPE_UPDATE = "update";

    /**
     * @const ACTION_TYPE_DELETE Type for delete actions
     */
    const ACTION_TYPE_DELETE = "delete";

    /**
     * @const CHANGED_PART_PRODUCT Changed part product
     */
    const CHANGED_PART_PRODUCT = "product";

    /**
     * @const CHANGED_PART_PRICE Changed part price
     */
    const CHANGED_PART_PRICE = "price";

    /**
     * @const CHANGED_PART_SPECIAL_PRICE Changed part special price
     */
    const CHANGED_PART_SPECIAL_PRICE = 'special_price';

    /**
     * @const CHANGED_PART_STOCK Changed part stock
     */
    const CHANGED_PART_STOCK = 'stock';

    /**
     * @const CHANGED_PART_CATALOG_RULE Changed part catalog price rule
     */
    const CHANGED_PART_CATALOG_RULE = 'catalog_rule';

    /**
     * Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init('romproductobserver/log');
        parent::_construct();
    }

    /**
     * Get action type options
     * 
     * @return array
     */
    public function getActionTypeOptions()
    {
        $helper = Mage::helper('adminhtml');

        return array(
            self::ACTION_TYPE_ADD => $helper->__('Add'),
            self::ACTION_TYPE_UPDATE => $helper->__('Update'),
            self::ACTION_TYPE_DELETE => $helper->__('Delete'),
        );
    }

    /**
     * Get changed part options
     * 
     * @return array
     */
    public function getChangedPartOptions()
    {
        $helper = Mage::helper('romproductobserver/data');

        return array(
            self::CHANGED_PART_PRODUCT   => $helper->__('Product'),
            self::CHANGED_PART_PRICE   => $helper->__('Price'),
            self::CHANGED_PART_SPECIAL_PRICE   => $helper->__('Special Price'),
            self::CHANGED_PART_STOCK     => $helper->__('Stock Status'),
            self::CHANGED_PART_CATALOG_RULE    => $helper->__('Catalog Price Rules'),
        );
    }

    /**
     * Rewrite save method to add the current GMT created_at date
     * 
     * @return Rom_ProductObserver_Model_Log
     */
    public function save()
    {
        $this->setCreatedAt(Mage::getModel('core/date')->gmtDate());
        return parent::save();
    }
}
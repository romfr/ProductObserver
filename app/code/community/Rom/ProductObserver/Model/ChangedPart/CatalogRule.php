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
 * Changed Part Catalog Rule Model
 * 
 * @category   Rom
 * @package    Rom_ProductObserver
 * @author     André Herrn <andre.herrn@rom.fr>
 */
class Rom_ProductObserver_Model_ChangedPart_CatalogRule
{
    /**
     * Log new catalog rule
     *
     * @param  Mage_CatalogRule_Model_Rule $rule
     * @return void
     */
    public function logNew($rule)
    {
        $this->log($rule, Rom_ProductObserver_Model_Log::ACTION_TYPE_ADD);
    }

    /**
     * Log update catalog rule
     *
     * @param  Mage_CatalogRule_Model_Rule $rule
     * @return void
     */
    public function logUpdate($rule)
    {
        $this->log($rule, Rom_ProductObserver_Model_Log::ACTION_TYPE_UPDATE);
    }

    /**
     * Log delete catalog rule
     *
     * @param  Mage_CatalogRule_Model_Rule $rule
     * @return void
     */
    public function logDelete($rule)
    {
        $this->log($rule, Rom_ProductObserver_Model_Log::ACTION_TYPE_DELETE);
    }

    /**
     * Log catalog rule
     *
     * @param  Mage_CatalogRule_Model_Rule $rule
     * @param  string $actionType
     * @return void
     */
    protected function log($rule, $actionType)
    {
        Mage::getModel('romproductobserver/log')
            ->setSku($rule->getName())
            ->setTitle($rule->getDescription())
            ->setActionType($actionType)
            ->setChangedPart(Rom_ProductObserver_Model_Log::CHANGED_PART_CATALOG_RULE)
            ->save();
    }
}
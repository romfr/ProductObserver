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
 * Changed Part Product Model
 * 
 * @category   Rom
 * @package    Rom_ProductObserver
 * @author     André Herrn <andre.herrn@rom.fr>
 */
class Rom_ProductObserver_Model_ChangedPart_Product
{
    /**
     * Log new product
     *
     * @param  Mage_Catalog_Model_Product $product
     * @return void
     */
    public function logNew($product)
    {
        $this->log($product, Rom_ProductObserver_Model_Log::ACTION_TYPE_ADD);
    }

    /**
     * Log update product
     *
     * @param  Mage_Catalog_Model_Product $product
     * @param  string $changedPart
     * @return void
     */
    public function logUpdate($product, $changedPart = null)
    {
        $this->log($product, Rom_ProductObserver_Model_Log::ACTION_TYPE_UPDATE, $changedPart);
    }

    /**
     * Log delete product
     *
     * @param  Mage_Catalog_Model_Product $product
     * @return void
     */
    public function logDelete($product)
    {
        $this->log($product, Rom_ProductObserver_Model_Log::ACTION_TYPE_DELETE);
    }

    /**
     * Log product
     *
     * @param  Mage_Catalog_Model_Product $product
     * @param  string $actionType
     * @param  string $changedPart
     * @return void
     */
    protected function log($product, $actionType, $changedPart = null)
    {
        if (true === is_null($changedPart)) {
            $changedPart = Rom_ProductObserver_Model_Log::CHANGED_PART_PRODUCT;
        }

        Mage::getModel('romproductobserver/log')
            ->setSku($product->getSku())
            ->setTitle($product->getName())
            ->setActionType($actionType)
            ->setChangedPart($changedPart)
            ->save();
    }

    /**
     * LLog special product update action - price, special_price,...
     *
     * @param  Mage_Catalog_Model_Product $product
     * @return void
     */
    public function logUpdateByAttribute($product)
    {
        //Price updated
        if ($product->getData('price') != $product->getOrigData('price')) {
            $this->logUpdate(
                $product,
                Rom_ProductObserver_Model_Log::CHANGED_PART_PRICE
            );
        }

        //Special price updated
        if ($product->getData('special_price') != $product->getOrigData('special_price')) {
            $this->logUpdate(
                $product,
                Rom_ProductObserver_Model_Log::CHANGED_PART_SPECIAL_PRICE
            );
        }

        //Stock updated
        $stockData = $product->getStockData();
        if ($product->getData('is_in_stock') != $stockData['is_in_stock']) {
            $this->logUpdate(
                $product,
                Rom_ProductObserver_Model_Log::CHANGED_PART_STOCK
            );
        }
    }
}
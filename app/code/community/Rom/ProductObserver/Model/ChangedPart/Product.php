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
     * @var string Log message
     */
    public $logMessage = null;
    
    /**
     * @var int $storeId StoreId
     */
    protected $storeId = 0;
    
    /**
     * Log new product
     *
     * @param  Mage_Catalog_Model_Product $product
     * @return void
     */
    public function logNew($product)
    {
        //Set message
        $this->logMessage = 'New product';

        $this->log(
            $product,
            Rom_ProductObserver_Model_Log::ACTION_TYPE_ADD,
            Rom_ProductObserver_Model_Log::CHANGED_PART_PRODUCT
        );
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
        $this->log(
            $product,
            Rom_ProductObserver_Model_Log::ACTION_TYPE_UPDATE,
            $changedPart
        );
    }

    /**
     * Log delete product
     *
     * @param  Mage_Catalog_Model_Product $product
     * @return void
     */
    public function logDelete($product)
    {
        //Set message
        $this->logMessage = 'Product deleted';

        $this->log(
            $product,
            Rom_ProductObserver_Model_Log::ACTION_TYPE_DELETE,
            Rom_ProductObserver_Model_Log::CHANGED_PART_PRODUCT
        );
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
        //Set changed part to product in case it is not given (default)
        if (true === is_null($changedPart)) {
            //Disable pure product update log
            return;
        }
        
        //Set store_id if product was saved in a special scope
        if (false === is_null($product->getData('store_id'))
            && '' != $product->getData('store_id')) {
            $this->storeId = $product->getData('store_id');
        }
        
        //Load product name from orig-data if it is not given as new value (exist if it was saved in Sub-Scope)
        $productName = $product->getName();
        if (true === is_null($productName)
            || '' == $productName) {
            $productName = $product->getOrigData('name');
        }
        
        //Save log entry
        Mage::getModel('romproductobserver/log')
            ->setSku($product->getSku())
            ->setTitle($productName)
            ->setActionType($actionType)
            ->setChangedPart($changedPart)
            ->setMessage($this->logMessage)
            ->setStoreId($this->storeId)
            ->save();
    }

    /**
     * Log special product update action - price, special_price,...
     *
     * @param  Mage_Catalog_Model_Product $product
     * @return void
     */
    public function logUpdateByAttribute($product)
    {
        //Price updated
        if ($product->getData('price') != $product->getOrigData('price')) {
            //Set detail price update message
            $this->logMessage = sprintf(
                'Price: [From] %s [To] %s',
                (float) $product->getOrigData('price'),
                (float) $product->getData('price')
            );

            $this->logUpdate(
                $product,
                Rom_ProductObserver_Model_Log::CHANGED_PART_PRICE
            );
        }

        //Special price updated
        if ($product->getData('special_price') != $product->getOrigData('special_price')) {
            //Set detail price update message
            $this->logMessage = sprintf(
                'Special price: [From] %s [To] %s',
                (float) $product->getOrigData('special_price'),
                (float) $product->getData('special_price')
            );
            
            $this->logUpdate(
                $product,
                Rom_ProductObserver_Model_Log::CHANGED_PART_PRICE
            );
        }

        //Stock updated
        $stockData = $product->getStockData();
        $minOutOfStockQty = (int) Mage::getStoreConfig('cataloginventory/item_options/min_qty');

        if (false === is_null($product->getData('is_in_stock'))
            && false === is_null($stockData['is_in_stock'])
            && ($product->getData('is_in_stock') != $stockData['is_in_stock']
                || $product->getData('qty') != $stockData['qty'])
            ) {
            //Set message -> if product goes in stock or out of stock
            if (($product->getData('is_in_stock') == '1' && $stockData['is_in_stock'] == '0')
                || ($product->getData('is_in_stock') == '1' && $stockData['qty'] <= $minOutOfStockQty)) {
                $this->logMessage = '[From] In stock [To] Out of stock';
            } elseif ($product->getData('is_in_stock') == '0' &&  $stockData['is_in_stock'] == '1') {
                $this->logMessage = '[From] Out of stock [To] In stock';
            } else {
                return;
            }
            
            $this->logUpdate(
                $product,
                Rom_ProductObserver_Model_Log::CHANGED_PART_STOCK
            );
        }
        
        //Special code part for pascal coste (mass product modification)
        $cell = Mage::app()->getRequest()->getParam('cell');
        $value = Mage::app()->getRequest()->getParam('value');
        
        if ($cell == 9
            && (($value > 0 && $product->getData('is_in_stock') == 0)
            || ($value < 1 && $product->getData('is_in_stock') == 1))) {
            //Set message -> if product goes in stock or out of stock
            if ($value < 1 && $product->getData('is_in_stock') == 1) {
                $this->logMessage = '[From] In stock [To] Out of stock';
            } elseif ($value > 0 && $product->getData('is_in_stock') == 0) {
                $this->logMessage = '[From] Out of stock [To] In stock';
            }
            
            $this->logUpdate(
                $product,
                Rom_ProductObserver_Model_Log::CHANGED_PART_STOCK
            );
        }
    }
}
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
 * Observer
 * 
 * @category   Rom
 * @package    Rom_ProductObserver
 * @author     André Herrn <andre.herrn@rom.fr>
 */
class Rom_ProductObserver_Model_Observer extends Mage_Core_Model_Abstract
{
    /**
     * Log delete product
     *
     * @param  Varien_Event_Observer $observer
     * @return void
     */
    public function logDeleteProduct($observer)
    {
        $product = $observer->getEvent()->getProduct();

        //Check if given product is valid
        if ($product instanceof Mage_Catalog_Model_Product) {
            Mage::getModel('romproductobserver/changedPart_Product')->logDelete($product);
        }
    }

    /**
     * Log update product
     *
     * @param  Varien_Event_Observer $observer
     * @return void
     */
    public function logSaveProduct($observer)
    {
        $product = $observer->getEvent()->getProduct();

        //Check if given product is valid
        if (!$product instanceof Mage_Catalog_Model_Product) {
            return;
        }

        //Product is new
        if (true === $product->isObjectNew()) {
            Mage::getModel('romproductobserver/changedPart_Product')->logNew($product);
        } else {
            //Product update
            Mage::getModel('romproductobserver/changedPart_Product')->logUpdate($product);

            //Log special product update action
            Mage::getModel('romproductobserver/changedPart_Product')->logUpdateByAttribute($product);
        }
    }
}
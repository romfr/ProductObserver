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
 * Admin Logcontroller
 * 
 * @category   Rom
 * @package    Rom_ProductObserver
 * @author     André Herrn <andre.herrn@rom.fr>
 */
class Rom_ProductObserver_Adminhtml_Romproductobserver_LogController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Log index
     * 
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('romproductobserver/adminhtml_log', 'romproductobserver_adminhtml_log')
        );
        $this->renderLayout();
    }
}
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
 * Log Block
 * 
 * @category   Rom
 * @package    Rom_ProductObserver
 * @author     André Herrn <andre.herrn@rom.fr>
 */
class Rom_ProductObserver_Block_Adminhtml_Log extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $helper = Mage::helper('romproductobserver/data');

        $this->_blockGroup = 'romproductobserver';
        $this->_controller = 'adminhtml_log';
        $this->_headerText = $helper->__('Rom - Catalog Observer');

        $this->_removeButton('add');
    }
}
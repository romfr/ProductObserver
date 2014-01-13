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

$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$connection->addColumn(
    $this->getTable('romproductobserver/log'),
    'store_id',
    "smallint(5) NULL DEFAULT NULL AFTER `id`"
);

$installer->endSetup();

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

$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('romproductobserver/log')};
    CREATE TABLE {$this->getTable('romproductobserver/log')} (
        `id` INT(11) unsigned NOT NULL auto_increment,
        `sku` VARCHAR(100) NOT NULL,
        `title` VARCHAR(250) NOT NULL,
        `action_type` VARCHAR(100) NOT NULL,
        `changed_part` VARCHAR(100) NOT NULL,
        `message` TEXT,
        `created_at` timestamp default CURRENT_TIMESTAMP,
        PRIMARY KEY(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();

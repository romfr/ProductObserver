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
 * Log Widget Grid
 * 
 * @category   Rom
 * @package    Rom_ProductObserver
 * @author     André Herrn <andre.herrn@rom.fr>
 */
class Rom_ProductObserver_Block_Adminhtml_Log_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct
     *
     * @return void
     */  
    public function __construct()
    {
        parent::__construct();
        $this->setId('romproductobserverLogIndex');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('desc');
    }

    /**
     * Prepare Collection
     *
     * @return object
     */ 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('romproductobserver/log')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }   

    /**
     * Prepare Columns
     *
     * @return object
     */ 
    protected function _prepareColumns()
    {
        $this->addColumn('sku', array(
            'header'    => Mage::helper('romproductobserver/data')->__('Sku'),
            'align'         => 'left',
            'filter_index'  => 'sku',
            'index'         => 'sku',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('romproductobserver/data')->__('Title'),
            'align'         => 'left',
            'filter_index'  => 'title',
            'index'         => 'title',
        ));

        $this->addColumn('action_type', array(
            'header'    => Mage::helper('romproductobserver/data')->__('Action'),
            'align'     => 'left',
            'index'     => 'action_type',
            'type'      => 'options',
            'options'   => Mage::getModel('romproductobserver/log')->getActionTypeOptions(),
        ));

        $this->addColumn('changed_part', array(
            'header'         => Mage::helper('romproductobserver/data')->__('Part'),
            'align'         => 'left',
            'index'         => 'changed_part',
            'filter_index'  => 'changed_part',
            'type'      => 'options',
            'options'   => Mage::getModel('romproductobserver/log')->getChangedPartOptions(),
        ));
        
        $this->addColumn('created_at', array(
            'header'        => Mage::helper('romproductobserver/data')->__('Date'),
            'align'         => 'left',
            'filter_index'  => 'created_at',
            'index'         => 'created_at',
            'type'          => 'datetime'
        ));

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return false;
    }
}
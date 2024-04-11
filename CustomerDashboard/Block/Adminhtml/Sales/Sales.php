<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Nisl\CustomerDashboard\Block\Adminhtml\Sales;

class Sales extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Rh\Blog\Model\Status
     */
    protected $_status;
    /**
     * @var \Rh\Blog\Model\BlogFactory
     */
    protected $_blogFactory;
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var string
     */
    protected $_template = 'Nisl_CustomerDashboard::widget/grid/extended.phtml';

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data            $backendHelper
     * @param \Rh\Blog\Model\BlogFactory              $blogFactory
     * @param \Rh\Blog\Model\Status                   $status
     * @param \Magento\Framework\Module\Manager       $moduleManager
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Nisl\CustomerDashboard\Model\ResourceModel\CustomerOrders $blogFactory,        
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {


        $this->_blogFactory = $blogFactory;       
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('customers_grid');
        $this->setDefaultSort('increment_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);  
                         
        
    }
    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_blogFactory;//->create()->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'increment_id',
            [
                'header' => __('Order'),
                'type' => 'text',
                'index' => 'increment_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'created_at',
            [
                'header' => __('Purchased'),
                'index' => 'created_at',
                'type' => 'datetime'
            ]
        );

        $this->addColumn(
            'bill_to_name',
            [
                'header' => __('Bill to Name'),
                'index' => 'bill_to_name',
            ]
        );

        $this->addColumn(
            'ship_to_name',
            [
                'header' => __('Ship to Name'),
                'index' => 'ship_to_name',
            ]
        );

          $this->addColumn(
            'base_grand_total',
            [
                'header' => __('Order Total'),
                'index' => 'base_grand_total',
                'type' => 'range'
            ]
        );

        $this->addColumn(
            'product_id',
            [
                'header' => __('Products'),
                'index' => 'product_id',
            ]
        );  
        
        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }
        return parent::_prepareColumns();
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/report/sales', ['_current' => true]);
    }
    
}

<?php

namespace Nisl\CustomerDashboard\Block\Adminhtml\Widget\Grid;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
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
        \Nisl\CustomerDashboard\Model\ResourceModel\CustomReport $blogFactory,        
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
        $this->setId('custom_report_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);        
        $this->setFilterVisibility(false);        
        $this->setVarNameFilter('grid_record');
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
            'skus',
            [
                'header' => __('SKUs'),
                'type' => 'text',
                'index' => 'skus',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'total',
            [
                'header' => __('Total'),
                'index' => 'total',
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
        return $this->getUrl('*/report/index', ['_current' => true]);
    }
    
}
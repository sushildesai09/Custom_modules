<?php

namespace Nisl\CustomerDashboard\Block\Adminhtml;

class CustomerChart extends Graph
{

	 /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Reports\Model\ResourceModel\Order\CollectionFactory $collectionFactory
     * @param \Magento\Backend\Helper\Dashboard\Data $dashboardData
     * @param \Nisl\CustomerDashboard\Helper\Dashboard\Order $dataHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Reports\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        \Magento\Backend\Helper\Dashboard\Data $dashboardData,
        \Nisl\CustomerDashboard\Helper\Dashboard\Order $dataHelper,
        array $data = []
    ) {
        $this->_dataHelper = $dataHelper;
        parent::__construct($context, $collectionFactory, $dashboardData, $data);
    }

    /**
     * Initialize object
     *
     * @return void
     */
    protected function _construct()
    {
        $this->setHtmlId('amount');
        parent::_construct();
    }

    /**
     * Prepare chart data
     *
     * @return void
     */
    protected function _prepareData()
    {
        $this->getDataHelper()->setParam('store', $this->getRequest()->getParam('store'));
        $this->getDataHelper()->setParam('website', $this->getRequest()->getParam('website'));
        $this->getDataHelper()->setParam('group', $this->getRequest()->getParam('group'));

        if($this->getRequest()->getParam('fromdate')){
            $this->getDataHelper()->setParam('fromdate', $this->getRequest()->getParam('fromdate'));    
        }

        if($this->getRequest()->getParam('todate')){
            $this->getDataHelper()->setParam('todate', $this->getRequest()->getParam('todate'));    
        }

      

        $this->setDataRows('revenue');
        $this->_axisMaps = ['x' => 'range', 'y' => 'revenue'];
        parent::_prepareData();
    }
}

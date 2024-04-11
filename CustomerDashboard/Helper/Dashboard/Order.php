<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Nisl\CustomerDashboard\Helper\Dashboard;

use Magento\Framework\App\ObjectManager;

/**
 * Adminhtml dashboard helper for orders
 *
 * @api
 * @since 100.0.2
 */
class Order extends \Magento\Backend\Helper\Dashboard\AbstractDashboard
{
    /**
     * @var \Magento\Reports\Model\ResourceModel\Order\Collection
     */
    protected $_orderCollection;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     * @since 100.0.6
     */
    protected $_storeManager;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Reports\Model\ResourceModel\Order\Collection $orderCollection
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Nisl\CustomerDashboard\Model\ResourceModel\Order\Collection $orderCollection,
        \Magento\Store\Model\StoreManagerInterface $storeManager = null
    ) {
        $this->_orderCollection = $orderCollection;
        $this->_storeManager = $storeManager ?: ObjectManager::getInstance()
            ->get(\Magento\Store\Model\StoreManagerInterface::class);

        parent::__construct($context);
    }

    /**
     * @return void
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _initCollection()
    {
        $isFilter = $this->getParam('store') || $this->getParam('website') || $this->getParam('group');

       
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        if(!$this->getParam('period')){
            $this->setParams(array('period'=>'2y'));    
        }
        

        $dateFilter = $objectManager->get('\Magento\Framework\Stdlib\DateTime\Filter\Date');

        $fromdate = 0;
        if($this->getParam('fromdate')){          
            $fdate = $dateFilter->filter($this->getParam('fromdate'));
            $fromdate  =  new \DateTime($fdate);
        }

        $todate = 0;
        if($this->getParam('todate')){                
            $tdate = $dateFilter->filter($this->getParam('todate')); 
            $todate  =  new \DateTime($tdate);  
        }

        if($this->getParam('fromdate') != '' && $this->getParam('todate') != ''){
            $this->setParams(array('period'=>'custom'));    
        }else{
            $fromdate = 0;
            $todate = 0;
        }
        

        $model = $objectManager->get('\Magento\Framework\App\RequestInterface');
        $customerId =  $model->getParam('id');        
        



        $this->_collection = $this->_orderCollection->prepareSummary($this->getParam('period'), $fromdate, $todate, $isFilter,$customerId);

        if ($this->getParam('store')) {
            $this->_collection->addFieldToFilter('store_id', $this->getParam('store'));
        } elseif ($this->getParam('website')) {
            $storeIds = $this->_storeManager->getWebsite($this->getParam('website'))->getStoreIds();
            $this->_collection->addFieldToFilter('store_id', ['in' => implode(',', $storeIds)]);
        } elseif ($this->getParam('group')) {
            $storeIds = $this->_storeManager->getGroup($this->getParam('group'))->getStoreIds();
            $this->_collection->addFieldToFilter('store_id', ['in' => implode(',', $storeIds)]);
        } elseif (!$this->_collection->isLive()) {
            $this->_collection->addFieldToFilter(
                'store_id',
                ['eq' => $this->_storeManager->getStore(\Magento\Store\Model\Store::ADMIN_CODE)->getId()]
            );
        }
        
        
       // echo $this->_collection->getSelect()->__toString();exit;
       
        $this->_collection->load();
    }
}

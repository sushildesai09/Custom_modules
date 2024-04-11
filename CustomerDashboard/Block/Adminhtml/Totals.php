<?php
namespace Nisl\CustomerDashboard\Block\Adminhtml;

class Totals extends Bar
{
    /**
     * @var string
     */
    protected $_template = 'Nisl_CustomerDashboard::dashboard/totalbar.phtml';

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $_moduleManager;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Nisl\CustomerDashboard\Model\ResourceModel\Order\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Nisl\CustomerDashboard\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_moduleManager = $moduleManager;
        parent::__construct($context, $collectionFactory, $data);
    }

    /**
     * @inheritDoc
     * @return $this|void
     */
    protected function _prepareLayout()
    {
        if (!$this->_moduleManager->isEnabled('Magento_Reports')) {
            return $this;
        }
        $isFilter = $this->getRequest()->getParam(
            'store'
        ) || $this->getRequest()->getParam(
            'website'
        ) || $this->getRequest()->getParam(
            'group'
        );
        $period = $this->getRequest()->getParam('period', '1y');

         $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
          $dateFilter = $objectManager->get('\Magento\Framework\Stdlib\DateTime\Filter\Date');
         $fromdate = 0;
        if($this->getRequest()->getParam('fromdate')){          
            $fdate = $dateFilter->filter($this->getRequest()->getParam('fromdate'));
            $fromdate  =  new \DateTime($fdate);
        }

        $todate = 0;
        if($this->getRequest()->getParam('todate')){                
            $tdate = $dateFilter->filter($this->getRequest()->getParam('todate')); 
            $todate  =  new \DateTime($tdate);  
        }


        if($this->getRequest()->getParam('fromdate') != '' && $this->getRequest()->getParam('todate') != ''){
           	/* @var $collection \Magento\Reports\Model\ResourceModel\Order\Collection */
	        $collection = $this->_collectionFactory->create()->addCreateAtPeriodFilter(
	            'custom',$this->getRequest()->getParam('id'),$fromdate,$todate
	        )->calculateTotals(
	            $isFilter
	        ); $this->setParams(array('period'=>'custom'));    
        }else{
        	/* @var $collection \Magento\Reports\Model\ResourceModel\Order\Collection */
	        $collection = $this->_collectionFactory->create()->addCreateAtPeriodFilter(
	            $period,$this->getRequest()->getParam('id')
	        )->calculateTotals(
	            $isFilter
	        );
        }



        

        if ($this->getRequest()->getParam('store')) {
            $collection->addFieldToFilter('store_id', $this->getRequest()->getParam('store'));
        } else {
            if ($this->getRequest()->getParam('website')) {
                $storeIds = $this->_storeManager->getWebsite($this->getRequest()->getParam('website'))->getStoreIds();
                $collection->addFieldToFilter('store_id', ['in' => $storeIds]);
            } else {
                if ($this->getRequest()->getParam('group')) {
                    $storeIds = $this->_storeManager->getGroup($this->getRequest()->getParam('group'))->getStoreIds();
                    $collection->addFieldToFilter('store_id', ['in' => $storeIds]);
                } elseif (!$collection->isLive()) {
                    $collection->addFieldToFilter(
                        'store_id',
                        ['eq' => $this->_storeManager->getStore(\Magento\Store\Model\Store::ADMIN_CODE)->getId()]
                    );
                }
            }
        }
        
       // echo $collection->getSelect()->__toString();exit;
        $collection->load();

        $totals = $collection->getFirstItem();

        $this->addTotal(__('Revenue'), $totals->getRevenue());
        $this->addTotal(__('Tax'), $totals->getTax());
        $this->addTotal(__('Shipping'), $totals->getShipping());
        $this->addTotal(__('Quantity'), $totals->getQuantity() * 1, true);
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Nisl\CustomerDashboard\Block\Adminhtml;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Address\Mapper;

/**
 * Adminhtml customer view personal information sales block.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CustomerDetails extends \Magento\Backend\Block\Template
{
    
    const DEFAULT_ONLINE_MINUTES_INTERVAL = 15;

    protected $request;

    protected $_customer;

    protected $_customerFactory;

    protected $logger;

    protected $accountManagement;

    protected $addressHelper;

    protected $addressMapper;
    /**
     * Customer log
     *
     * @var \Magento\Customer\Model\Log
     */
    protected $customerLog;


    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Customer\Model\Customer $customer,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        AccountManagementInterface $accountManagement,
        \Magento\Customer\Helper\Address $addressHelper,
        Mapper $addressMapper,
        \Magento\Customer\Model\Logger  $logger,
        \Magento\Backend\Block\Template\Context $context,       
        array $data = []
    ) {
        $this->request = $request;
        $this->_customer = $customer;
        $this->_customerFactory = $customerFactory;
        $this->accountManagement = $accountManagement;
        $this->addressHelper = $addressHelper;
        $this->addressMapper = $addressMapper;
        $this->logger = $logger;       
        parent::__construct($context, $data);
    }

    /**
     * Retrieve customer id
     *
     * @return string|null
     */
    public function getCustomerId()
    {
         return $this->request->getParam('id');
    }


    public function getCustomer()
    {
         return $this->_customer->load($this->getCustomerId());
    }

    public function getAccountLock()
    {
       
        $customerStatus = __('Unlocked');
        if ($this->getCustomer()->isCustomerLocked()) {
            $customerStatus = __('Locked');
        }
        return $customerStatus;
    }

    public function getLastLoginDate()
    {
       
        return $this->changeDateFormat($this->logger->get($this->getCustomerId())->getLastLoginAt());
        
    }

    /**
     * Returns interval that shows how long customer will be considered 'Online'.
     *
     * @return int Interval in minutes
     */
    protected function getOnlineMinutesInterval()
    {
        $configValue = $this->_scopeConfig->getValue(
            'customer/online_customers/online_minutes_interval',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return (int)$configValue > 0 ? (int)$configValue : self::DEFAULT_ONLINE_MINUTES_INTERVAL;
    }

    /**
     * Retrieves customer log model
     *
     * @return \Magento\Customer\Model\Log
     */
    protected function getCustomerLog()
    {
        if (!$this->customerLog) {
            $this->customerLog = $this->logger->get(
                $this->getCustomer()->getId()
            );
        }

        return $this->customerLog;
    }


    
    public function getCurrentStatus()
    {
        $lastLoginTime = $this->getCustomerLog()->getLastLoginAt();

        // Customer has never been logged in.
        if (!$lastLoginTime) {
            return __('Offline');
        }

        $lastLogoutTime = $this->getCustomerLog()->getLastLogoutAt();

        // Customer clicked 'Log Out' link\button.
        if ($lastLogoutTime && strtotime($lastLogoutTime) > strtotime($lastLoginTime)) {
            return __('Offline');
        }

        // Predefined interval has passed since customer's last activity.
        $interval = $this->getOnlineMinutesInterval();
        $currentTimestamp = (new \DateTime())->getTimestamp();
        $lastVisitTime = $this->getCustomerLog()->getLastVisitAt();

        if ($lastVisitTime && $currentTimestamp - strtotime($lastVisitTime) > $interval * 60) {
            return __('Offline');
        }

    }


    public function getCreateDate()
    {
        return $this->changeDateFormat($this->formatDate(
            $this->getCustomer()->getCreatedAt(),
            \IntlDateFormatter::MEDIUM,
            true
        ));
    }

      public function getOrderDetails()
    {
        $collection = $this->_customerFactory->create()->getCollection();
        $collection->getSelect()->join(
            ['thirdTable' => new \Zend_Db_Expr('(SELECT customer_id , customer_email ,  count(customer_id) as no_of_orders , Min(t1.created_at) as order_started , Max(t1.created_at) as order_from , DATEDIFF(Max(t1.created_at),Min(t1.created_at)) as days , CEILING((DATEDIFF(Max(t1.created_at), Min(t1.created_at))/count(customer_id))) as frequency FROM  sales_order  as t1 group by customer_id , customer_email )')],                
            'e.entity_id = thirdTable.customer_id',                              
            ['thirdTable.order_from','thirdTable.frequency as avg_order']
        )->where('e.entity_id = '. $this->getCustomerId());        
        

        return array('last_order'=> $collection->getData()[0]['order_from'],'order_frequency'=> $collection->getData()[0]['avg_order']);


          
    }

    public function getBillingAddressHtml()
    {
        try {
            $address = $this->accountManagement->getDefaultBillingAddress($this->getCustomer()->getId());
        } catch (NoSuchEntityException $e) {
            return __('The customer does not have default billing address.');
        }

        if ($address === null) {
            return __('The customer does not have default billing address.');
        }

        return $this->addressHelper->getFormatTypeRenderer(
            'html'
        )->renderArray(
            $this->addressMapper->toFlatArray($address)
        );
    }

   

    public function getShippingAddressHtml(){

        try {
            $address = $this->accountManagement->getDefaultShippingAddress($this->getCustomer()->getId());
        } catch (NoSuchEntityException $e) {
            return __('The customer does not have default Shipping address.');
        }

        if ($address === null) {
            return __('The customer does not have default Shipping address.');
        }

        return $this->addressHelper->getFormatTypeRenderer(
            'html'
        )->renderArray(
            $this->addressMapper->toFlatArray($address)
        );
    }
    
    public function changeDateFormat($date){

        return date("d/m/Y H:i:s", strtotime($date));
    }


}

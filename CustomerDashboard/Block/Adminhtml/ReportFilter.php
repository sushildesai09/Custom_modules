<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Nisl\CustomerDashboard\Block\Adminhtml;



 
class ReportFilter extends \Magento\Backend\Block\Template
{
    
    

    protected $request;

    protected $_customer;

    protected $_customerFactory;

    protected $logger;

    
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
        \Magento\Customer\Model\Logger  $logger,
        \Magento\Backend\Block\Template\Context $context,       
        array $data = []
    ) {
        $this->request = $request;
        $this->_customer = $customer;
        $this->_customerFactory = $customerFactory;        
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

    

    


    



}

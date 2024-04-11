<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Nisl\CustomerDashboard\Block\Adminhtml;

class CustomerReschedule extends \Magento\Backend\Block\Template
{
   
	protected $_reschedule; 

    protected $_request; 

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Nisl\CustomerDashboard\Model\Reschedule $reschedule,
         \Magento\Framework\App\RequestInterface $request             
    ) {
       
        parent::__construct($context);
        $this->_reschedule = $reschedule;
    }

    public function RescheduleCollection(){
            $all_data = $this->_reschedule->getCollection()->addFieldToFilter('customer_id',$this->getCustomerId())->getData();           
            return $all_data;
    }

    public function getCustomerId(){
        return $this->_request->getParam('id');
    }

}

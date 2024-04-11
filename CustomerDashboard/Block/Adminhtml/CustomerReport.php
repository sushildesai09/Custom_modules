<?php

namespace Nisl\CustomerDashboard\Block\Adminhtml;

class CustomerReport extends \Magento\Backend\Block\Widget\Grid\Container
{

	protected $_customerdetails;


	 /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Widget\Context $context,
    	\Nisl\CustomerDashboard\Block\Adminhtml\CustomerDetails $customerdetails, 
    	array $data = [])
    {
       	
       	$this->_customerdetails = $customerdetails;
        parent::__construct($context, $data);
        
    }
	 /**
     * Initialize object state with incoming parameters
     *
     * @return void
     */
    protected function _construct()
    {


        parent::_construct();                
        $this->removeButton('add');
        $this->_addCustomerNameButton();
        $this->_addBackButton();

    } 


     /**
     * @return void
     */
    protected function _addBackButton()
    {
        $this->addButton(
            'back',
            [
                'label' => $this->getBackButtonLabel(),
                'onclick' => 'location.href = \'' . $this->getUrl('nisl_customerdashboard/index/index') . '\'',
                'class' => 'back'
            ]
        );
    }   

     /**
     * @return void
     */
    protected function _addCustomerNameButton()
    {

    	
        $this->addButton(
             'customer-name',
             [
                 'label' => __($this->_customerdetails->getCustomer()->getName()),
                 'class' => 'custom-customer-name ',
                 
             ]
             
         );
    }   
	
}
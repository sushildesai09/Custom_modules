<?php
namespace Nisl\CustomerDashboard\Controller\Adminhtml\Customer;

class Index extends \Magento\Backend\App\Action
{
         protected $resultPageFactory = false;      
         
         

         public function __construct(
                 \Magento\Backend\App\Action\Context $context,                
                 \Magento\Framework\View\Result\PageFactory $resultPageFactory                
         ) {
                 
                 $this->resultPageFactory = $resultPageFactory;
                 parent::__construct($context);
                  
                
                 
         } 
         public function execute()
         {

                
                $resultPage = $this->resultPageFactory->create();
                $resultPage->setActiveMenu('Nisl_CustomerDashboard::dash');
                $resultPage->getConfig()->getTitle()->prepend(__('Customer Data'));
                $customerId = (int)$this->getRequest()->getParam('id');    


                return $resultPage;




         }

         protected function _isAllowed()
         {
                 return $this->_authorization->isAllowed('Nisl_CustomerDashboard::dash');
         }


}




<?php
namespace Nisl\CustomerDashboard\Controller\Adminhtml\Customer;

class Reschedule extends \Magento\Backend\App\Action
{
        protected $resultPageFactory = false;      
         
        protected $_reschedule; 

        protected $authSession;

         public function __construct(
                 \Magento\Backend\App\Action\Context $context,                
                 \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                 \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
                 \Magento\Backend\Model\Auth\Session $authSession,
                 \Nisl\CustomerDashboard\Model\Reschedule $reschedule                
         ) {
                 
                 $this->resultPageFactory = $resultPageFactory;
                 $this->resultJsonFactory = $resultJsonFactory;
                 $this->authSession = $authSession;
                 $this->_reschedule = $reschedule;
                 parent::__construct($context);                
                 
         } 
         public function execute()
         {      
                $data = $this->getRequest()->getPostValue();                
                $scheduleModel = $this->_reschedule->getCollection()->addFieldToFilter('customer_id',$data['customer_id']);
                $active = ($data['customer_active'] == 'true')?1:0;
                
                if($scheduleModel->getSize() > 0){

                        $scheduleModel1 = $this->_reschedule->load($scheduleModel->getData()[0]['id']);
                        $scheduleModel1->setCustomerRescheduleDate($data['customer_reschedule_date'])
                                      ->setCustomerActive($active)
                                      ->save();  
                }else{
                         $this->_reschedule->setData($data)->save(); 
                }
              
                              
                $result = $this->resultJsonFactory->create();
                return $result->setData($data);

                
         }

        public function getCurrentUser(){

                return $this->authSession->getUser()->getUsername();
        }


        
}




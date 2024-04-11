<?php
namespace Nisl\CustomerDashboard\Controller\Adminhtml\Customer;

class Comment extends \Magento\Backend\App\Action
{
        protected $resultPageFactory = false;      
         
        protected $_comment; 

        protected $authSession;

         public function __construct(
                 \Magento\Backend\App\Action\Context $context,                
                 \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                 \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
                 \Magento\Backend\Model\Auth\Session $authSession,
                 \Nisl\CustomerDashboard\Model\Comment $comment                
         ) {
                 
                 $this->resultPageFactory = $resultPageFactory;
                 $this->resultJsonFactory = $resultJsonFactory;
                 $this->authSession = $authSession;
                 $this->_comment = $comment;
                 parent::__construct($context);                
                 
         } 
         public function execute()
         {      
                $data = $this->getRequest()->getPostValue();                
                $data['comment_by'] = $this->getCurrentUser();
                $this->_comment->setData($data)->save();

                $all_data = $this->_comment->getCollection()->addFieldToFilter('customer_id',$data['customer_id'])->getData();
                $html = '';
                foreach ($all_data as $key => $value) {
                        $html .= '<p>';
                        $html .= '<span>';
                        $html .= $value["created_at"];                
                        $html .= '</span>';
                        $html .= '  ';
                        $html .= '<span>';
                        $html .= $value["comment_by"];                
                        $html .= '</span>';
                        $html .= '<br>';
                        $html .= '<span>';
                        $html .= $value["customer_comment"];                
                        $html .= '</span>';
                        $html .= '</p>';        
                }
                
                $result = $this->resultJsonFactory->create();
                return $result->setData($html);

                
         }

        public function getCurrentUser(){

                return $this->authSession->getUser()->getUsername();
        }


        
}




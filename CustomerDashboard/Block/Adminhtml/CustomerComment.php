<?php

namespace Nisl\CustomerDashboard\Block\Adminhtml;

class CustomerComment extends \Magento\Backend\Block\Template
{   
    protected $_comment; 

    protected $_request; 

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Nisl\CustomerDashboard\Model\Comment $comment,
        \Magento\Framework\App\RequestInterface $request
        
    ) {
       
        parent::__construct($context);
        $this->_request = $request;
        $this->_comment = $comment;
    }


    public function CommentCollection(){

            
            $all_data = $this->_comment->getCollection()->addFieldToFilter('customer_id',$this->getCustomerId())->getData();
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
            return $html;
    }

    public function getCustomerId(){
        return $this->_request->getParam('id');
    }
    


    
}

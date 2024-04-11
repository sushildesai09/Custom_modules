<?php 
namespace Nisl\CustomerDashboard\Ui\DataProvider\Customer\Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    /**
     * Override _initSelect to add custom columns
     *
     * @return void
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->join(
            ['secondTable' => $this->getTable('customer_address_entity')],                    
            'main_table.default_shipping = secondTable.entity_id',                              
            ['CONCAT(IFNULL(secondTable.street,""),", ", IFNULL(secondTable.city,""),", ",IFNULL(secondTable.region,""),", ",IFNULL(secondTable.postcode,""),", ",IFNULL(secondTable.telephone,"")) AS customer_address','secondTable.city','secondTable.postcode','
            main_table.created_at as customer_since' ,'secondTable.company', 'main_table.is_active as is_active'] 
        )->join(
            ['thirdTable' => new \Zend_Db_Expr('(SELECT customer_id , customer_email ,  count(customer_id) as no_of_orders , Min(t1.created_at) as order_started , Max(t1.created_at) as order_from , DATEDIFF(Max(t1.created_at),Min(t1.created_at)) as days , CEILING((DATEDIFF(Max(t1.created_at), Min(t1.created_at))/count(customer_id))) as frequency FROM  sales_order  as t1 group by customer_id , customer_email )')],                
            'main_table.entity_id = thirdTable.customer_id',                              
            ['thirdTable.order_from','thirdTable.frequency as avg_order'] 
        )->joinLeft(['fourthTable' => $this->getTable('custom_customer_reschedule')],
            'main_table.entity_id = fourthTable.customer_id',
            ['fourthTable.customer_reschedule_date','fourthTable.customer_active']
         )->order('main_table.entity_id','ASC');
        //echo $this->getSelect()->__toString();exit;
        
        $this->addFilterToMap('entity_id', 'main_table.entity_id');

        //$this->addFilterToMap('name', 'devgridname.value');
       
    }
}

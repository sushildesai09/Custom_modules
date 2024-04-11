<?php 
namespace Nisl\CustomerDashboard\Model\ResourceModel;



class CustomerOrders extends \Magento\Sales\Model\ResourceModel\Order\Collection
{

	/**
     * Init Select
     *
     * @return $this
     */


    
    protected function _initSelect()
    {
        parent::_initSelect();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->get('\Magento\Framework\App\RequestInterface');
        $customerId =  $model->getParam('id');
        $this->getSelect()
        ->joinLeft(
            ['secondTable' => $this->getTable('sales_order_address')],                    
            'main_table.billing_address_id = secondTable.entity_id',                              
            ['CONCAT(secondTable.firstname,", ", secondTable.lastname) AS bill_to_name'] 
        )->joinLeft(
            ['thirdTable' => $this->getTable('sales_order_address')],                    
            'main_table.shipping_address_id = thirdTable.entity_id',                              
            ['CONCAT(thirdTable.firstname,", ", thirdTable.lastname) AS ship_to_name'] 
        )->join(
            ['fourthTable' => $this->getTable('sales_order_item')],                    
            'main_table.entity_id = fourthTable.order_id',                              
            ['product_type'] 
        )->join(
            ['fifthTable' => $this->getTable('catalog_product_entity')],                    
            'fourthTable.product_id = fifthTable.entity_id',                              
            ['GROUP_CONCAT(`fifthTable`.`sku`) As product_id'] 
        )->group('main_table.entity_id')->where("main_table.customer_id = $customerId and fourthTable.product_type = 'simple' ");

        $this->addFilterToMap(
            'bill_to_name',
            new \Zend_Db_Expr('CONCAT_WS(" ", secondTable.firstname, secondTable.lastname)')
        );
        $this->addFilterToMap(
            'ship_to_name',
            new \Zend_Db_Expr('CONCAT_WS(" ", thirdTable.firstname, thirdTable.lastname)')
        );
        $this->addFilterToMap(
            'product_id',
            new \Zend_Db_Expr('fifthTable.sku')
        );
		//echo $this->getSelect()->__toString();exit;
        return $this;
    }
}
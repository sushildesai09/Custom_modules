<?php 
namespace Nisl\CustomerDashboard\Model\ResourceModel;



class CustomReport extends \Magento\Sales\Model\ResourceModel\Order\Item\Collection
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

        /*if($model->getParam('fromdate') && $model->getParam('todate')){
            echo "hello";exit;
        }*/
        $this->getSelect()->reset(\Zend_Db_Select::COLUMNS)
         ->join(
            ['fourthTable' => $this->getTable('sales_order')],                    
            'main_table.order_id = fourthTable.entity_id',                              
            ['main_table.product_type'] 
        )->join(
            ['fifthTable' => $this->getTable('catalog_product_entity')],                    
            'main_table.product_id = fifthTable.entity_id',                              
            ['fifthTable.sku As skus', 'sum(`main_table`.`qty_ordered`) as total' ] 
        )->group('fifthTable.sku')
        
        ->where("fourthTable.customer_id =  $customerId and main_table.product_type = 'simple' ");

        if($model->getParam('fromdate') && $model->getParam('todate')){        
            $fdate = strtotime($model->getParam('fromdate'));
            $fromdate  =  date('Y-m-d h:i:s', $fdate);        
            $tdate = strtotime($model->getParam('todate')); 
            $todate  =  date('Y-m-d h:i:s', $tdate);
            $this->getSelect()->where("main_table.created_at BETWEEN '$fromdate' AND  '$todate' ");
        }

		//echo $this->getSelect()->__toString();exit;
        return $this;
    }
}
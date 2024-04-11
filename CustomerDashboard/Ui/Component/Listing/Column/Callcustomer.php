<?php
namespace Nisl\CustomerDashboard\Ui\Component\Listing\Column;

class Callcustomer extends \Magento\Ui\Component\Listing\Columns\Column {

	 public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                // here we can also use the data from $item to configure some parameters of an action URL

                $call_customer = false;
                $a = false ;
                $k = 0;
                if($item['customer_active'] == 1){
                    $k = "1";
                    $call_customer = true;                        
                }

                $reschedule = '';
                if($call_customer == false){
                    $k = "2";
                        if($item['customer_reschedule_date']){                    
                            $OldDate = new \DateTime($item['customer_reschedule_date']);
                            $now = new \DateTime(Date('Y-m-d H:i:s'));
                            $days = date_diff($OldDate,$now)->format("%a"); 
                            if($days > 0){
                                $reschedule = $OldDate->format('d/m/Y');
                                $call_customer = true;   
                                $a = false ;     
                            }
                        }

                       

                }
                if($call_customer == false){
                    $k = "3";
                                $OldDate = new \DateTime($item['order_from']);
                                $now = new \DateTime(Date('Y-m-d H:i:s'));
                                if(date_diff($OldDate,$now)->format("%a") > 60){
                                    $call_customer = true;
                                    $a = true ;    
                                }
                }         

                //($reschedule != 0)?$reschedule:
                $display = '';
                if($reschedule != ''){
                    $display = '<div>RESCHEDULED TO '.$reschedule.'</div>';
                }else{
                    $display = ($a == true)?'<div class="call-customer" style="background-color:red">Call Customer</div>':'';
                }
                
                $item[$this->getData('name')] = $display;
            }
        }

        return $dataSource;
    }

}

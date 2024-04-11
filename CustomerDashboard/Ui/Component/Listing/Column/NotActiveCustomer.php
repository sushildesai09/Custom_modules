<?php
namespace Nisl\CustomerDashboard\Ui\Component\Listing\Column;

class NotActiveCustomer extends \Magento\Ui\Component\Listing\Columns\Column {

	 public function prepareDataSource(array $dataSource)
    {	

        if (isset($dataSource['data']['items'])) {        	
            foreach ($dataSource['data']['items'] as & $item) {
                
                $item[$this->getData('name')] = ($item['customer_active'] == 1)?'Y':'' ;
            }
        }

        return $dataSource;
    }

}

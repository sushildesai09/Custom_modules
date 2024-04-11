<?php
namespace Nisl\CustomerDashboard\Ui\Component\Listing\Column;

class FullName extends \Magento\Ui\Component\Listing\Columns\Column {

	 public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
               
                $item[$this->getData('name')] = $item['firstname']." ".$item['lastname'];
            }
        }

        return $dataSource;
    }

}

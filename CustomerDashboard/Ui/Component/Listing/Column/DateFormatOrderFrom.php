<?php
namespace Nisl\CustomerDashboard\Ui\Component\Listing\Column;

class DateFormatOrderFrom extends \Magento\Ui\Component\Listing\Columns\Column {

	 public function prepareDataSource(array $dataSource)
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $dateFilter = $objectManager->get('\Magento\Framework\Stdlib\DateTime\TimezoneInterface');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

               	//$date = date_create($item['order_from']);
               	$dateTimeZone = $dateFilter->date(new \DateTime($item['order_from']))->format('Y/m/d');
             	$newDate = date("d-m-Y", strtotime($dateTimeZone));

                $item[$this->getData('name')] = $newDate;
            }
        }

        return $dataSource;
    }

}

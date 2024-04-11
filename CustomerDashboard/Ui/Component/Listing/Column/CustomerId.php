<?php
namespace Nisl\CustomerDashboard\Ui\Component\Listing\Column;

class CustomerId extends \Magento\Ui\Component\Listing\Columns\Column {

	 public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
            	    $fieldName = $this->getData('name');
	                $html = "<a href='" . $this->context->getUrl('nisl_customerdashboard/customer/index',['id'=>$item['entity_id']]) . "'>";
	                $html .= __('Edit');
	                $html .= "</a>";
	                $item[$fieldName] = $html;
               
            }
        }

        return $dataSource;
    }

}

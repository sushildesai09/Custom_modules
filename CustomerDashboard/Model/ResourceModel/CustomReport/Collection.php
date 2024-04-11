<?php declare(strict_types=1);

namespace Nisl\CustomerDashboard\Model\ResourceModel\CustomReport;


class Collection extends \Magento\Customer\Model\ResourceModel\Customer\Collection
{
   	protected function _initSelect()
    {
    	parent::_initSelect();
    }
}

<?php

namespace Nisl\CustomerDashboard\Model\ResourceModel\Reschedule;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Nisl\CustomerDashboard\Model\Reschedule', 'Nisl\CustomerDashboard\Model\ResourceModel\Reschedule');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
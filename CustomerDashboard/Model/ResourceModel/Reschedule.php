<?php
namespace Nisl\CustomerDashboard\Model\ResourceModel;

class Reschedule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('custom_customer_reschedule', 'id');
    }
}
?>
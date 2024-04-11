<?php
namespace Nisl\CustomerDashboard\Model\ResourceModel;

class Comment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('custom_customer_comment', 'id');
    }
}
?>
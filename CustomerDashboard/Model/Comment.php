<?php
namespace Nisl\CustomerDashboard\Model;

class Comment extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Nisl\CustomerDashboard\Model\ResourceModel\Comment');
    }
}
?>
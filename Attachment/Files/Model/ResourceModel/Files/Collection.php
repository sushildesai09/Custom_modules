<?php
/**
 * @category   Attachment
 * @package    Attachment_Files
 * @author     fr@narola.email
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Attachment\Files\Model\ResourceModel\Files;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'files_id';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Attachment\Files\Model\Files',
            'Attachment\Files\Model\ResourceModel\Files'
        );
    }
}
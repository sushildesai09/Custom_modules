<?php
/**
 * @category   Attachment
 * @package    Attachment_Files
 * @author     fr@narola.email
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Attachment\Files\Controller\Adminhtml\Items;

class NewAction extends \Attachment\Files\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
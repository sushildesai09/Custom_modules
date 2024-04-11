<?php
/**
 * @category   Attachment
 * @package    Attachment_Files
 * @author     fr@narola.email
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Attachment\Files\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NotFoundException;
use Attachment\Files\Block\FilesView;

class View extends \Magento\Framework\App\Action\Action
{
	protected $_filesview;

	public function __construct(
        Context $context,
        FilesView $filesview
    ) {
        $this->_filesview = $filesview;
        parent::__construct($context);
    }

	public function execute()
    {
    	if(!$this->_filesview->getSingleData()){
    		throw new NotFoundException(__('Parameter is incorrect.'));
    	}
    	
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}

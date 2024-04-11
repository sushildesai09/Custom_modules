<?php
/**
 * @category   Attachment
 * @package    Attachment_Files
 * @author     fr@narola.email
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Attachment\Files\Block;

use Magento\Framework\View\Element\Template\Context;
use Attachment\Files\Model\FilesFactory;
use Magento\Cms\Model\Template\FilterProvider;
/**
 * Files View block
 */
class FilesView extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Files
     */
    protected $_files;
    public function __construct(
        Context $context,
        FilesFactory $files,
        FilterProvider $filterProvider
    ) {
        $this->_files = $files;
        $this->_filterProvider = $filterProvider;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Attachment Files Module View Page'));
        
        return parent::_prepareLayout();
    }

    public function getSingleData()
    {
        $id = $this->getRequest()->getParam('id');
        $files = $this->_files->create();
        $singleData = $files->load($id);
        if($singleData->getFilesId() || $singleData['files_id'] && $singleData->getStatus() == 1){
            return $singleData;
        }else{
            return false;
        }
    }
}
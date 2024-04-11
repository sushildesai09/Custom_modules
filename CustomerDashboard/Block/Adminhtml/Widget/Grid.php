<?php

namespace Nisl\CustomerDashboard\Block\Adminhtml\Widget;

class Grid extends \Magento\Backend\Block\Widget\Container
{

	


     /**
     * @var string
     */
    protected $_template = 'report/view.phtml';


     /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }


     /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
            
        $this->setChild('grid', $this->getLayout()->createBlock('Nisl\CustomerDashboard\Block\Adminhtml\Widget\Grid\Grid', 'grid.view.grid'));
        return parent::_prepareLayout();
    }


    /**
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
    
}
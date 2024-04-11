<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
//declare(strict_types=1);
namespace MageClass\ClickAndCollect\Model\Order\Email\Container;
/**
 * Class \Magento\Sales\Model\Order\Email\Container\ShipmentIdentity
 */
class ShipmentIdentity extends \Magento\Sales\Model\Order\Email\Container\ShipmentIdentity
{

//    /**
//     * Return template id
//     *
//     * @return mixed
//     */
//    public function getTemplateId()
//    {
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $requestData = $objectManager->get("\Magento\Framework\App\Request\Http");
//        $shipmentId = $requestData->getParam('shipment_id');
//        $shipData = $objectManager->create(\Magento\Sales\Api\ShipmentRepositoryInterface::class)->get($shipmentId);
//        $orderData = $objectManager->create(\Magento\Sales\Api\OrderRepositoryInterface::class)->get($shipData->getOrderId());
//        if( $orderData->getShippingMethod() == 'clickandcollect_clickandcollect'){
//            return 17;
//        } else {
//			return 5;
//		}
//        return $this->getConfigValue(self::XML_PATH_EMAIL_TEMPLATE, $this->getStore()->getStoreId());
//    }


	/**
     * Return template id
     *
     * @return mixed
     */
    public function getTemplateId()
    {        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $requestData = $objectManager->get("\Magento\Framework\App\Request\Http");    
        $shipmentId = $requestData->getParam('shipment_id');
        $shipData = $objectManager->create(\Magento\Sales\Api\ShipmentRepositoryInterface::class)->get($shipmentId);
        $orderData = $objectManager->create(\Magento\Sales\Api\OrderRepositoryInterface::class)->get($shipData->getOrderId());        
        if( $orderData->getShippingMethod() == 'clickandcollect_clickandcollect'){
            return 17;
        }

        
        return $this->getConfigValue(self::XML_PATH_EMAIL_TEMPLATE, $this->getStore()->getStoreId());
    }

}


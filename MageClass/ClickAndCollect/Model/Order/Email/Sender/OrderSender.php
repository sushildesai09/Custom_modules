<?php 

namespace MageClass\ClickAndCollect\Model\Order\Email\Sender;
 
	class OrderSender
	{
		public function beforeSend(
			\Magento\Sales\Model\Order\Email\Sender\OrderSender $subject,
			\Magento\Sales\Model\Order $order, $forceSyncMode = false
		) {
			
			
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$helper = $objectManager->get('\MageClass\ClickAndCollect\Helper\Data');
			$order['pickup_store'] = $helper->getStoreNameById($order->getPickupStore());
			
			return array($order, $forceSyncMode);
		}
	}
<?php
/**
 * MageClass_ClickAndCollect Magento Extension
 *
 * @category    MageClass
 * @package     MageClass_ClickAndCollect
 * @author      Milan Stojanov <milan.stojanov@outlook.com>
 * @website    http://www.mageclass.com
 */

namespace MageClass\ClickAndCollect\Observer;

use Magento\Framework\Event\ObserverInterface;

class DataAssignObserver implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getQuote();
        $order = $observer->getOrder();
        $quote->getPickupDate();        
        $order->setPickupDate($quote->getPickupDate());
        
        if($quote->getPickupStore()) {
        	$order->setPickupStore($quote->getPickupStore());
        }

        if ($quote->getGiftCardType()) {
            $order->setGiftCardType($quote->getGiftCardType());
        }   
         if ($quote->getGiftCardSubtype()) {
            $order->setGiftCardSubtype($quote->getGiftCardSubtype());
        }        
        return $this;
    }
}
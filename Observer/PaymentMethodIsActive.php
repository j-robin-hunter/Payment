<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Observer;

use Magento\Framework\Event\ObserverInterface;
use RTech\Payment\Model\Olev;

class PaymentMethodIsActive implements ObserverInterface {
  protected $_productRepository;
  protected $_configData;
  protected $_storeId;

  public function __construct(
    \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
    \RTech\Payment\Helper\ConfigData $configData,
    \Magento\Store\Model\StoreManagerInterface $storeManager
  ) {
    $this->_productRepository = $productRepository;
    $this->_configData = $configData;
    $this->_storeId = $storeManager->getStore()->getId();
  }

  public function execute(\Magento\Framework\Event\Observer $observer) {

    $method_instance = $observer->getEvent()->getMethodInstance()->getCode();
    $result = $observer->getEvent()->getResult();
    $quote = $observer->getEvent()->getQuote();

    $olev_categories = $this->_configData->getOlevPaymentCategories($this->_storeId);

    if ($quote) {
      $isolev = false;
      foreach ($quote->getAllItems() as $item) {
        $product = $this->_productRepository->get($item->getSku());
        $isolev = count(array_intersect($olev_categories, $product->getCategoryCollection()->getAllIds()));
      }
      if ($isolev) {
        if ($observer->getEvent()->getMethodInstance()->getCode() == Olev::PAYMENT_METHOD_OLEV_CODE) {
          $result->setData('is_available', true);
        } else {
          $result->setData('is_available', false);
        }
      } else {
        if ($observer->getEvent()->getMethodInstance()->getCode() == Olev::PAYMENT_METHOD_OLEV_CODE) {
          $result->setData('is_available', false);
        } else {
          $result->setData('is_available', true);
        }
      }
    }
  }
}
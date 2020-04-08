<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Observer;

use Magento\Framework\Event\ObserverInterface;
use RTech\Payment\Model\Olev;
use RTech\Payment\Model\PaymentTerms;
use RTech\Zoho\Webservice\Client\ZohoBooksClient;

class PaymentMethodIsActive implements ObserverInterface {

  protected $_productRepository;
  protected $_configData;
  protected $_storeId;
  protected $_customerSession;

  public function __construct(
    \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
    \RTech\Payment\Helper\ConfigData $configData,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Customer\Model\Session $customerSession,
    \RTech\Zoho\Helper\ConfigData $zohoConfigData,
    \Zend\Http\Client $zendClient,
    \RTech\Zoho\Model\ZohoCustomerRepository $zohoCustomerRepository
  ) {
    $this->_productRepository = $productRepository;
    $this->_configData = $configData;
    $this->_storeId = $storeManager->getStore()->getId();
    $this->_customerSession = $customerSession;
    $this->_zohoClient = new ZohoBooksClient($zohoConfigData, $zendClient, $storeManager);
    $this->_zohoCustomerRepository = $zohoCustomerRepository;
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
        switch ($observer->getEvent()->getMethodInstance()->getCode()) {
          case Olev::PAYMENT_METHOD_OLEV_CODE:
            $result->setData('is_available', false);
            break;
          case PaymentTerms::PAYMENT_METHOD_TERMS_CODE:
            $available = false;
            $customer = $observer->getQuote()->getCustomer();
              try {
                $zohoCustomerId = $this->_zohoCustomerRepository->getById($customer->getId())->getZohoId();
                $paymentTerms = $this->_zohoClient->getContact($zohoCustomerId)['payment_terms'] ?? 0;
                if ($paymentTerms > 0) {
                  $available = true;
                }
              } catch (\Exception $e) {
                // Ignore and do not enable payment method
              }
            $result->setData('is_available', $available);
            break;
          default:
            $result->setData('is_available', true);
            break;
        }
      }
    }
  }
}
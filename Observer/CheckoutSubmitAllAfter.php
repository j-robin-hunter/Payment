<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Observer;

use Magento\Framework\Event\ObserverInterface;
use RTech\Payment\Model\Terms;
use RTech\Zoho\Webservice\Client\ZohoBooksClient;

class CheckoutSubmitAllAfter implements ObserverInterface {

  protected $zohoClient;
  protected $zohoCustomerRepository;
  protected $priceHelper;
  protected $messageManager;

  public function __construct(
    \RTech\Zoho\Helper\ConfigData $zohoConfigData,
    \Zend\Http\Client $zendClient,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \RTech\Zoho\Model\ZohoCustomerRepository $zohoCustomerRepository,
    \Magento\Framework\Pricing\Helper\Data $priceHelper,
    \Magento\Framework\Message\ManagerInterface $messageManager
  ) {
    $this->zohoClient = new ZohoBooksClient($zohoConfigData, $zendClient, $storeManager);
    $this->zohoCustomerRepository = $zohoCustomerRepository;
    $this->priceHelper = $priceHelper;
    $this->messageManager = $messageManager;
  }

  public function execute(\Magento\Framework\Event\Observer $observer) {
    $order = $observer->getOrder();
    try {
      if ($order->getPayment()->getMethodInstance()->getCode() == Terms::PAYMENT_METHOD_TERMS_CODE) {
        $customerId = $order->getCustomerId();
        $zohoCustomerId = $this->zohoCustomerRepository->getById($customerId)->getZohoId();
        $contact = $this->zohoClient->getContact($zohoCustomerId);

        $creditLimit = $contact['credit_limit'] ?? 0;
        $remainingCredit = $creditLimit - $contact['outstanding_receivable_amount_bcy'] - $order->getTotalDue();
        if ($remainingCredit < 0 ) {
          $amountOver = $this->priceHelper->currency(abs($remainingCredit), true, false);
          $this->messageManager->addError(__('Regretfully this order exceeds the current credit limit by %1. Please arrange payment of this amount so that this order can be processed and dispatched.', $amountOver));
        }
      }
    } catch (\Exception $e) {
      $this->messageManager->addError(__('Unable to get credit information: %1', $e->getMessage()));
    }
  }
}
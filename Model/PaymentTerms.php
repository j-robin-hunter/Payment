<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Model;

class PaymentTerms extends \Magento\Payment\Model\Method\AbstractMethod {
  const PAYMENT_METHOD_TERMS_CODE = 'terms';

  protected $_code = self::PAYMENT_METHOD_TERMS_CODE;
  protected $_formBlockType = \RTech\Payment\Block\Form\PaymentTerms::class;
  protected $_infoBlockType = \RTech\Payment\Block\Info\Information::class;
  protected $_isOffline = true;
  protected $_customerSession;
  protected $_termsRepository;

  public function __construct(
    \Magento\Framework\Model\Context $context,
    \Magento\Framework\Registry $registry,
    \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
    \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
    \Magento\Payment\Helper\Data $paymentData,
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Payment\Model\Method\Logger $logger,
    \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
    \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
    array $data = [],
    \Magento\Directory\Helper\Data $directory = null,
    \Magento\Customer\Model\Session $customerSession,
    \RTech\Payment\Model\TermsRepository $termsRepository
  ) {
    parent::__construct(
      $context,
      $registry,
      $extensionFactory,
      $customAttributeFactory,
      $paymentData,
      $scopeConfig,
      $logger,
      $resource,
      $resourceCollection,
      $data,
      $directory
    );
    $this->_customerSession = $customerSession;
    $this->_termsRepository = $termsRepository;
  }

  public function getInformation() {
    $terms = '';

    $customer = $this->_customerSession->getCustomer()->getDataModel();
    $hasTerms = $customer->getCustomAttribute('payment_terms');

    if ($hasTerms) {
      $termsId = $hasTerms->getValue();
      $terms = $this->_termsRepository->getById($termsId)->getTerms();
    }

    return $terms;
  }
}
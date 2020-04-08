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
  protected $_infoBlockType = \RTech\Payment\Block\Info\PaymentTerms::class;
  protected $_isOffline = true;

  public function getInformation() {
    return $this->getConfigData('information');
  }
}
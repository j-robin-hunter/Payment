<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Model;

class Estimate extends \Magento\Payment\Model\Method\AbstractMethod {
  const PAYMENT_METHOD_ESTIMATE_CODE = 'estimate';

  protected $_code = self::PAYMENT_METHOD_ESTIMATE_CODE;
  protected $_formBlockType = \RTech\Payment\Block\Form\Estimate::class;
  protected $_infoBlockType = \RTech\Payment\Block\Info\Estimate::class;
  protected $_isOffline = true;
  protected $_canUseCheckout = false;

  public function getInformation() {
    return $this->getConfigData('information');
  }
}
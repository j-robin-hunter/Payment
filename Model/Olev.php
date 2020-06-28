<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Model;

class Olev extends \Magento\Payment\Model\Method\AbstractMethod {
  const PAYMENT_METHOD_OLEV_CODE = 'olev';

  protected $_code = self::PAYMENT_METHOD_OLEV_CODE;
  protected $_formBlockType = \RTech\Payment\Block\Form\Olev::class;
  protected $_infoBlockType = \RTech\Payment\Block\Info\Olev::class;
  protected $_isOffline = true;

  public function getInformation() {
    return $this->getConfigData('information');
  }
}
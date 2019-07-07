<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/

namespace RTech\Payment\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigData extends AbstractHelper
{
  const OLEV_PAYMENT_CATEGORIES = 'payment/olev/productcategories';

  public function __construct(
    ScopeConfigInterface $scopeConfig
  ) {
    $this->scopeConfig = $scopeConfig;
  }

  public function getOlevPaymentCategories($storeId) {
    return str_getcsv($this->scopeConfig->getValue(
      self::OLEV_PAYMENT_CATEGORIES,
      ScopeInterface::SCOPE_STORE,
      $storeId
    ));
  }
}
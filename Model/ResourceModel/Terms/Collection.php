<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Model\ResourceModel\Terms;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

  protected $_idFieldName = 'terms_id';

  protected function _construct() {
    $this->_init(\RTech\Payment\Model\Terms::class, \RTech\Payment\Model\ResourceModel\Terms::class);
  }
}
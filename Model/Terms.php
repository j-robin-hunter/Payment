<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use RTech\Payment\Api\Data\TermsInterface;

class Terms extends AbstractModel implements IdentityInterface, TermsInterface {

  const CACHE_TAG = 'rtech_payment_terms';

  protected $_cacheTag = self::CACHE_TAG;
  protected $_eventPrefix = self::CACHE_TAG;

  protected function _construct() {
    $this->_init(\RTech\Payment\Model\ResourceModel\Terms::class);
  }

  /**
  * Return unique ID(s)
  *
  * @return string[]
  */
  public function getIdentities() {
    return [self::CACHE_TAG . '_' . $this->getId()];
  }

  /**
  * @inheritdoc
  */
  public function getId() {
    return $this->getData(self::TERMS_ID);
  }

  /**
  * @inheritdoc
  */
  public function setId($termsId) {
    return $this->setData(self::TERMS_ID, $termsId);
  }

  /**
  * @inheritdoc
  */
  public function getTermsName() {
    return $this->getData(self::TERMS_NAME);
  }

  /**
  * @inheritdoc
  */
  public function setTermsName($termsName) {
    return $this->setData(self::TERMS_NAME, $termsName);
  }

  /**
  * @inheritdoc
  */
  public function getTerms() {
    return $this->getData(self::TERMS);
  }

  /**
  * @inheritdoc
  */
  public function setTerms($terms) {
    return $this->setData(self::TERMS, $terms);
  }

  /**
  * @inheritdoc
  */
  public function getCreatedAt() {
    return $this->getData(self::CREATED_AT);
  }

  /**
  * @inheritdoc
  */
  public function setCreatedAt($date) {
    return $this->setData(self::CREATED_AT, $date);
  }


  /**
  * @inheritdoc
  */
  public function getUpdatedAt() {
    return $this->getData(self::UPDATED_AT);
  }

  /**
  * @inheritdoc
  */
  public function setUpdatedAt($date) {
    return $this->setData(self::UPDATED_AT, $date);
  }

}
<?php
/**
 * Copyright © 2019 Roma Technology Limited. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Payment\Api\Data;

interface TermsInterface {
  const TERMS_ID = 'terms_id';
  const TERMS_NAME = "terms_name";
  const TERMS = "terms";
  const CREATED_AT = 'created_at';
  const UPDATED_AT = 'updated_at';

  /**
  * Get terms id
  *
  * @return int|null
  */
  public function getId();

  /**
  * Set terms id
  *
  * @param int $termsId
  * @return $this
  */
  public function setId($termsId);

  /**
  * Get terms name
  *
  * @return string|null
  */
  public function getTermsName();

  /**
  * Set terms name
  *
  * @param string $termsName
  * @return $this
  */
  public function setTermsName($termsName);

  /**
  * Get terms
  *
  * @return string|null
  */
  public function getTerms();

  /**
  * Set terms
  *
  * @param string $terms
  * @return $this
  */
  public function setTerms($terms);

  /**
  * Get created at date
  *
  * @return Date|null
  */
  public function getCreatedAt();

  /**
  * Set create at date
  *
  * @param Date $date
  * @return $this
  */
  public function setCreatedAt($date);

  /**
  * Get update at date
  *
  * @return Date|null
  */
  public function getUpdatedAt();

  /**
  * Set update at date
  *
  * @param Date $date
  * @return $this
  */
  public function setUpdatedAt($date);

}
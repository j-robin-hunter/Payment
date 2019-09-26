<?php
/**
 * Copyright © 2019 Roma Technology Limited. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Payment\Api;

use RTech\Payment\Api\Data\TermsInterface;

interface TermsRepositoryInterface {

  /**
  * Retrive by terms id
  *
  * @param int $termsId
  * @return \RTech\Payment\Api\Data\TermsInterface
  * @throws \Magento\Framework\Exception\NoSuchEntityException
  */
  public function getById($termsId);

  /**
  * @param \RTech\Payment\Api\Data\TermsInterface $terms
  * @return \RTech\Payment\Api\Data\TermsInterface
  * @throws \Magento\Framework\Exception\CouldNotSaveException
  */
  public function save(TermsInterface $terms);

  /**
  * @param \RTech\Payment\Api\Data\TermsInterface $terms
  * @return bool true on success
  * @throws \Magento\Framework\Exception\CouldNotDeleteException
  */
  public function delete(TermsInterface $terms);

  /**
  * Retrieve models matching the specified criteria.
  *
  * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
  * @return \RTech\Payment\Api\Data\TermsSearchResultsInterface
  * @throws \Magento\Framework\Exception\LocalizedException
  */
  public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
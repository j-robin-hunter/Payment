<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Helper;

use RTech\Payment\Exception\InUseException;

class DeleteHelper {

  protected $_termsRepository;
  protected $_resourceConnection;

  public function __construct(
    \RTech\Payment\Model\TermsRepository $termsRepository,
    \Magento\Framework\App\ResourceConnection $resourceConnection
  ) {
    $this->_termsRepository = $termsRepository;
    $this->_resourceConnection = $resourceConnection;
  }

  public function deleteTerms($termsId) {
    $terms = $this->_termsRepository->getById($termsId);

    $connection = $this->_resourceConnection->getConnection();
    $query = "SELECT entity_id " .
      "FROM `customer_entity_int` AS cei, `eav_attribute` AS ea " .
      "WHERE cei.attribute_id = ea.attribute_id " .
      "AND ea.attribute_code = 'payment_terms' " .
      "AND cei.value = " . $termsId;

    $collection = $connection->fetchAll($query);
    if (count($collection) > 0) {
      throw new InUseException($collection[0]['entity_id']);
    }
    $this->_termsRepository->delete($terms);
  }
}
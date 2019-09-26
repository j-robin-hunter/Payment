<?php
/**
*
* Copyright © Magento, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Model\Terms;

use RTech\Payment\Model\ResourceModel\Terms\CollectionFactory;
use RTech\Payment\Api\Data\TermsInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider {

  protected $_loadedData;

  public function __construct(
    $name,
    $primaryFieldName,
    $requestFieldName,
    CollectionFactory $termsCollectionFactory,
    array $meta = [],
    array $data = []
  ) {
    $this->collection = $termsCollectionFactory->create();
    parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
  }

  public function getData() {

    if (isset($this->_loadedData)) {
      return $this->_loadedData;
    }

    $termsData = [];
    $items = $this->collection->getItems();
    foreach ($items as $terms) {
      $termsData['terms_id'] = $terms->getId();
      $termsData['terms_name'] = $terms->getTermsName();
      $termsData['terms'] = $terms->getTerms();

      $this->_loadedData[$terms->getId()] = $termsData;
    }

    return $this->_loadedData;
  }
}
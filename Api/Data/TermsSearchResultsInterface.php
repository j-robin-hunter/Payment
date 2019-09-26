<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TermsSearchResultsInterface extends SearchResultsInterface {

  /**
  * Get terms
  *
  * @return \RTech\Payment\Api\Data\TermsInterface[]
  */
  public function getItems();

  /**
  * Set terms
  *
  * @param \RTech\Payment\Api\Data\TermsInterface[] $items
  * @return $this
  */
  public function setItems(array $items);
}
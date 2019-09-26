<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Model\Customer\Attribute\Source;

use Magento\Customer\Api\GroupManagementInterface;

class Terms extends \Magento\Eav\Model\Entity\Attribute\Source\Table {

  protected $_termsCollection;

  public function __construct(
    \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
    \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory,
    \RTech\Payment\Model\ResourceModel\Terms\Collection $termsCollection
  ) {
    $this->_termsCollection = $termsCollection;
    parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
  }

  public function getAllOptions($withEmpty = true, $defaultValues = false) {
    if (!$this->_options) {
      $this->_options[] = [
        'value' => '',
        'label' => ' '
      ];
      foreach ($this->_termsCollection->getItems() as $item) {
        $this->_options[] = [
          'value' => $item->getId(),
          'label' => $item->getTermsName()
        ];
      }
    }
    return $this->_options;
  }
}
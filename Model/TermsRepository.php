<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Model;

use RTech\Payment\Api\TermsRepositoryInterface;
use RTech\Payment\Model\ResourceModel\Terms\CollectionFactory as TermsCollectionFactory;
use RTech\Payment\Model\ResourceModel\Terms\Collection;
use RTech\Payment\Api\Data\TermsSearchResultsInterface;
use RTech\Payment\Api\Data\TermsSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;

class TermsRepository implements TermsRepositoryInterface {

  protected $termsFactory;
  protected $termsCollectionFactory;
  protected $termsSearchResultsFactory;

  public function __construct(
    TermsFactory $termsFactory,
    TermsCollectionFactory $termsCollectionFactory,
    TermsSearchResultsInterfaceFactory $termsSearchResultsFactory
  ) {
    $this->termsFactory = $termsFactory;
    $this->termsCollectionFactory = $termsCollectionFactory;
    $this->termsSearchResultsFactory = $termsSearchResultsFactory;
  }

  /**
  * @inheritdoc
  */
  public function getById($termsId) {
    $terms = $this->termsFactory->create();
    $response = $terms->getResource()->load($terms, $termsId);
    if (!$terms->getId()) {
      throw new NoSuchEntityException(__('No Payment Terms with id "%1" exists.', $termsId));
    }
    return $terms;
  }

  /**
  * @inheritdoc
  */
  public function save($terms) {
    try {
      $terms->getResource()->save($terms);
    } catch (\Exception $exception) {
      throw new CouldNotSaveException(__($exception->getMessage()));
    }
  }

  /**
  * @inheritdoc
  */
  public function delete($terms) {
    try {
      return $terms->getResource()->delete($terms);
    } catch (\Exception $exception) {
      throw new CouldNotDeleteException(__($exception->getMessage()));
    }
  }

  /**
  * @inheritdoc
  */
  public function getList(SearchCriteriaInterface $searchCriteria) {
    $collection = $this->termsCollectionFactory->create();
    $this->addFiltersToCollection($searchCriteria, $collection);
    $collection->setPageSize($searchCriteria->getPageSize());
    $collection->setCurPage($searchCriteria->getCurrentPage());
    $collection->load();
    return $this->buildSearchResult($searchCriteria, $collection);
  }

  private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection) {
    foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
      $fields = $conditions = [];
      foreach ($filterGroup->getFilters() as $filter) {
        $fields[] = $filter->getField();
        $conditions[] = [$filter->getConditionType() => $filter->getValue()];
      }
      $collection->addFieldToFilter($fields, $conditions);
    }

    foreach ($searchCriteria->getSortOrders() as $sortOrder) {
      $collection->setOrder($sortOrder->getField(), $sortOrder->getDirection());
    }
  }

  private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection) {
    $searchResults = $this->termsSearchResultsFactory->create();
    $searchResults->setSearchCriteria($searchCriteria);
    $searchResults->setItems($collection->getItems());
    $searchResults->setTotalCount($collection->getSize());
    return $searchResults;
  }
}
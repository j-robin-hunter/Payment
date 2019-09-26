<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Controller\Adminhtml\Terms;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action {

  protected $_termsRepository;

  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \RTech\Payment\Model\TermsRepository $termsRepository
  ) {
    $this->_termsRepository = $termsRepository;
    parent::__construct($context);
  }

  public function execute() {
    $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

    $termsId = $this->getRequest()->getParam('terms_id');
    if ($termsId) {
      $terms = $this->_termsRepository->getById($termsId);
      $resultPage->getConfig()->getTitle()->prepend($terms->getTermsName());
    } else {
      $resultPage->getConfig()->getTitle()->prepend(__('New Terms'));
    }

    return $resultPage;
  }
}
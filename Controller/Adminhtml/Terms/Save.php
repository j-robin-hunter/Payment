<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Controller\Adminhtml\Terms;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use RTech\Payment\Api\Data\TermsInterface;

class Save extends \Magento\Backend\App\Action {

  protected $_termsFactory;
  protected $_termsRepository;

  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \RTech\Payment\Model\TermsFactory $termsFactory,
    \RTech\Payment\Model\TermsRepository $termsRepository
  ) {
    $this->_termsFactory = $termsFactory;
    $this->_termsRepository = $termsRepository;
    parent::__construct($context);
  }

  public function execute() {
    $terms = $this->_termsFactory->create();
    $terms->setData([
      TermsInterface::TERMS_ID => $this->getRequest()->getParam('terms_id'),
      TermsInterface::TERMS_NAME => $this->getRequest()->getParam('terms_name'),
      TermsInterface::TERMS => $this->getRequest()->getParam('terms')
    ]);
    $this->_termsRepository->save($terms);
    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
    return $resultRedirect->setPath('*/*/');;
  }
}
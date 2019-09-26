<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Controller\Adminhtml\Terms;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action implements HttpGetActionInterface {

  public function __construct(
    \Magento\Backend\App\Action\Context $context
  ) {
    parent::__construct($context);
  }

  public function execute() {
    $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    $resultPage->getConfig()->getTitle()->prepend(__('Payment Terms'));
    return $resultPage;
  }
}
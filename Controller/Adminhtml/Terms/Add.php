<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Controller\Adminhtml\Terms;

use \Magento\Backend\App\Action;

class Add extends Action {

  protected $resultForwardFactory;

  public function __construct(
   \Magento\Backend\App\Action\Context $context,
    \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
  ) {
    parent::__construct($context);
    $this->resultForwardFactory = $resultForwardFactory;
  }

  public function execute() {
    $resultForward = $this->resultForwardFactory->create();
    return $resultForward->forward('edit');
  }
}
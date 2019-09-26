<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Controller\Adminhtml\Terms;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use RTech\Attachments\Api\Data\AttachmentInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use RTech\Payment\Exception\InUseException;

class MassDelete extends \Magento\Backend\App\Action {

  protected $_deleteHelper;
  protected $_filter;
  protected $_collectionFactory;

  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \RTech\Payment\Helper\DeleteHelper $deleteHelper,
    \Magento\Ui\Component\MassAction\Filter $filter,
    \RTech\Payment\Model\ResourceModel\Terms\CollectionFactory $collectionFactory
  ) {
    $this->_deleteHelper = $deleteHelper;
    $this->_filter = $filter;
    $this->_collectionFactory = $collectionFactory;
    parent::__construct($context);
  }

  public function execute() {
    $resultPage = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
    try {
      $collection = $this->_filter->getCollection($this->_collectionFactory->create());
      $collectionSize = $collection->getSize();
      foreach ($collection as $terms) {
        $this->_deleteHelper->deleteTerms($terms->getId());
      }
      $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
    } catch (InUseException $e) {
        $this->messageManager->addErrorMessage(__('Payment terms are in use by customer "%1".', $e->getMessage()));
    } catch (LocalizedException $e) {
      $this->messageManager->addErrorMessage($e->getMessage());
    } catch (\Exception $e) {
      $this->messageManager->addExceptionMessage($e, __('An error occurred while deleting record(s).'));
    }
    $resultPage->setPath('payment/terms/index');
    return $resultPage;
  }
}
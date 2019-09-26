<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Controller\Adminhtml\Terms;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use RTech\Payment\Api\Data\TermsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use RTech\Payment\Exception\InUseException;

class Delete extends \Magento\Backend\App\Action {

  protected $_deleteHelper;

  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \RTech\Payment\Helper\DeleteHelper $deleteHelper
  ) {
    $this->_deleteHelper = $deleteHelper;
    parent::__construct($context);
  }

  public function execute() {
    $resultPage = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
    $termsId = $this->getRequest()->getParam('terms_id');
    if ($termsId) {
      try {
        $this->_deleteHelper->deleteTerms($termsId);
        $this->messageManager->addSuccessMessage(__('The payment terms has been deleted.'));
      } catch (InUseException $e) {
        $this->messageManager->addErrorMessage(__('Payment terms are in use by customer "%1".', $e->getMessage()));
      } catch (NoSuchEntityException $e) {
        $this->messageManager->addErrorMessage(__('The payment terms no longer exists.'));
      } catch (LocalizedException $e) {
        $this->messageManager->addErrorMessage($e->getMessage());
      } catch (\Exception $e) {
        $this->messageManager->addErrorMessage(__('There was a problem deleting the payment terms'));
      }
    }
    $resultPage->setPath('payment/terms/index');
    return $resultPage;
  }
}
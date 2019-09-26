<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Block\Form;

class PaymentTerms extends \Magento\Payment\Block\Form {

  protected $_template = 'RTech_Payment::form/terms.phtml';
  protected $_customerSession;
  protected $_termsRepository;

  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Customer\Model\Session $customerSession,
    \RTech\Payment\Model\TermsRepository $termsRepository,
    array $data = []
  ) {
    $this->_customerSession = $customerSession;
    $this->termsRepository = $termsRepository;
    parent::__construct($context, $data);
  }

}
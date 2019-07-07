<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Block\Info;

class Information extends \Magento\Payment\Block\Info {
  protected $_information;
  protected $_template = 'RTech_Payment::info/information.phtml';

  public function getInstructions()
  {
    if ($this->_information === null) {
      $this->_information = $this->getInfo()->getAdditionalInformation(
        'information'
      ) ?: trim($this->getMethod()->getConfigData('information'));
    }
    return $this->_information;
  }
}
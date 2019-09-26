<?php
/**
*
* Copyright © Magento, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Block\Adminhtml\Terms\Edit;

class GenericButton {

  protected $urlBuilder;

  public function __construct(
    \Magento\Backend\Block\Widget\Context $context
  ) {
    $this->urlBuilder = $context->getUrlBuilder();
  }

  public function getUrl($route = '', $params = []) {
    return $this->urlBuilder->getUrl($route, $params);
  }
}
<?php
/**
*
* Copyright © Magento, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Block\Adminhtml\Terms\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface {

  public function getButtonData() {
    return [
      'label' => __('Save'),
      'class' => 'save primary',
      'data_attribute' => [
        'mage-init' => ['button' => ['event' => 'save']],
        'form-role' => 'save',
      ],
      'sort_order' => 90,
    ];
  }
}
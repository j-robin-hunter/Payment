<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class PostActions extends Column {

  const EDIT = 'payment/terms/edit';
  const DELETE = 'payment/terms/delete';

  protected $urlBuilder;

  public function __construct(
    \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
    \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
    \Magento\Framework\UrlInterface $urlBuilder,
    array $components = [],
    array $data = []
  ) {
    $this->urlBuilder = $urlBuilder;
    parent::__construct($context, $uiComponentFactory, $components, $data);
  }

  public function prepareDataSource($dataSource) {

    if (isset($dataSource['data']['items'])) {
      foreach ($dataSource['data']['items'] as & $item) {
        $name = $this->getData('name');
        if (isset($item['terms_id'])) {
          $item[$name]['edit'] = [
            'href' => $this->urlBuilder->getUrl(self::EDIT, ['terms_id' => $item['terms_id']]),
            'label' => __('Edit')
          ];
          $item[$name]['delete'] = [
            'href' => $this->urlBuilder->getUrl(self::DELETE, ['terms_id' => $item['terms_id']]),
            'label' => __('Delete'),
            'confirm' => [
              'title' => __('Delete'),
              'message' => __('Are you sure you wan\'t to delete this record?')
            ]
          ];
        }
      }
    }
    return $dataSource;
  }
}
<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Payment\Setup;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallData implements InstallDataInterface {

  const PAYMENT_TERMS_ATTRIBUTE_CODE = 'payment_terms';

  private $eavSetup;
  private $eavConfig;

  public function __construct(
    \Magento\Eav\Setup\EavSetup $eavSetup,
    \Magento\Eav\Model\Config $eavConfig
  ) {
    $this->eavSetup = $eavSetup;
    $this->eavConfig = $eavConfig;
  }

  public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {

    $setup->startSetup();

    $this->eavSetup->addAttribute(
      CustomerMetadataInterface:: ENTITY_TYPE_CUSTOMER,
      self::PAYMENT_TERMS_ATTRIBUTE_CODE,
      [
        'type' => 'int',
        'label' => 'Payment Terms',
        'input' => 'select',
        'source' => 'RTech\Payment\Model\Customer\Attribute\Source\Terms',
        'visible' => true,
        'required' => false,
        'position' => 140,
        'sort_order' => 140,
        'system' => false
      ]
    );

    $paymentTermsAttribute = $this->eavConfig->getAttribute(
      CustomerMetadataInterface:: ENTITY_TYPE_CUSTOMER,
      self::PAYMENT_TERMS_ATTRIBUTE_CODE
    );
    $paymentTermsAttribute->setData(
      'used_in_forms',
      ['adminhtml_customer', 'customer_account_create', 'customer_account_edit']
    );
    $paymentTermsAttribute->save();

    $setup->endSetup();
  }
}
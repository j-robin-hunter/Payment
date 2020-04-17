/**
* Copyright 2019 © Roma Technology Ltd. All rights reserved.
* See COPYING.txt for license details.
**/
define([
  'Magento_Checkout/js/view/payment/default',
  'Magento_Customer/js/customer-data'
], function (Component, customerData) {
  'use strict';

  return Component.extend({
    defaults: {
      template: 'RTech_Payment/payment/terms'
    },

    getInformation: function () {
      return window.checkoutConfig.payment.information[this.item.method];
    },
    
    getBaseUrl: function() {
      return require.s.contexts._.config.baseUrl;
    }
  });
});
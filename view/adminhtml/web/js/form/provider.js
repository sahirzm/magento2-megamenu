define([
    'jquery',
    'Magento_Ui/js/form/provider'
    ], function($, Provider) {
        'use strict';
        console.log(Provider);
        return Provider.extend({
            initialize: function() {
                console.log("Hurray, my init.");
                return this._super();
            }
        });
    });

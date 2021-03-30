define([
    'jquery',
    'mage/translate',
    'mage/storage',
    'mageUtils',
    'uiComponent'
], function (
    $,
    $t,
    storage,
    utils,
    Component,
    customerData
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magespace_PostComment/comment_form'
        },
        initialize(){
            this._super();
            return this;
        }
    });
});

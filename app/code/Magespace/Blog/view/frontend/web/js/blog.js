define(['uiComponent'], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magespace_Blog/blog'
        },
        initialize: function () {
            this._super();
            return this;
        },
        getDate: function (value) {
            const date = new Date(value);
            return date.getMonth() + ' ' + date.getDate() + ', ' + date.getFullYear();
        }
    });
});

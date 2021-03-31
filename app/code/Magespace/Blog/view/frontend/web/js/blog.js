define([
    'jquery',
    'uiComponent'
], function (
    $,
    Component
) {
    'use strict';

    let page = 1;
    return Component.extend({
        defaults: {
            template: 'Magespace_Blog/blog'
        },
        initialize: function () {
            this._super();
            this.posts = this.getPosts(this.page);
            return this;
        },
        getDate: (value) => {
            const date = new Date(value);
            return date.getMonth() + ' ' + date.getDate() + ', ' + date.getFullYear();
        },

        getPosts: (page) => {
            let tmp = null;
            $.ajax({
                async: false,
                global: false,
                url: "/blog/index/get?page="+page,
                method: 'GET',
                success: function (data) {
                    tmp = data;
                }
            });
            return tmp;
        }
    });
});

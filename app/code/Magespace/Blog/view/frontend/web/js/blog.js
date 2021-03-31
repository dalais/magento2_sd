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
        initialize: function (config) {
            this._super();
            let posts = this.getPosts(config.page);
            page = parseInt(config.page)
            this.posts = posts.data;
            return this;
        },
        getDate: (value) => {
            const date = new Date(value);
            return date.getMonth() + ' ' + date.getDate() + ', ' + date.getFullYear();
        },

        getPosts: (page) => {
            let tmp = {
                data: [],
                limit: 0,
                total: 0
            };
            $.ajax({
                async: false,
                global: false,
                url: "/blog/index/get?page=" + page,
                method: 'GET',
                success: function (res) {
                    tmp.data = res.data;
                    tmp.limit = res.limit;
                    tmp.total = res.total;
                }
            });
            return tmp;
        },

        prevPage: () => {
            if (page > 1) {
                page--;
                this.changePage(page);
            }
        },

        nextPage: () => {
            if (page < this.numPages()) {
                page++;
                this.changePage(page);
            }
        },

        changePage: (page) => {
            var btn_next = document.getElementById("btn_next");
            var btn_prev = document.getElementById("btn_prev");

            // Validate page
            if (page < 1) {
                page = 1
            }
            if (page > this.numPages()) {
                page = this.numPages();
            }

            if (page === 1) {
                btn_prev.style.visibility = "hidden";
            } else {
                btn_prev.style.visibility = "visible";
            }

            if (page === this.numPages()) {
                btn_next.style.visibility = "hidden";
            } else {
                btn_next.style.visibility = "visible";
            }
        },
        numPages: () => {
            return Math.ceil(this.total/this.limit);
        }
    });
});

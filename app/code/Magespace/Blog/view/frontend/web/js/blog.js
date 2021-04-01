define([
    'jquery',
    'uiComponent',
    'domReady!'
], function (
    $,
    Component
) {
    'use strict';

    let page = 1;
    let limit = 0;
    let total = 0;
    let numPages = 1;

    let getQuery = (page) => {
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
                tmp.page = res.page;
                tmp.limit = res.limit;
                tmp.total = res.total;
                tmp.num_pages = res.num_pages;
            }
        });
        return tmp;
    };

    let changePage = (page) => {
        let btn_next = document.getElementById("btn_next");
        let btn_prev = document.getElementById("btn_prev");

        // Validate page
        if (page < 1) {
            page = 1
        }
        if (page > numPages) {
            page = numPages;
        }

        if (page === 1) {
            btn_prev.style.visibility = "hidden";
        } else {
            btn_prev.style.visibility = "visible";
        }

        if (page === numPages) {
            btn_next.style.visibility = "hidden";
        } else {
            btn_next.style.visibility = "visible";
        }
    };

    return Component.extend({
        defaults: {
            template: 'Magespace_Blog/blog'
        },
        initialize: function (config) {
            this._super();
            this.getPosts(config.page)
            console.log(this.posts);

            return this;
        },
        getDate: (value) => {
            const date = new Date(value);
            return date.getMonth() + ' ' + date.getDate() + ', ' + date.getFullYear();
        },

        getPosts(pageArg) {
            let res = getQuery(pageArg);
            page = res.page;
            total = res.total;
            limit = res.limit;
            numPages = res.num_pages;
            this.posts = res.data;
        },

        prevNextBtns: () => {
            let btn_prev = document.getElementById("btn_prev");
            let btn_next = document.getElementById("btn_next");

            if (page < 2) {
                btn_prev.style.visibility = 'hidden';
            }
            if (numPages === 1 || page === numPages || page > numPages) {
                btn_next.style.visibility = 'hidden';
            }
        },

        prevPage: () => {
            if (page > 1) {
                page--;
                changePage(page);
            }
        },

        nextPage: () => {
            if (page < numPages) {
                page++;
                changePage(page);
            }
        },
    });
});

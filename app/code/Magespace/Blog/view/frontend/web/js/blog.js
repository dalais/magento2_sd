define([
    'jquery',
    'ko',
    'uiComponent',
    'domReady!'
], function (
    $,
    ko,
    Component
) {
    'use strict';

    let page = 1;
    let limit = 0;
    let total = 0;
    let numPages = 1;

    return Component.extend({
        defaults: {
            template: 'Magespace_Blog/blog'
        },

        posts: ko.observable([]),
        blogPages: ko.observable([numPages]),

        initObservable: function () {
            this._super();
            this.observe('posts');
            this.observe('blogPages');
            return this;
        },

        initialize: function (config) {
            self = this;
            this._super();
            self.getPosts(config.page);
            this.blogPages(this.pagesArray(numPages));
            return this;
        },

        getDate: (value) => {
            const date = new Date(value);
            return date.getMonth() + ' ' + date.getDate() + ', ' + date.getFullYear();
        },

        getPosts(pageArg) {
            let res = self.getQuery(pageArg);
            page = res.page;
            total = res.total;
            limit = res.limit;
            numPages = res.num_pages;
            this.posts(res.data);
        },

        preparePager: () => {
            if (page < 2) {
                self.statePrevNxtBtns('btn_prev')
            }
            if (numPages === 1 || page === numPages || page > numPages) {
                self.statePrevNxtBtns('btn_prev')
            }
            if (numPages <= 1) {
                document.getElementsByClassName('pagination')[0].setAttribute('style','display:none')
            }
        },

        prevPage: () => {
            if (page > 1) {
                page--;
                self.changePage(page);
                self.getPosts(page);
                self.urlState();
            }
        },

        nextPage: () => {
            if (page < numPages) {
                page++;
                self.changePage(page);
                self.getPosts(page);
                self.urlState();
            }
        },

        changePage: (page) => {
            // Validate page
            if (page < 1) {
                page = 1
            }
            if (page > numPages) {
                page = numPages;
            }

            if (page === 1) {
                self.statePrevNxtBtns('btn_prev')
            } else {
                self.statePrevNxtBtns('btn_prev','show')
            }

            if (page === numPages) {
                self.statePrevNxtBtns('btn_next')
            } else {
                self.statePrevNxtBtns('btn_next','show')
            }
        },

        statePrevNxtBtns: (id,command) => {
            let btn = document.getElementById(id);
            if (command === undefined) {
                btn.style.visibility = 'hidden';
            } else {
                btn.style.visibility = 'visible';
            }
        },

        getQuery: (page) => {
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
        },

        pagesArray:(number) => {
            const arr = [];
            for (var i = 0; i < number; i++) {
                let index = i+1;
                arr.push(index);
            }
            return arr;
        },

        pageBtn: (e,pageNumber) => {
            self.getPosts(pageNumber);
            if (pageNumber === 1) {
                self.urlState('');
                self.statePrevNxtBtns('btn_prev')
                if (numPages > 1) {
                    self.statePrevNxtBtns('btn_next','show')
                }
            }
            if (pageNumber > 1) {
                self.urlState('?page='+pageNumber);
            }
            if (pageNumber > 1 && pageNumber === numPages) {
                self.statePrevNxtBtns('btn_next')
                self.statePrevNxtBtns('btn_prev','show')
            }
        },

        urlState: (params) => {
            if (params !== undefined) {
                let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + params;
                window.history.pushState({path:newurl},'',newurl);
            } else {
                if (page > 1) {
                    let newurl = window.location.protocol + "//"
                        + window.location.host
                        + window.location.pathname + '?page='+page;
                    window.history.pushState({path:newurl},'',newurl);
                } else {
                    let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                    window.history.pushState({path:newurl},'',newurl);
                }
            }
        }
    });
});

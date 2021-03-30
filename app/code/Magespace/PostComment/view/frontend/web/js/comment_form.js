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
    Component
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magespace_PostComment/comment_form'
        },
        initialize() {
            this._super();
            return this;
        },
        sendComment() {
            $.ajax({
                url: "/comment/index/post",
                method: 'POST',
                data:{
                    content: document.getElementById('comment-area').value
                },
            }).done(function(response) {
                if (response.validation_error !== undefined) {
                    $('#comment-error').text(response.validation_error);
                    setTimeout(function (){
                        $('#comment-error').html('&nbsp;');
                    },1500)
                }
                if (response.success !== undefined) {
                    $('#comment-success').text(response.success);
                    setTimeout(function (){
                        $('#comment-error').html('&nbsp;');
                    },3000)
                }
            })
        }
    });
});

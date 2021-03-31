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

    let postId = null;
    return Component.extend({
        defaults: {
            template: 'Magespace_PostComment/comment_form'
        },
        initialize(config) {
            this._super();
            postId = config.post_id
            return this;
        },
        sendComment() {
            $.ajax({
                url: "/comment/index/post/post_id/"+postId,
                method: 'POST',
                data:{
                    content: document.getElementById('comment-area').value
                },
            }).done(function(response) {
                if (response.validation_error !== undefined) {
                    $('#comment-error').text(response.validation_error);
                    setTimeout(function (){
                        $('#comment-error').html('&nbsp;');
                    },2000)
                }
                if (response.success !== undefined) {
                    $('#comment-success').text(response.success);
                    $('#comment-area').val('');
                    setTimeout(function (){
                        $('#comment-success').html('&nbsp;');
                    },6000)
                }
            })
        }
    });
});

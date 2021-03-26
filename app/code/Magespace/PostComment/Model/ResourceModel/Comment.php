<?php

namespace Magespace\PostComment\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Comment
 * @package Magespace\PostComment\Model\ResourceModel
 */
class Comment extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('magespace_blog_page_post_comment','comment_id');
    }
}

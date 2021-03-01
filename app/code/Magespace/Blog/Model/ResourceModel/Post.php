<?php

namespace Magespace\Blog\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('magespace_blog_page_post','post_id');
    }
}

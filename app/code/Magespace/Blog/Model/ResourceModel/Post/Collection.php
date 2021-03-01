<?php

namespace Magespace\Blog\Model\ResourceModel\Post;

use Magespace\Blog\Model\ResourceModel\Post as PostResource;
use Magespace\Blog\Model\Post;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function __construct()
    {
        $this->_init(Post::class, PostResource::class);
    }

}

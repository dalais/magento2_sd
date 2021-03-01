<?php

namespace Magespace\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Magespace\Blog\Api\Data\PostInterface;
use Magespace\Blog\Model\ResourceModel\Post as PostResource;

class Post extends AbstractModel implements PostInterface
{
    protected function __construct() {
        $this->_init(PostResource::class);
    }
}

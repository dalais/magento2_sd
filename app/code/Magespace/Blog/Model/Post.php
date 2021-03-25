<?php

namespace Magespace\Blog\Model;

use Magespace\Blog\Api\Data\PostInterface;

/**
 * Class Post
 */
class Post extends \Magento\Framework\Model\AbstractModel implements PostInterface
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(\Magespace\Blog\Model\ResourceModel\Post::class);
    }
}

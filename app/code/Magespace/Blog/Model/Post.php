<?php

namespace Magespace\Blog\Model;

/**
 * Class Post
 */
class Post extends \Magento\Framework\Model\AbstractModel implements
    \Magespace\Blog\Api\Data\PostInterface
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(\Magespace\Blog\Model\ResourceModel\Post::class);
    }
}

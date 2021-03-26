<?php

namespace Magespace\PostComment\Model\ResourceModel\Post;

/**
 * Class Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(
            \Magespace\PostComment\Model\Comment::class,
            \Magespace\PostComment\Model\ResourceModel\Comment::class
        );
    }
}

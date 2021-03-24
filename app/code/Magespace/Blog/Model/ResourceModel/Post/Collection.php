<?php

namespace Magespace\Blog\Model\ResourceModel\Post;

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
            \Magespace\Blog\Model\Post::class,
            \Magespace\Blog\Model\ResourceModel\Post::class
        );
    }
}

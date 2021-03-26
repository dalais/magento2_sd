<?php

namespace Magespace\PostComment\Model;

/**
 * Class Comment
 * @package Magespace\PostComment\Model
 */
class Comment extends \Magento\Framework\Model\AbstractModel implements
    \Magespace\PostComment\Api\Data\CommentInterface
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(\Magespace\PostComment\Model\ResourceModel\Comment::class);
    }
}

<?php

namespace Magespace\Blog\Model;

/**
 * Class Post
 */
class Post extends \Magento\Framework\Model\AbstractModel implements
    \Magespace\Blog\Api\Data\PostInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'magespace_blog_page_post';

    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(\Magespace\Blog\Model\ResourceModel\Post::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}

<?php

namespace Magespace\Blog\Service;

use Magento\Framework\Exception\AlreadyExistsException;
use Magespace\Blog\Api\Data\PostInterface;
use Magespace\Blog\Api\PostManagementInterface;
use Magespace\Blog\Model\Post as PostFactory;
use Magespace\Blog\Model\ResourceModel\Post as PostResource;

class PostManagement implements PostManagementInterface
{
    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var PostResource
     */
    private $resource;

    /**
     * PostManagement constructor.
     * @param PostFactory $postFactory
     * @param PostResource $resource
     */
    public function __construct(
        PostFactory $postFactory,
        PostResource $resource
    ) {
        $this->postFactory = $postFactory;
        $this->resource = $resource;
    }

    /**
     * @return PostInterface
     */
    public function getEmptyObject(): PostInterface
    {
        return $this->postFactory->create();
    }

    /**
     * @param PostInterface $post
     * @throws AlreadyExistsException
     */
    public function save(PostInterface $post)
    {
        $this->resource->save($post);
    }
}

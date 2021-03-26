<?php

namespace Magespace\Blog\Service;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magespace\Blog\Api\Data\PostInterface;
use Magespace\Blog\Api\PostManagementInterface;
use Magespace\Blog\Api\PostRepositoryInterface;
use Magespace\Blog\Model\Post;
use Magespace\Blog\Model\ResourceModel\Post as PostResource;
use Magespace\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * Class PostRepository
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var PostResource
     */
    private $resource;

    /**
     * @var PostManagementInterface
     */
    private $postManagement;

    /**
     * @var PostCollectionFactory
     */
    private $postCollectionFactory;

    /**
     * PostRepository constructor.
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PostResource $resource
     * @param PostManagementInterface $postManagement
     * @param PostCollectionFactory $postCollectionFactory
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PostResource $resource,
        PostManagementInterface $postManagement,
        PostCollectionFactory $postCollectionFactory
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resource = $resource;
        $this->postManagement = $postManagement;
        $this->postCollectionFactory = $postCollectionFactory;
    }

    /**
     * @return \Magento\Cms\Api\Data\PageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get()
    {
        $postCollection = $this->postCollectionFactory->create();
        $postCollection->addFieldToFilter('is_post',['eq' => 1]);

        $pageIds = [];

        /** @var Post $post */
        foreach ($postCollection->getItems() as $post) {
            $pageIds[] = $post->getData('page_id');
        }

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('page_id',$pageIds,'in')
            ->addFilter('is_active',1)
            ->create();
        return $this->pageRepository->getList($searchCriteria);
    }

    /**
     * @param int $pageId
     * @return PostInterface
     */
    public function getByPageId($pageId): PostInterface
    {
        $post = $this->postManagement->getEmptyObject();
        $this->resource->load($post, $pageId, 'page_id');
        return $post;
    }
}

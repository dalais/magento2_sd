<?php

namespace Magespace\Blog\Service;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magespace\Blog\Api\Data\PostInterface;
use Magespace\Blog\Api\PostManagementInterface;
use Magespace\Blog\Api\PostRepositoryInterface;
use Magespace\Blog\Model\ResourceModel\Post as PostResource;

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
     * PostRepository constructor.
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PostResource $resource
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PostResource $resource,
        PostManagementInterface $postManagement
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resource = $resource;
        $this->postManagement = $postManagement
    }

    /**
     * @return \Magento\Cms\Api\Data\PageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->pageRepository->getList($searchCriteria);
    }

    public function getByPageId($pageId): PostInterface
    {
        $post = $this->postManagement->getEmptyObject();
        $this->resource->load($post, $pageId, 'page_id');
        return $post;
    }
}

<?php

namespace Magespace\PostComment\Block;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Serialize\SerializerInterface;
use Magespace\Blog\Api\PostRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cms\Model\Page;
use Magespace\Blog\Model\Post;
use Magespace\Blog\Service\PostRepository;
use Magespace\PostComment\Api\Data\CommentInterface;
use Magespace\PostComment\Api\Data\CommentSearchResultInterface;
use Magespace\PostComment\Model\CommentRepository;

/**
 * Class Main
 */
class Comment extends Template
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Page
     */
    protected $cmsPage;

    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var PostRepository
     */
    private $commentRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;


    public function __construct(
        SerializerInterface $serializer,
        Context $context,
        Page $cmsPage,
        PostRepositoryInterface $postRepository,
        CommentRepository $commentRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        parent::__construct($context);
        $this->serializer = $serializer;
        $this->cmsPage = $cmsPage;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function isPost()
    {
        /** @var Post $post */
        $post = $this->postRepository->getByPageId($this->cmsPage->getId());
        return !$post->isEmpty() && $post->getData('is_post') > 0;
    }

    /**
     * @return string
     */
    public function getCommentsJson(): string
    {
        /** @var Post $post */
        $post = $this->postRepository->getByPageId($this->cmsPage->getId());
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('post_id', $post->getId(), '=')
            ->create();
        return $this->serializer->serialize($this->getComments($this->commentRepository->getList($searchCriteria)));
    }

    /**
     * @param CommentSearchResultInterface $commentsSearchResults
     * @return array
     */
    private function getComments(CommentSearchResultInterface $commentsSearchResults): array
    {
        $result = [];

        /** @var CommentInterface $comment */
        foreach ($commentsSearchResults->getItems() as $comment) {
            $result[] = [
                "id" => $comment->getId(),
                "content" => $comment->getData('content')
            ];
        }
        return $result;
    }
}
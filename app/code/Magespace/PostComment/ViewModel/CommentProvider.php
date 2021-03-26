<?php

namespace Magespace\PostComment\ViewModel;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magespace\Blog\Model\Post;
use Magespace\Blog\Service\PostRepository;
use Magespace\PostComment\Api\Data\CommentInterface;
use Magespace\PostComment\Api\Data\CommentSearchResultInterface;
use Magespace\PostComment\Model\CommentRepository;

/**
 * Class CommentProvider
 * @package Magespace\PostComment\ViewModel
 */
class CommentProvider implements ArgumentInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var PageInterface
     */
    private $cmsPage;

    /**
     * @var PostRepository
     */
    private $commentRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;


    /**
     * CommentProvider constructor.
     * @param SerializerInterface $serializer
     * @param PageInterface $cmsPage
     * @param PostRepository $postRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(
        SerializerInterface $serializer,
        PageInterface $cmsPage,
        PostRepository $postRepository,
        CommentRepository $commentRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
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

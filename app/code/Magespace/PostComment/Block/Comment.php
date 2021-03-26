<?php

namespace Magespace\PostComment\Block;

use Magespace\Blog\Api\PostRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cms\Model\Page;
use Magespace\Blog\Model\Post;

/**
 * Class Main
 */
class Comment extends Template
{
    protected $cmsPage;

    protected $postRepository;

    public function __construct(
        Context $context,
        Page $cmsPage,
        PostRepositoryInterface $postRepository
    ) {
        parent::__construct($context);
        $this->cmsPage = $cmsPage;
        $this->postRepository = $postRepository;
    }

    public function isPost()
    {
        /** @var Post $post */
        $post = $this->postRepository->getByPageId($this->cmsPage->getId());
        return !$post->isEmpty() && $post->getData('is_post') > 0;
    }

    public function getlist()
    {
        return 'Comments';
    }
}

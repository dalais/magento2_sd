<?php

namespace Magespace\Blog\Observer;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Block\Page;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magespace\Blog\Api\PostRepositoryInterface;
use Magespace\Blog\Model\Post;

class PageLoadAfter implements ObserverInterface
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * PageLoadAfter constructor.
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var PageInterface|Page $entity */
        $entity = $observer->getEvent()->getObject();

        /** @var Post $post */
        $post = $this->postRepository->getByPageId($entity->getId());

        if ($post->getId()) {
            $entity->setData('author', $post->getData('author'));
            $entity->setData('is_post', $post->getData('is_post'));
            $entity->setData('published_time', $post->getData('published_time'));
        }
    }
}

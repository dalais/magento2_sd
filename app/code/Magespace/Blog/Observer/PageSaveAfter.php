<?php

namespace Magespace\Blog\Observer;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magespace\Blog\Api\Data\PostInterface;
use Magespace\Blog\Api\PostManagementInterface;
use Magespace\Blog\Model\Post;

class PageSaveAfter implements ObserverInterface
{
    /**
     * @var PostManagementInterface
     */
    private $postManagement;

    /**
     * PageSaveAfter constructor.
     * @param PostManagementInterface $postManagement
     */
    public function __construct(PostManagementInterface $postManagement)
    {
        $this->postManagement = $postManagement;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var PageInterface $entity */
        $entity = $observer->getEvent()->getEntity();
        $data = $entity->getData();

        /** @var PostInterface|Post $post */
        $post = $this->postManagement->getEmptyObject();

        $post->setData('author', $data['author']);
        $post->setData('is_post', $data['is_post']);
        $post->setData('published_date', $data['published_date']);
        $post->setData('page_id', $data['page_id']);

        $this->postManagement->save($post);
    }
}

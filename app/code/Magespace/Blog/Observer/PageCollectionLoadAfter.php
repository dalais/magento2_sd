<?php

namespace Magespace\Blog\Observer;

use Magento\Cms\Model\Page;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magespace\Blog\Model\Post;
use Magespace\Blog\Model\ResourceModel\Post\Collection as PostCollection;
use Magespace\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

class PageCollectionLoadAfter implements ObserverInterface
{
    /**
     * @var PostCollectionFactory
     */
    private $postCollectionFactory;

    /**
     * PageCollectionLoadAfter constructor.
     * @param PostCollectionFactory $postCollectionFactory
     */
    public function __construct(PostCollectionFactory $postCollectionFactory)
    {
        $this->postCollectionFactory = $postCollectionFactory;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Cms\Model\ResourceModel\Page\Collection $collection */
        $collection = $observer->getEvent()->getPageCollection();

        $pageIds = [];

        /** @var Page $item */
        foreach ($collection->getItems() as $item) {
            $pageIds[] = $item->getId();
        }

        $postCollection = $this->postCollectionFactory->create();
        $postCollection->addFieldToFilter('page_id', ['in' => $pageIds]);
        foreach ($postCollection->getItems() as $post) {
            $page = $collection->getItemById($post->getPageId());
            if ($page->getId()) {
                $page->setData('author', $post->getData('author'));
                $page->setData('is_post', $post->getData('is_post'));
                $page->setData('published_time', $post->getData('published_time'));
            }
        }
    }
}

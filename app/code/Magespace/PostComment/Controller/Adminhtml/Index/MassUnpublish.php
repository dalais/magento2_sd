<?php

namespace Magespace\PostComment\Controller\Adminhtml\Index;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magespace\PostComment\Api\CommentRepositoryInterface;
use Magespace\PostComment\Model\CommentFactory;
use Magespace\PostComment\Model\ResourceModel\Comment\CollectionFactory;

/**
 * Class MassPublish
 * @package Magespace\PostComment\Controller\Adminhtml\Index
 */
class MassUnpublish extends \Magespace\PostComment\Controller\Adminhtml\Index\AbstractMassAction
{

    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    /**
     * MassPublish constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        CommentRepositoryInterface $commentRepository
    ) {
        parent::__construct($context, $filter, $collectionFactory);
        $this->commentRepository = $commentRepository;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param AbstractCollection $collection
     * @return \Magento\Framework\Controller\Result\Redirect|mixed
     */
    protected function massAction(AbstractCollection $collection)
    {
        $countPublishedComment = 0;
        /** @var CommentFactory $comment */
        foreach ($collection->getItems() as $comment) {
            $commentDataObject = $this->commentRepository->getById($comment->getData('comment_id'));
            if (strtotime($commentDataObject->getData('published_time'))) {
                $commentDataObject->setData('published_time',null);
                $this->commentRepository->save($commentDataObject);
                $countPublishedComment++;
            }
        }
        $countNonPublishedComment = $collection->count() - $countPublishedComment;

        if ($countNonPublishedComment && $countPublishedComment) {
            $this->messageManager->addErrorMessage(__('%1 comment(s) were not unpublished.', $countNonPublishedComment));
        } elseif ($countNonPublishedComment) {
            $this->messageManager->addErrorMessage(__('No comment(s) were unpublished.'));
        }

        if ($countPublishedComment) {
            $this->messageManager->addSuccessMessage(__('You have unpublished %1 comment(s).', $countPublishedComment));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->getComponentRefererUrl());
        return $resultRedirect;
    }
}

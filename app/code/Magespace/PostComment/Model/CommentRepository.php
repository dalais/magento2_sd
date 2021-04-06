<?php

namespace Magespace\PostComment\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magespace\PostComment\Api\Data\CommentInterface;
use Magespace\PostComment\Api\Data\CommentSearchResultInterfaceFactory;
use Magespace\PostComment\Api\CommentRepositoryInterface;
use Magespace\PostComment\Model\ResourceModel\Comment;
use Magespace\PostComment\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;
use Magespace\PostComment\Model\ResourceModel\Comment as CommentResource;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @var CommentFactory
     */
    private $commentFactory;

    /**
     * @var CommentResource
     */
    private $commentResource;

    /**
     * @var CommentCollectionFactory
     */
    private $commentCollectionFactory;

    /**
     * @var CommentSearchResultInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        CommentFactory $commentFactory,
        CommentResource $commentResource,
        CommentCollectionFactory $commentCollectionFactory,
        CommentSearchResultInterfaceFactory $commentSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->commentFactory = $commentFactory;
        $this->commentResource = $commentResource;
        $this->commentCollectionFactory = $commentCollectionFactory;
        $this->searchResultFactory = $commentSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \Magespace\PostComment\Api\Data\CommentInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $student = $this->commentFactory->create();
        $this->commentResource->load($student, $id);
        if (!$student->getId()) {
            throw new NoSuchEntityException(__('Unable to find Comment with ID "%1"', $id));
        }
        return $student;
    }

    /**
     * @param \Magespace\PostComment\Api\Data\CommentInterface $comment
     * @return \Magespace\PostComment\Api\Data\CommentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(CommentInterface $comment)
    {
        $this->commentResource->save($comment);
        return $comment;
    }

    /**
     * @param \Magespace\PostComment\Api\Data\CommentInterface $comment
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CommentInterface $comment)
    {
        try {
            $this->commentResource->delete($comment);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;

    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magespace\PostComment\Api\Data\CommentSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->commentCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}

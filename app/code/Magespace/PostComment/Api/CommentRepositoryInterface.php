<?php

namespace Magespace\PostComment\Api;

/**
 * Interface CommentRepositoryInterface
 * @package Magespace\PostComment\Api
 */
interface CommentRepositoryInterface
{
    /**
     * @param int $id
     * @return \Magespace\PostComment\Api\Data\CommentInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Magespace\PostComment\Api\Data\CommentInterface $comment
     * @return \Magespace\PostComment\Api\Data\CommentInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Magespace\PostComment\Api\Data\CommentInterface $comment);

    /**
     * @param \Magespace\PostComment\Api\Data\CommentInterface $student
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Magespace\PostComment\Api\Data\CommentInterface $student);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magespace\PostComment\Api\Data\CommentSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}

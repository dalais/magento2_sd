<?php
namespace Pulsestorm\ToDoCrud\Api;

use Pulsestorm\ToDoCrud\Api\Data\TodoItemInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface TodoItemRepositoryInterface
 *
 * @api
 */
interface TodoItemRepositoryInterface
{
    /**
     * Create or update a TodoItem.
     *
     * @param TodoItemInterface $page
     * @return TodoItemInterface
     */
    public function save(TodoItemInterface $page);

    /**
     * Get a TodoItem by Id
     *
     * @param int $id
     * @return TodoItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If TodoItem with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve TodoItems which match a specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * Delete a TodoItem
     *
     * @param TodoItemInterface $page
     * @return TodoItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If TodoItem with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(TodoItemInterface $page);

    /**
     * Delete a TodoItem by Id
     *
     * @param int $id
     * @return TodoItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}

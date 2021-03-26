<?php

namespace Magespace\PostComment\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CommentSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Magespace\PostComment\Api\Data\CommentInterface[]
     */
    public function getItems();

    /**
     * @param \Magespace\PostComment\Api\Data\CommentInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}

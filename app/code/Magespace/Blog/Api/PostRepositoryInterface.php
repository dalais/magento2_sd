<?php

namespace Magespace\Blog\Api;

use Magespace\Blog\Api\Data\PostInterface;

/**
 * Interface PostRepositoryInterface
 * @api
 */
interface PostRepositoryInterface
{
    /**
     * @return PostInterface
     */
    public function get();

    /**
     * @param int $pageId
     * @return PostInterface
     */
    public function getByPageId($pageId): PostInterface;
}

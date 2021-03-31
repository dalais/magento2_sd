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
     * @return PostInterface[]
     */
    public function get();

    /**
     * @return PostInterface[]
     */
    public function getPaginated(int $page = 1, int $limit = 0);

    /**
     * @param int $pageId
     * @return PostInterface
     */
    public function getByPageId($pageId): PostInterface;
}

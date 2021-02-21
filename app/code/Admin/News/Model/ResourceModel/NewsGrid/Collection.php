<?php
namespace Admin\News\Model\ResourceModel\NewsGrid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Banner Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'news_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Admin\News\Model\NewsGrid', 'Admin\News\Model\ResourceModel\NewsGrid');
    }
}

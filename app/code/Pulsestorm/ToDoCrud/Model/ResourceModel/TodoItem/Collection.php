<?php
namespace Pulsestorm\ToDoCrud\Model\ResourceModel\TodoItem;

/**
 * Class Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(
            \Pulsestorm\ToDoCrud\Model\TodoItem::class,
            \Pulsestorm\ToDoCrud\Model\ResourceModel\TodoItem::class
        );
    }
}

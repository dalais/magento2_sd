<?php
namespace Pulsestorm\ToDoCrud\Model;

/**
 * Class TodoItem
 */
class TodoItem extends \Magento\Framework\Model\AbstractModel implements
    \Pulsestorm\ToDoCrud\Api\Data\TodoItemInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'pulsestorm_todocrud_todoitem';

    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(\Pulsestorm\ToDoCrud\Model\ResourceModel\TodoItem::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}

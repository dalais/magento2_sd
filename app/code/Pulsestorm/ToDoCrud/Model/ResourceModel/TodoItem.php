<?php
namespace Pulsestorm\ToDoCrud\Model\ResourceModel;

/**
 * Class TodoItem
 */
class TodoItem extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init('pulsestorm_todocrud_todoitem', 'pulsestorm_todocrud_todoitem_id');
    }
}

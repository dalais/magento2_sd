<?php
namespace Pulsestorm\ToDoCrud\Block;

/**
 * Class Main
 */
class Main extends \Magento\Framework\View\Element\Template
{
    protected $toDoFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Pulsestorm\ToDoCrud\Model\TodoItemFactory $toDoFactory
    )
    {
        $this->toDoFactory = $toDoFactory;
        parent::__construct($context);
    }

    function _prepareLayout()
    {
        $todo = $this->toDoFactory->create();

        $collection = $todo->getCollection();

        foreach($collection as $item)
        {
            var_dump('Item ID: ' . $item->getId());
            var_dump($item->getData());
        }
        exit;
    }
}

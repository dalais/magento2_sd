<?php
namespace Sdalay\News\Controller\Show;
class Index extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct(
            $context
        );
    }

    public function execute()
    {
        echo "Hello World";
    }
}

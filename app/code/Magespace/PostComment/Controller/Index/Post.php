<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Contact\Controller\Index;

use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magespace\PostComment\Model\CommentFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * Post constructor.
     * @param Context $context
     * @param CommentFactory $commentFactory
     */
    public function __construct(
        Context $context,
        CommentFactory $commentFactory
    )
    {
        parent::__construct($context);
        $this->context = $context;
        $this->resultJsonFactory = $commentFactory;
    }

    /**
     * Post user comment
     *
     * @return Redirect
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        $result = $this->resultJsonFactory->create();
        if ($this->getRequest()->isAjax()) {
            $test = [
                'Firstname' => 'What is your firstname',
                'Email' => 'What is your emailId',
                'Lastname' => 'What is your lastname',
                'Country' => 'Your Country'
            ];
            return $result->setData($test);
        }
    }
}

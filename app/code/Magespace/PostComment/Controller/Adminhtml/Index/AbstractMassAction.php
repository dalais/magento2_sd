<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magespace\PostComment\Controller\Adminhtml\Index;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magespace\PostComment\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;

/**
 * Class AbstractMassStatus
 */
abstract class AbstractMassAction extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magespace_PostComment::comment';

    /**
     * @var string
     */
    protected $redirectUrl = '*/*/index';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CommentCollectionFactory
     */
    protected $commentCollectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CommentCollectionFactory $commentCollectionFactory
     */
    public function __construct(Context $context, Filter $filter, CommentCollectionFactory $commentCollectionFactory)
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->commentCollectionFactory = $commentCollectionFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            return $this->massAction($collection);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath($this->redirectUrl);
        }
    }

    /**
     * Return component referer url
     *
     * TODO: Technical dept referer url should be implement as a part of Action configuration in appropriate way
     *
     * @return null|string
     */
    protected function getComponentRefererUrl()
    {
        return $this->filter->getComponentRefererUrl()?: 'comment/*/index';
    }

    /**
     * @param AbstractCollection $collection
     * @return mixed
     */
    abstract protected function massAction(AbstractCollection $collection);
}

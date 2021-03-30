<?php
namespace Magespace\PostComment\Controller\Index;

use Magento\Cms\Model\Page;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\JsonFactory;
use Magespace\PostComment\Model\Comment;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var Page
     */
    private $cmsPage;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * Post constructor.
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        Page $cmsPage,
        JsonFactory $resultJsonFactory
    )
    {
        parent::__construct($context);
        $this->context = $context;
        $this->cmsPage = $cmsPage;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        $result = $this->resultJsonFactory->create();
        if ($this->getRequest()->isAjax()) {
            $data = $this->getRequest()->getParams();
            if (trim($data['content']) == '') {
                $result->setData(['validation_error' => 'Empty message']);
            } else {
                /** @var Comment $comment */
                $comment = $this->_objectManager->create('Magespace\PostComment\Model\Comment');
                $comment->setData([
                    'content' => $data['content'],
                    'post_id' => $this->cmsPage->getId(),
                    'customer_entity_id' => 1
                ]);
                $comment->save();
                $result->setData([
                    'success' => 'Your comment was sent successfully. It will be published after the moderator checks it.'
                ]);
            }
        }
        return $result;
    }
}

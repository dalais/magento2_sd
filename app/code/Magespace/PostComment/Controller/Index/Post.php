<?php

namespace Magespace\PostComment\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\JsonFactory;
use Magespace\PostComment\Api\CommentRepositoryInterface;
use Magespace\PostComment\Api\Data\CommentInterfaceFactory;
use Magespace\PostComment\Model\Comment;

class Post implements \Magento\Framework\App\Action\HttpPostActionInterface
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
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    /**
     * @var CommentInterfaceFactory
     */
    protected $commentFactory;

    /**
     * Post constructor.
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CommentRepositoryInterface $commentRepository,
        CommentInterfaceFactory $commentFactory
    )
    {
        $this->context = $context;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->commentRepository = $commentRepository;
        $this->commentFactory = $commentFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        if ($this->context->getRequest()->isAjax()) {
            $data = $this->context->getRequest()->getParams();
            if (trim($data['content']) == '') {
                $result->setData(['validation_error' => 'Please! Write your comment']);
            } else {
                /** @var Comment $commentFactory */
                $commentFactory = $this->commentFactory->create();
                $commentFactory->setData([
                    'content' => $data['content'],
                    'post_id' => $data['post_id'],
                    'customer_entity_id' => 1
                ]);
                $this->commentRepository->save($commentFactory);
                $result->setData([
                    'success' => 'Your comment was sent successfully. It will be published after the moderator checks it.'
                ]);
            }
        }
        return $result;
    }
}

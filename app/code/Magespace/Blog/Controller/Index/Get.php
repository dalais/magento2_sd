<?php

namespace Magespace\Blog\Controller\Index;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magespace\Blog\Api\PostRepositoryInterface;

class Get implements \Magento\Framework\App\Action\HttpGetActionInterface
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
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * Post constructor.
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        PostRepositoryInterface $postRepository
    )
    {
        $this->context = $context;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->postRepository = $postRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        /** @var PageSearchResultsInterface $postRepository */
        $postRepository = $this->postRepository->get($this->context->getRequest()->getParam('page'));
        $resultData = [];
        /** @var PageInterface $post */
        foreach ($postRepository->getItems() as $post) {
            $resultData[] = [
                "id" => $post->getId(),
                "title" => $post->getTitle(),
                "url" => $this->context->getUrl()->getUrl($post->getIdentifier()),
                "published_time" => $post->getPublishedTime(),
                "content" => $this->truncate($post->getContent(), 10),
                "author" => $post->getAuthor()
            ];
        }
        $result->setData($resultData);
        return $result;
    }

    /**
     * @param $phrase
     * @param $max_words
     * @return string
     */
    private function truncate($phrase, $max_words):string
    {
        $phrase_array = explode(' ',$phrase);
        if (count($phrase_array) > $max_words && $max_words > 0) {
            $phrase = implode(' ', array_slice($phrase_array, 0, $max_words)) . '...';
        }
        return $phrase;
    }
}

<?php

namespace Magespace\Blog\ViewModel;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magespace\Blog\Service\PostRepository;

/**
 * Class Blog
 * @package Magespace\Blog\ViewModel
 */
class PostProvider implements ArgumentInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * PostProvider constructor.
     * @param SerializerInterface $serializer
     * @param PostRepository $postRepository
     * @param UrlInterface $url
     */
    public function __construct(
        SerializerInterface $serializer,
        PostRepository $postRepository,
        UrlInterface $url
    ) {
        $this->serializer = $serializer;
        $this->postRepository = $postRepository;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getPostsJson(): string
    {
        $postsSearchResults = $this->postRepository->get();

        return $this->serializer->serialize($this->getPosts($postsSearchResults));
    }

    /**
     * @param PageSearchResultsInterface $pageSearchResults
     * @return array
     */
    private function getPosts(PageSearchResultsInterface $pageSearchResults): array
    {
        $result = [];

        /** @var PageInterface $post */
        foreach ($pageSearchResults->getItems() as $post) {
            $result[] = [
                "id" => $post->getId(),
                "title" => $post->getTitle(),
                "url" => $this->url->getUrl($post->getIdentifier()),
                "published_time" => $post->getPublishedTime(),
                "content" => $this->truncate($post->getContent(), 10),
                "author" => $post->getAuthor()
            ];
        }
        return $result;
    }

    private function truncate($phrase, $max_words):string
    {
        $phrase_array = explode(' ',$phrase);
        if (count($phrase_array) > $max_words && $max_words > 0) {
            $phrase = implode(' ', array_slice($phrase_array, 0, $max_words)) . '...';
        }
        return $phrase;
    }
}

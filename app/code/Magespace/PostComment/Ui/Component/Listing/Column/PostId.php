<?php

namespace Magespace\PostComment\Ui\Component\Listing\Column;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magespace\Blog\Model\PostFactory;

/**
 * Class AccessActions
 * @package Magespace\PostComment\Ui\Component\Listing\Column
 */
class PostId extends Column
{

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var UrlInterface
     */
    protected $url;
    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param PostFactory $postFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UrlInterface $url,
        UiComponentFactory $uiComponentFactory,
        PostFactory $postFactory,
        PageRepositoryInterface $pageRepository,
        array $components = [],
        array $data = []
    )
    {
        $this->postFactory = $postFactory;
        $this->pageRepository = $pageRepository;
        $this->url = $url;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as $key => & $item) {
                if (isset($item['post_id'])) {
                    $post = $this->postFactory->create()->load($item['post_id']);
                    $page = $this->pageRepository->getById($post->getData('page_id'));
                    if ($page->isActive()) {
                        $item['post_id'] = '<a href="'.$this->url->getUrl().$page->getIdentifier().'" target="_blank">'.$page->getTitle().'</a>';
                    } else {
                        $item['post_id'] = $page->getTitle();
                    }
                }
            }
        }

        return $dataSource;
    }
}

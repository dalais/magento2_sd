<?php

namespace Magespace\PostComment\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class PublishedTime
 * @package Magespace\PostComment\Ui\Component\Listing\Column
 */
class PublishedTime extends Column
{

    /**
     * PublishedTime constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
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
            foreach ($dataSource['data']['items'] as & $item) {
                if (empty($item['published_time'])) {
                    $published_time = '<span style="color: red">Not Published</span>';
                } else {
                    $timestamp = strtotime($item['published_time']);
                    $published_time = $timestamp ? date('Y-m-d H:i:s',$timestamp) : '-';
                }
                $item['published_time'] = $published_time;
            }
        }

        return $dataSource;
    }
}

<?php
/**
 * Copyright © 2021 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Admin\News\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Create table 'news_comment'
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable('news_comment'))
            ->addColumn(
                'news_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'News ID'
            )->addColumn(
                'comment_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Comment ID'
            )->addIndex(
                $setup->getIdxName('news', ['news_id']),
                ['news_id']
            )->addIndex(
                $setup->getIdxName('comment', ['comment_id']),
                ['comment_id']
            );
        $setup->getConnection()->createTable($table);
    }
}

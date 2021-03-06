<?php
/**
 * Copyright © 2021 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Sdalay\Comment\Setup;
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
         * Create table 'comment'
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable('comment'))
            ->addColumn(
                'comment_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'News ID'
            )
            ->addColumn(
                'message',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '2M',
                ['nullable' => false, 'default' => ''],
                'Message'
            )->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At')
            ->addColumn(
                'published',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                1,
                ['nullable' => false, 'default' => false],
                'Published');
        $setup->getConnection()->createTable($table);

        /**
         * Create table 'customer_comment'
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable('customer_comment'))
            ->addColumn(
                'customer_entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Customer Entity ID'
            )->addColumn(
                'comment_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Comment ID'
            )->addIndex(
                $setup->getIdxName('customer_entity', ['entity_id']),
                ['customer_entity_id']
            )->addIndex(
                $setup->getIdxName('comment', ['comment_id']),
                ['comment_id']
            );
        $setup->getConnection()->createTable($table);
    }
}

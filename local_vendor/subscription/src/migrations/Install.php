<?php
/**
 * Subscription plugin for Craft CMS 3.x
 *
 * Subscription
 *
 * @link      craft.test
 * @copyright Copyright (c) 2020 Timon
 */

namespace aenmsubscription\subscription\migrations;

use aenmsubscription\subscription\Subscription;

use Craft;
use craft\db\Table;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    Timon
 * @package   Subscription
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%subscription_subscriptionrecord}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%subscription_subscriptionrecord}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'author_id' => $this->integer()->notNull(),
                    'community_id' => $this->integer()->notNull(),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        // $this->createIndex(
        //     $this->db->getIndexName(
        //         '{{%subscription_subscriptionrecord}}',
        //         'author_id',
        //         true
        //     ),
        //     '{{%subscription_subscriptionrecord}}',
        //     'author_id',
        //     true
        // );

        // $this->createIndex(
        //     $this->db->getIndexName(
        //         '{{%subscription_subscriptionrecord}}',
        //         'community_id',
        //         true
        //     ),
        //     '{{%subscription_subscriptionrecord}}',
        //     'community_id',
        //     true
        // );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%subscription_subscriptionrecord}}', 'author_id'),
            '{{%subscription_subscriptionrecord}}',
            'author_id',
            Table::USERS,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%subscription_subscriptionrecord}}', 'community_id'),
            '{{%subscription_subscriptionrecord}}',
            'community_id',
            Table::ELEMENTS,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists('{{%subscription_subscriptionrecord}}');
    }
}

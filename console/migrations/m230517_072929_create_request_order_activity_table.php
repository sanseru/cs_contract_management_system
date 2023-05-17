<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_order_activity}}`.
 */
class m230517_072929_create_request_order_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_order_activity}}', [
            'id' => $this->primaryKey(),
            'request_order_id' => $this->integer()->notNull(),
            'activity_code' => $this->string()->notNull(),
        ]);

            // add foreign key for request_order_id
        $this->addForeignKey(
            'fk-request_order_activity-request_order_id',
            'request_order_activity',
            'request_order_id',
            'request_order',
            'id',
            'CASCADE'
        );

        // add foreign key for activity_code
        $this->addForeignKey(
            'fk-request_order_activity-activity_code',
            'request_order_activity',
            'activity_code',
            'master_activity',
            'activity_code',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-request_order_activity-request_order_id', 'request_order_activity');
        $this->dropForeignKey('fk-request_order_activity-activity_code', 'request_order_activity');
        $this->dropTable('{{%request_order_activity}}');
    }
}

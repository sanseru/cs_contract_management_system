<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%activity_unit_rate}}`.
 */
class m230524_073842_create_activity_unit_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activity_unit_rate}}', [
            'id' => $this->primaryKey(),
            'unit_rate_id' => $this->integer()->notNull(),
            'activity_code' => $this->string()->notNull(),
        ]);

        // add foreign key for request_order_id
        $this->addForeignKey(
            'fk-activity_unit_rate-unit_rate_id',
            'activity_unit_rate',
            'unit_rate_id',
            'unit_rate',
            'id',
            'CASCADE'
        );

        // add foreign key for activity_code
        $this->addForeignKey(
            'fk-activity_unit_rate-activity_code',
            'activity_unit_rate',
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
        $this->dropTable('{{%activity_unit_rate}}');
    }
}

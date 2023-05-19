<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ro_trans}}`.
 */
class m230519_080730_create_ro_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_order_trans}}', [
            'id' => $this->primaryKey(),
            'request_order_id' => $this->integer()->notNull(),
            'costing_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'unit_price' => $this->decimal(18,2)->notNull(),
            'sub_total' => $this->decimal(18,2)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-ro_trans-request_order_id',
            'request_order_trans',
            'request_order_id',
            'request_order',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-ro_trans-costing_id',
            'request_order_trans',
            'costing_id',
            'costing',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-ro_trans-request_order_id', 'request_order_trans');
        $this->dropForeignKey('fk-ro_trans-costing_id', 'request_order_trans');

        $this->dropTable('{{%request_order_trans}}');
    }
}

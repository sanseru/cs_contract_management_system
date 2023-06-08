<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ro_trans_item_sow}}`.
 */
class m230606_012643_create_ro_trans_item_sow_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ro_trans_item_sow}}', [
            'id' => $this->primaryKey(),
            'request_order_trans_id' => $this->integer()->notNull(),
            'request_order_trans_item_id' => $this->integer()->notNull(),
            'sow_id' => $this->integer()->notNull(),
            'date_sow' => $this->date()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_by' => $this->integer(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_ro_trans_item_sow_request_order_trans_id',
            'ro_trans_item_sow',
            'request_order_trans_id',
            'request_order_trans',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_ro_trans_item_sow_request_order_trans_item_id',
            'ro_trans_item_sow',
            'request_order_trans_item_id',
            'request_order_trans_item',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_ro_trans_item_sow_sow_id',
            'ro_trans_item_sow',
            'sow_id',
            'master_scope_of_work',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ro_trans_item_sow}}');
    }
}

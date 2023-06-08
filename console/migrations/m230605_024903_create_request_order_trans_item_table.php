<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_order_trans_item}}`.
 */
class m230605_024903_create_request_order_trans_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_order_trans_item}}', [
            'id' => $this->primaryKey(),
            'request_order_id' => $this->integer()->notNull(),
            'request_order_trans_id' => $this->integer()->notNull(),
            'resv_number' => $this->string(255)->notNull(),
            'ce_year' => $this->string(255),
            'cost_estimate' => $this->string(255),
            'ro_number' => $this->string(255),
            'material_incoming_date' => $this->date(),
            'ro_start' => $this->date(),
            'ro_end' => $this->date(),
            'urgency' => $this->string(255),
            'qty' => $this->integer(),
            'id_valve' => $this->string(255),
            'size' => $this->string(255),
            'class' => $this->string(255),
            'equipment_type' => $this->string(255),
            'sow' => $this->text(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'date_to_status' => $this->date(),
            'progress' => $this->string(255),
        ]);

        $this->addForeignKey(
            'fk-request_order_trans_item-request_order_id',
            '{{%request_order_trans_item}}',
            'request_order_id',
            'request_order',
            'id',
            'CASCADE'
        );
    
        $this->addForeignKey(
            'fk-request_order_trans_item-request_order_trans_id',
            '{{%request_order_trans_item}}',
            'request_order_trans_id',
            'request_order_trans',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-request_order_trans_item-request_order_id', '{{%request_order_trans_item}}');
        $this->dropForeignKey('fk-request_order_trans_item-request_order_trans_id', '{{%request_order_trans_item}}');
        $this->dropTable('{{%request_order_trans_item}}');
    }
}

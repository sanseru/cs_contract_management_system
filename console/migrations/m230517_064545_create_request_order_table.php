<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_order}}`.
 */
class m230517_064545_create_request_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_order}}', [
            'id' => $this->primaryKey(),
            'contract_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'activity_code' => $this->string()->notNull(),
            'so_number' => $this->string()->notNull(),
            'ro_number' => $this->string(),
            'contract_type' => $this->string()->notNull(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(),
            'status' => $this->integer()->defaultValue(0),
            'created_by' => $this->integer(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_by' => $this->integer(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey('fk-request_order-contract_id', '{{%request_order}}', 'contract_id', '{{%client_contract}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-request_order-client_id', '{{%request_order}}', 'client_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_activity_contract_request_order_id', '{{%activity_contract}}', 'contract_id', '{{%request_order}}', 'id', 'CASCADE', 'CASCADE');
      
        // $this->addForeignKey('fk-request_order-activity_id', '{{%request_order}}', 'activity_code', '{{%master_activity}}', 'activity_code', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_activity_contract_request_order_id', '{{%activity_contract}}');
        $this->dropTable('{{%request_order}}');
    }
}

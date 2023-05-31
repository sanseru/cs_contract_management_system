<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%costing}}`.
 */
class m230516_080734_create_costing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%costing}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'contract_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'unit_rate_id' => $this->integer()->notNull(),
            'price' => $this->decimal(16, 2)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        // add foreign keys for company, contract, and unit_rate tables
        $this->addForeignKey('fk-costing-company', 'costing', 'client_id', 'client', 'id');
        $this->addForeignKey('fk-costing-contract', 'costing', 'contract_id', 'client_contract', 'id', 'CASCADE');
        $this->addForeignKey('fk-costing-unit_rate', 'costing', 'unit_rate_id', 'unit_rate', 'id');
        $this->addForeignKey('fk-costing-item', 'costing', 'item_id', 'item', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-costing-unit_rate', 'costing');
        $this->dropForeignKey('fk-costing-contract', 'costing');
        $this->dropForeignKey('fk-costing-company', 'costing');

        $this->dropTable('{{%costing}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contract}}`.
 */
class m230510_015834_create_contract_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contract}}', [
            'id' => $this->primaryKey(),
            'contract_number' => $this->string()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'so_number' => $this->string()->notNull(),
            'contract_type' => $this->string()->notNull(),
            'activity' => $this->string()->notNull(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(),
            'status' => $this->integer()->defaultValue(0),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_by' => $this->integer(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'idx-contract-contract_number',
            'contract',
            'contract_number',
            true
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-contract-contract_number', '{{%contract}}');
        $this->dropTable('{{%contract}}');
    }
}

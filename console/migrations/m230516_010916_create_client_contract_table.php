<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_contract}}`.
 */
class m230516_010916_create_client_contract_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_contract}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'contract_number' => $this->string()->notNull(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'created_by' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_by' => $this->integer(),
            'updated_at' => $this->dateTime(),
        ]);

        // add foreign key for client_id
        $this->addForeignKey(
            'fk-client_contract-client_id',
            'client_contract',
            'client_id',
            'client',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-client_contract-client_id', 'client_contract');
        $this->dropTable('{{%client_contract}}');
    }
}

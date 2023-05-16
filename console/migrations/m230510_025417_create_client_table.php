<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m230510_025417_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->text()->notNull(),
            'phone_number' => $this->string(20)->notNull(),
            'email' => $this->string()->notNull(),
            'created_by' => $this->integer(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_by' => $this->integer(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'idx-client-name',
            'client',
            'name',
            true
        );
        
        $this->addForeignKey(
            'fk-contract-client_id',
            '{{%contract}}',
            'client_id',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropIndex('idx-client-name', '{{%client}}');
        $this->dropTable('{{%client}}');

    }
}

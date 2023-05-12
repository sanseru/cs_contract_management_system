<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%activity_contract}}`.
 */
class m230511_072442_create_activity_contract_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activity_contract}}', [
            'id' => $this->primaryKey(),
            'activity' => $this->text()->notNull(),
            'activityBy' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'status' => $this->string(50)->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_by' => $this->integer(),
            'updated_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            'contract_id' => $this->integer()->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%activity_contract}}');
    }
}

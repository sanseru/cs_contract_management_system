<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contract_activity_value}}`.
 */
class m230529_043402_create_contract_activity_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contract_activity_value}}', [
            'id' => $this->primaryKey(),
            'contract_id' => $this->integer()->notNull(),
            'activity_id' => $this->integer()->notNull(),
            'value' => $this->decimal(16, 2)->notNull(),

        ]);

        // creates index for column `contract_id`
        $this->createIndex(
            'idx-contract_activity_value-contract_id',
            'contract_activity_value',
            'contract_id'
        );

        // add foreign key for table `client_contract`
        $this->addForeignKey(
            'fk-contract_activity_value-contract_id',
            'contract_activity_value',
            'contract_id',
            'client_contract',
            'id',
            'CASCADE'
        );

        // creates index for column `activity_id`
        $this->createIndex(
            'idx-contract_activity_value-activity_id',
            'contract_activity_value',
            'activity_id'
        );

        // add foreign key for table `master_activity`
        $this->addForeignKey(
            'fk-contract_activity_value-activity_id',
            'contract_activity_value',
            'activity_id',
            'master_activity',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `master_activity`
        $this->dropForeignKey(
            'fk-contract_activity_value-activity_id',
            'contract_activity_value'
        );

        // drops index for column `activity_id`
        $this->dropIndex(
            'idx-contract_activity_value-activity_id',
            'contract_activity_value'
        );

        // drops foreign key for table `client_contract`
        $this->dropForeignKey(
            'fk-contract_activity_value-contract_id',
            'contract_activity_value'
        );

        // drops index for column `contract_id`
        $this->dropIndex(
            'idx-contract_activity_value-contract_id',
            'contract_activity_value'
        );

        $this->dropTable('{{%contract_activity_value}}');
    }
}

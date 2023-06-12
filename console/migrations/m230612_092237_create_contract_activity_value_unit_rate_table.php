<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contract_activity_value_unit_rate}}`.
 */
class m230612_092237_create_contract_activity_value_unit_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contract_activity_value_unit_rate}}', [
            'id' => $this->primaryKey(),
            'contract_id' => $this->integer()->notNull(),
            'activity_value_id' => $this->integer()->notNull(),
            'unit_rate_id' => $this->integer()->notNull(),
        ]);


        // creates index for column `contract_id`
        $this->createIndex(
            'idx-contract_activity_value_unit_rate-contract_id',
            'contract_activity_value_unit_rate',
            'contract_id'
        );

        // add foreign key for table `client_contract`
        $this->addForeignKey(
            'fk-contract_activity_value_unit_rate-contract_id',
            'contract_activity_value_unit_rate',
            'contract_id',
            'client_contract',
            'id',
            'CASCADE'
        );


        // creates index for column `contract_id`
        $this->createIndex(
            'idx-contract_activity_value_unit_rate-activity_value_id',
            'contract_activity_value_unit_rate',
            'activity_value_id'
        );

        // add foreign key for table `client_contract`
        $this->addForeignKey(
            'fk-contract_activity_value_unit_rate-activity_value_id',
            'contract_activity_value_unit_rate',
            'activity_value_id',
            'contract_activity_value',
            'id',
            'CASCADE'
        );

        // creates index for column `contract_id`
        $this->createIndex(
            'idx-contract_activity_value_unit_rate-unit_rate_id',
            'contract_activity_value_unit_rate',
            'unit_rate_id'
        );

        // add foreign key for table `client_contract`
        $this->addForeignKey(
            'fk-contract_activity_value_unit_rate-unit_rate_id',
            'contract_activity_value_unit_rate',
            'unit_rate_id',
            'unit_rate',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contract_activity_value_unit_rate}}');
    }
}

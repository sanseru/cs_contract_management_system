<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contract_activity_value_unit_rate_sow}}`.
 */
class m230613_011034_create_contract_activity_value_unit_rate_sow_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contract_activity_value_unit_rate_sow}}', [
            'id' => $this->primaryKey(),
            'contract_activity_value_unit_rate_id' => $this->integer()->notNull(),
            'sow_id' => $this->integer()->notNull(),
            'sow_kpi' => $this->integer()->notNull(),

        ]);

        $this->addForeignKey(
            'fk_contract_activity_value_unit_rate_id',
            'contract_activity_value_unit_rate_sow',
            'contract_activity_value_unit_rate_id',
            'contract_activity_value_unit_rate',
            'id'
        );

        $this->addForeignKey(
            'fk_contract_activity_value_unit_rate_sow_sow_id',
            'contract_activity_value_unit_rate_sow',
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
        $this->dropTable('{{%contract_activity_value_unit_rate_sow}}');
    }
}

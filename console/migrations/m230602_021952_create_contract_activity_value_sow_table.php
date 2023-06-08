<?php

use yii\db\Migration;

use function PHPSTORM_META\map;

/**
 * Handles the creation of table `{{%contract_activity_value_sow}}`.
 */
class m230602_021952_create_contract_activity_value_sow_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contract_activity_value_sow}}', [
            'id' => $this->primaryKey(),
            'contract_activity_value_id' => $this->integer()->notNull(),
            'sow_id' => $this->integer()->notNull(),
            'sow_kpi' => $this->integer()->notNull(),

        ]);

        $this->addForeignKey(
            'fk_contract_activity_value_sow_activity_value_id',
            'contract_activity_value_sow',
            'contract_activity_value_id',
            'contract_activity_value',
            'id'
        );

        $this->addForeignKey(
            'fk_contract_activity_value_sow_sow_id',
            'contract_activity_value_sow',
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
        $this->dropForeignKey('fk_contract_activity_value_sow_activity_value_id', 'contract_activity_value_sow');
        $this->dropForeignKey('fk_contract_activity_value_sow_sow_id', 'contract_activity_value_sow');
        $this->dropTable('{{%contract_activity_value_sow}}');
    }
}

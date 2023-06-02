<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%master_activity}}`.
 */
class m230602_013618_add_columns_to_master_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('master_activity', 'has_item', $this->boolean()->defaultValue(false));
        $this->addColumn('master_activity', 'has_sow', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('master_activity', 'has_item');
        $this->dropColumn('master_activity', 'has_sow');
    }
}

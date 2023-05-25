<?php

use yii\db\Migration;

/**
 * Class m230525_024536_add_uniq_constrain_activity_code_master_activity_table
 */
class m230525_024536_add_uniq_constrain_activity_code_master_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx-unique-activity_code', 'master_activity', 'activity_code', true);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230525_024536_add_uniq_constrain_activity_code_master_activity_table cannot be reverted.\n";
        $this->dropIndex('idx-unique-activity_code', 'master_activity');


        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230525_024536_add_uniq_constrain_activity_code_master_activity_table cannot be reverted.\n";

        return false;
    }
    */
}

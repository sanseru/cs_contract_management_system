<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%master_item_type}}`.
 */
class m230515_095515_create_master_item_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%master_item_type}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%master_item_type}}');
    }
}

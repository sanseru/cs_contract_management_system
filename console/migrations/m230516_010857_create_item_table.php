<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item}}`.
 */
class m230516_010857_create_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey(),
            'size' => $this->string(),
            'class' => $this->string(),
            'description' => $this->text(),
            'master_activity_code' => $this->string(),
            'item_type_id' => $this->integer(),
        ]);
        $this->createIndex('idx-master_activity-code', 'master_activity', 'activity_code');

        $this->addForeignKey(
            'fk-item-master_activity_code',
            '{{%item}}',
            'master_activity_code',
            '{{%master_activity}}',
            'activity_code',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-item-item_type_id',
            '{{%item}}',
            'item_type_id',
            '{{%master_item_type}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-item-master_activity_id', '{{%item}}');
        $this->dropForeignKey('fk-item-item_type_id', '{{%item}}');
        $this->dropIndex('idx-master_activity-code', 'master_activity');

        $this->dropTable('{{%item}}');
    }
}

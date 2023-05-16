<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%unit_rate}}`.
 */
class m230516_080325_create_unit_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%unit_rate}}', [
            'id' => $this->primaryKey(),
            'rate_name' => $this->string(),
        ]);

        $this->batchInsert('{{%unit_rate}}', ['rate_name'], [
            ['general'],
            ['inspection'],
            ['Minor Repair'],
            ['Major Repair'],
            ['Painting Testing & Packaging'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%unit_rate}}');
    }
}

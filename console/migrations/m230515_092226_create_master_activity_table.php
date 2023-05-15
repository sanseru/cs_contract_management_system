<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%master_activity}}`.
 */
class m230515_092226_create_master_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%master_activity}}', [
            'id' => $this->primaryKey(),
            'activity_code' => $this->string(10),
            'activity_name' => $this->string(50),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->batchInsert(
            '{{%master_activity}}',
            ['activity_code', 'activity_name', 'created_at'],
            [
                ['PM', 'PREVENTIVE MAINTENACE - VALVE', date("Y-m-d H:i:s")],
                ['PS', 'PERSONEL',date("Y-m-d H:i:s")],
                ['VREPR', 'VALVE REPAIR',date("Y-m-d H:i:s")],
                ['VREPL', 'VALVE REPLACEMENT',date("Y-m-d H:i:s")],
                ['SPK', 'SPARE PART KITS',date("Y-m-d H:i:s")],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%master_activity}}');
    }
}

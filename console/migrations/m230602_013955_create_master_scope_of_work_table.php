<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%master_scope_of_work}}`.
 */
class m230602_013955_create_master_scope_of_work_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%master_scope_of_work}}', [
            'id' => $this->primaryKey(),
            'name_sow' => $this->string()->notNull(),


        ]);

        $this->batchInsert('{{%master_scope_of_work}}', ['name_sow'], [
            ['PRE-TEST AND INSPECTION'],
            ['DISASSEMBLY'],
            ['AS FOUND INSPECTION'],
            ['CLEANING'],
            ['BLASTING'],
            ['PRIMER COAT'],
            ['REPAIR'],
            ['ASSEMBLY'],
            ['INTERNAL TEST'],
            ['FAT'],
            ['PAINTING'],
            ['PACKING'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%master_scope_of_work}}');
    }
}

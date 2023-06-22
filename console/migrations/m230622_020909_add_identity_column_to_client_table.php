<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%client}}`.
 */
class m230622_020909_add_identity_column_to_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'client_id', $this->integer());
        $this->addColumn('user', 'user_type_id', $this->integer());
        $this->addForeignKey('fk-user-client_id', 'user', 'client_id', 'client', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user-client_id', 'user');
        $this->dropColumn('user', 'client_id');
        $this->dropColumn('user', 'user_type_id');

    }
}

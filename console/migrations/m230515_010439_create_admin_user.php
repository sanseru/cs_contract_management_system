<?php

use yii\db\Migration;

/**
 * Class m230515_010439_create_admin_user
 */
class m230515_010439_create_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('12345678'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['username' => 'admin']);

        // echo "m230515_010439_create_admin_user cannot be reverted.\n";

        // return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230515_010439_create_admin_user cannot be reverted.\n";

        return false;
    }
    */
}

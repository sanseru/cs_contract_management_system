<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone_number
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'phone_number', 'email', 'created_at', 'updated_at'], 'required'],
            [['address'], 'string'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 20],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getContracts()
    {
        return $this->hasMany(Contract::class, ['client_id' => 'id']);
    }
}

<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contract".
 *
 * @property int $id
 * @property string $contract_number
 * @property int $client_id
 * @property string $so_number
 * @property string $contract_type
 * @property string $activity
 * @property string $start_date
 * @property string $end_date
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 */
class Contract extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contract_number', 'client_id', 'so_number', 'contract_type', 'activity', 'start_date', 'end_date', 'created_at', 'updated_at'], 'required'],
            [['client_id', 'status'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['contract_number', 'so_number', 'contract_type', 'activity'], 'string', 'max' => 255],
            [['contract_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contract_number' => 'Contract Number',
            'client_id' => 'Client ID',
            'so_number' => 'So Number',
            'contract_type' => 'Contract Type',
            'activity' => 'Activity',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function getActivity()
    {
        return $this->hasMany(ActivityContract::class, ['contract_id' => 'id']);
    }
}

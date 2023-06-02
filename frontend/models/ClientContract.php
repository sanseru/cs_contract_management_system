<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "client_contract".
 *
 * @property int $id
 * @property int $client_id
 * @property string $contract_number
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $created_by
 * @property string|null $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 *
 * @property Client $client
 * @property ContractActivityValue[] $contractActivityValues 
 * @property Costing[] $costings 
 * @property RequestOrder[] $requestOrders 
 */
class ClientContract extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_contract';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'contract_number'], 'required'],
            [['client_id', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['contract_number'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'contract_number' => 'Contract Number',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /** 
     * Gets query for [[ContractActivityValues]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */
    public function getContractActivityValues()
    {
        return $this->hasMany(ContractActivityValue::class, ['contract_id' => 'id']);
    }

    /** 
     * Gets query for [[Costings]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */
    public function getCostings()
    {
        return $this->hasMany(Costing::class, ['contract_id' => 'id']);
    }

    /** 
     * Gets query for [[RequestOrders]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */
    public function getRequestOrders()
    {
        return $this->hasMany(RequestOrder::class, ['contract_id' => 'id']);
    }
}

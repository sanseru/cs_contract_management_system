<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "costing".
 *
 * @property int $id
 * @property int $client_id
 * @property int $contract_id
 * @property int $unit_rate_id
 * @property float $price
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Client $client
 * @property ClientContract $clientContract
 * @property UnitRate $unitRate
 */
class Costing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $clientName;
    public $contractNumber;
    public $rateName;
    public $itemDetail;

    public static function tableName()
    {
        return 'costing';
    }

    /**
     * {@inheritdoc}
     */    
    public function rules()
    {
        return [
            [['client_id', 'contract_id', 'unit_rate_id', 'price', 'created_at', 'updated_at'], 'required'],
            [['client_id', 'contract_id', 'unit_rate_id'], 'integer'],
            // [['price'], 'number'],
            [['created_at', 'updated_at', 'clientName', 'price','item_id','contractNumber','rateName','itemDetail'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientContract::class, 'targetAttribute' => ['contract_id' => 'id']],
            [['unit_rate_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnitRate::class, 'targetAttribute' => ['unit_rate_id' => 'id']],
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
            'contract_id' => 'Contract ID',
            'item_id' => 'Item ID',
            'unit_rate_id' => 'Unit Rate ID',
            'price' => 'Price',
            'created_at' => 'Created At',
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
     * Gets query for [[Contract]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientContract()
    {
        return $this->hasOne(ClientContract::class, ['id' => 'contract_id']);
    }

    /**
     * Gets query for [[UnitRate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnitRate()
    {
        return $this->hasOne(UnitRate::class, ['id' => 'unit_rate_id']);
    }

    /** 
     * Gets query for [[RequestOrderTrans]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */
    public function getRequestOrderTrans()
    {
        return $this->hasMany(RequestOrderTrans::class, ['costing_id' => 'id']);
    }

    public function getItem() 
    { 
        return $this->hasOne(Item::class, ['id' => 'item_id']); 
    } 
}

<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "request_order_trans".
 *
 * @property int $id
 * @property int $request_order_id
 * @property int $costing_id
 * @property int $quantity
 * @property float $unit_price
 * @property float $sub_total
 *
 * @property Costing $costing
 * @property RequestOrder $requestOrder
 */
class RequestOrderTrans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'request_order_trans';
    }

    /**
     * {@inheritdoc}
     */
    public $contract_number;
    public $costing_name;
    public $curency_format;
    public $total_curency_format;



    public function rules()
    {
        return [
            [['request_order_id', 'costing_id', 'quantity', 'unit_price', 'sub_total'], 'required'],
            [['request_order_id', 'costing_id', 'quantity'], 'integer'],
            [['unit_price','contract_number'], 'safe'],
            [['costing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Costing::class, 'targetAttribute' => ['costing_id' => 'id']],
            [['request_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestOrder::class, 'targetAttribute' => ['request_order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_order_id' => 'Request Order ID',
            'costing_id' => 'Costing ID',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'sub_total' => 'Sub Total',
            'contract_number' => 'Contract Number',
            'costing_name' => 'Costing Name',
        ];
    }

    /**
     * Gets query for [[Costing]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCosting()
    {
        return $this->hasOne(Costing::class, ['id' => 'costing_id']);
    }

    /**
     * Gets query for [[RequestOrder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOrder()
    {
        return $this->hasOne(RequestOrder::class, ['id' => 'request_order_id']);
    }
}

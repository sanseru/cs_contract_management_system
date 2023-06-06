<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "request_order_trans_item".
 *
 * @property int $id
 * @property int $request_order_id
 * @property int $request_order_trans_id
 * @property string $resv_number
 * @property string|null $ce_year
 * @property string|null $cost_estimate
 * @property string|null $ro_number
 * @property string|null $material_incoming_date
 * @property string|null $ro_start
 * @property string|null $ro_end
 * @property string|null $urgency
 * @property int|null $qty
 * @property string|null $id_valve
 * @property string|null $size
 * @property string|null $class
 * @property string|null $equipment_type
 * @property string|null $sow
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $date_to_status
 * @property string|null $progress
 *
 * @property RequestOrder $requestOrder
 * @property RequestOrderTrans $requestOrderTrans
 */
class RequestOrderTransItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_order_trans_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_order_id', 'request_order_trans_id', 'resv_number'], 'required'],
            [['request_order_id', 'request_order_trans_id', 'qty', 'created_by', 'updated_by'], 'integer'],
            [['material_incoming_date', 'ro_start', 'ro_end', 'created_at', 'updated_at', 'date_to_status'], 'safe'],
            [['sow'], 'string'],
            [['resv_number', 'ce_year', 'cost_estimate', 'ro_number', 'urgency', 'id_valve', 'size', 'class', 'equipment_type', 'progress'], 'string', 'max' => 255],
            [['request_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestOrder::class, 'targetAttribute' => ['request_order_id' => 'id']],
            [['request_order_trans_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestOrderTrans::class, 'targetAttribute' => ['request_order_trans_id' => 'id']],
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
            'request_order_trans_id' => 'Request Order Trans ID',
            'resv_number' => 'Resv Number',
            'ce_year' => 'Ce Year',
            'cost_estimate' => 'Cost Estimate',
            'ro_number' => 'Ro Number',
            'material_incoming_date' => 'Material Incoming Date',
            'ro_start' => 'Ro Start',
            'ro_end' => 'Ro End',
            'urgency' => 'Urgency',
            'qty' => 'Qty',
            'id_valve' => 'Id Valve',
            'size' => 'Size',
            'class' => 'Class',
            'equipment_type' => 'Equipment Type',
            'sow' => 'Sow',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'date_to_status' => 'Date To Status',
            'progress' => 'Progress',
        ];
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

    /**
     * Gets query for [[RequestOrderTrans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOrderTrans()
    {
        return $this->hasOne(RequestOrderTrans::class, ['id' => 'request_order_trans_id']);
    }
    /** 
     * Gets query for [[RoTransItemSows]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */
    public function getRoTransItemSows()
    {
        return $this->hasMany(RoTransItemSow::class, ['request_order_trans_item_id' => 'id']);
    }
}

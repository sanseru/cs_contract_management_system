<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ro_trans_item_sow".
 *
 * @property int $id
 * @property int $request_order_trans_id
 * @property int $request_order_trans_item_id
 * @property int $sow_id
 * @property string $date_sow
 * @property int $created_by
 * @property string|null $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 *
 * @property RequestOrderTrans $requestOrderTrans
 * @property RequestOrderTransItem $requestOrderTransItem
 * @property MasterScopeOfWork $sow
 */
class RoTransItemSow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ro_trans_item_sow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_order_trans_id', 'request_order_trans_item_id', 'sow_id', 'date_sow', 'created_by'], 'required'],
            [['request_order_trans_id', 'request_order_trans_item_id', 'sow_id', 'created_by', 'updated_by'], 'integer'],
            [['date_sow', 'created_at', 'updated_at'], 'safe'],
            [['request_order_trans_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestOrderTrans::class, 'targetAttribute' => ['request_order_trans_id' => 'id']],
            [['request_order_trans_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestOrderTransItem::class, 'targetAttribute' => ['request_order_trans_item_id' => 'id']],
            [['sow_id'], 'exist', 'skipOnError' => true, 'targetClass' => MasterScopeOfWork::class, 'targetAttribute' => ['sow_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_order_trans_id' => 'Request Order Trans ID',
            'request_order_trans_item_id' => 'Request Order Trans Item ID',
            'sow_id' => 'Sow ID',
            'date_sow' => 'Date Sow',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
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
     * Gets query for [[RequestOrderTransItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOrderTransItem()
    {
        return $this->hasOne(RequestOrderTransItem::class, ['id' => 'request_order_trans_item_id']);
    }

    /**
     * Gets query for [[Sow]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSow()
    {
        return $this->hasOne(MasterScopeOfWork::class, ['id' => 'sow_id']);
    }
}

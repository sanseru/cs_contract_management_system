<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "request_order_activity".
 *
 * @property int $id
 * @property int $request_order_id
 * @property string $activity_code
 *
 * @property MasterActivity $activityCode
 * @property RequestOrder $requestOrder
 */
class RequestOrderActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_order_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_order_id', 'activity_code'], 'required'],
            [['request_order_id'], 'integer'],
            [['activity_code'], 'string', 'max' => 255],
            [['activity_code'], 'exist', 'skipOnError' => true, 'targetClass' => MasterActivity::class, 'targetAttribute' => ['activity_code' => 'activity_code']],
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
            'activity_code' => 'Activity Code',
        ];
    }

    /**
     * Gets query for [[ActivityCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivityCode()
    {
        return $this->hasOne(MasterActivity::class, ['activity_code' => 'activity_code']);
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

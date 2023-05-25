<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "activity_unit_rate".
 *
 * @property int $id
 * @property int $unit_rate_id
 * @property string $activity_code
 *
 * @property MasterActivity $activityCode
 * @property UnitRate $unitRate
 */
class ActivityUnitRate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_unit_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_rate_id', 'activity_code'], 'required'],
            [['unit_rate_id'], 'integer'],
            [['activity_code'], 'string', 'max' => 255],
            [['activity_code'], 'exist', 'skipOnError' => true, 'targetClass' => MasterActivity::class, 'targetAttribute' => ['activity_code' => 'activity_code']],
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
            'unit_rate_id' => 'Unit Rate ID',
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
     * Gets query for [[UnitRate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnitRate()
    {
        return $this->hasOne(UnitRate::class, ['id' => 'unit_rate_id']);
    }
}

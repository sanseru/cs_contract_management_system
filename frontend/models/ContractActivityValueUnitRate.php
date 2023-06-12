<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contract_activity_value_unit_rate".
 *
 * @property int $id
 * @property int $contract_id
 * @property int $activity_value_id
 * @property int $unit_rate_id
 *
 * @property ContractActivityValue $activityValue
 * @property ClientContract $contract
 * @property UnitRate $unitRate
 */
class ContractActivityValueUnitRate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_activity_value_unit_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contract_id', 'activity_value_id', 'unit_rate_id'], 'required'],
            [['contract_id', 'activity_value_id', 'unit_rate_id'], 'integer'],
            [['activity_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContractActivityValue::class, 'targetAttribute' => ['activity_value_id' => 'id']],
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
            'contract_id' => 'Contract ID',
            'activity_value_id' => 'Activity Value ID',
            'unit_rate_id' => 'Unit Rate ID',
        ];
    }

    /**
     * Gets query for [[ActivityValue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivityValue()
    {
        return $this->hasOne(ContractActivityValue::class, ['id' => 'activity_value_id']);
    }

    /**
     * Gets query for [[Contract]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
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
}

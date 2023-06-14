<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contract_activity_value_unit_rate_sow".
 *
 * @property int $id
 * @property int $contract_activity_value_unit_rate_id
 * @property int $sow_id
 * @property int $sow_kpi
 *
 * @property ContractActivityValueUnitRate $contractActivityValueUnitRate
 * @property MasterScopeOfWork $sow
 */
class ContractActivityValueUnitRateSow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_activity_value_unit_rate_sow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contract_activity_value_unit_rate_id', 'sow_id', 'sow_kpi'], 'required'],
            [['contract_activity_value_unit_rate_id', 'sow_id', 'sow_kpi'], 'integer'],
            [['contract_activity_value_unit_rate_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContractActivityValueUnitRate::class, 'targetAttribute' => ['contract_activity_value_unit_rate_id' => 'id']],
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
            'contract_activity_value_unit_rate_id' => 'Contract Activity Value Unit Rate ID',
            'sow_id' => 'Sow ID',
            'sow_kpi' => 'Sow Kpi',
        ];
    }

    /**
     * Gets query for [[ContractActivityValueUnitRate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractActivityValueUnitRate()
    {
        return $this->hasOne(ContractActivityValueUnitRate::class, ['id' => 'contract_activity_value_unit_rate_id']);
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

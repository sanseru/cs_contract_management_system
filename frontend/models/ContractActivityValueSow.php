<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contract_activity_value_sow".
 *
 * @property int $id
 * @property int $contract_activity_value_id
 * @property int $sow_id
 *
 * @property ContractActivityValue $contractActivityValue
 * @property MasterScopeOfWork $sow
 */
class ContractActivityValueSow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_activity_value_sow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contract_activity_value_id', 'sow_id'], 'required'],
            [['contract_activity_value_id', 'sow_id'], 'integer'],
            [['contract_activity_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContractActivityValue::class, 'targetAttribute' => ['contract_activity_value_id' => 'id']],
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
            'contract_activity_value_id' => 'Contract Activity Value ID',
            'sow_id' => 'Sow ID',
        ];
    }

    /**
     * Gets query for [[ContractActivityValue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractActivityValue()
    {
        return $this->hasOne(ContractActivityValue::class, ['id' => 'contract_activity_value_id']);
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

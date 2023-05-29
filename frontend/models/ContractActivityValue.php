<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contract_activity_value".
 *
 * @property int $id
 * @property int $contract_id
 * @property int $activity_id
 * @property float $value
 *
 * @property MasterActivity $activity
 * @property ClientContract $contract
 */
class ContractActivityValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_activity_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contract_id', 'activity_id', 'value'], 'required'],
            [['contract_id', 'activity_id'], 'integer'],
            [['value'], 'safe'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => MasterActivity::class, 'targetAttribute' => ['activity_id' => 'id']],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientContract::class, 'targetAttribute' => ['contract_id' => 'id']],
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
            'activity_id' => 'Activity ID',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Activity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(MasterActivity::class, ['id' => 'activity_id']);
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


    public static function getTotal($provider, $columnName)
    {

        $total = 0;
        foreach ($provider as $item) {
            $total += $item[$columnName];
        }
        return  Yii::$app->formatter->asCurrency($total, 'IDR');
    }
}

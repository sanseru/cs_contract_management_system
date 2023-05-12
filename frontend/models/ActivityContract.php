<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "activity_contract".
 *
 * @property int $id
 * @property string $activity
 * @property string $activityBy
 * @property string|null $description
 * @property string $status
 * @property int $created_by
 * @property string|null $created_date
 * @property int|null $updated_by
 * @property string|null $updated_date
 * @property int $contract_id
 *
 * @property Contract $contract
 */
class ActivityContract extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_contract';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity', 'activityBy', 'status', 'created_by', 'contract_id'], 'required'],
            [['activity', 'description'], 'string'],
            [['created_by', 'updated_by', 'contract_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['activityBy'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contract::class, 'targetAttribute' => ['contract_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity' => 'Activity',
            'activityBy' => 'Activity By',
            'description' => 'Description',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'contract_id' => 'Contract ID',
        ];
    }

    /**
     * Gets query for [[Contract]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::class, ['id' => 'contract_id']);
    }
}

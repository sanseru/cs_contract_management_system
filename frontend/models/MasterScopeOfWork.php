<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "master_scope_of_work".
 *
 * @property int $id
 * @property string $name_sow
 * @property ContractActivityValueSow[] $contractActivityValueSows 
 */
class MasterScopeOfWork extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_scope_of_work';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_sow'], 'required'],
            [['name_sow'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_sow' => 'Name Sow',
        ];
    }

    /** 
     * Gets query for [[ContractActivityValueSows]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */
    public function getContractActivityValueSows()
    {
        return $this->hasMany(ContractActivityValueSow::class, ['sow_id' => 'id']);
    }
}

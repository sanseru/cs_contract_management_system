<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "unit_rate".
 *
 * @property int $id
 * @property string|null $rate_name
 *
 * @property Costing[] $costings
 * @property ActivityUnitRate[] $activityUnitRates 
 */
class UnitRate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rate_name' => 'Rate Name',
        ];
    }

    /**
     * Gets query for [[Costings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCostings()
    {
        return $this->hasMany(Costing::class, ['unit_rate_id' => 'id']);
    }
    /**
    * Gets query for [[ActivityUnitRates]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getActivityUnitRates() 
   { 
       return $this->hasMany(ActivityUnitRate::class, ['activity_code' => 'activity_code']); 
   } 
 
   
}

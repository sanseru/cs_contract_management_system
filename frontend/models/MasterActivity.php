<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "master_activity".
 *
 * @property int $id
 * @property string|null $activity_code
 * @property string|null $activity_name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $has_item 
 * @property int|null $has_sow 
 * @property Item[] $items
 * @property MasterItemType[] $masterItemTypes
 * @property RequestOrderActivity[] $requestOrderActivities
 */
class MasterActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_activity';
    }

    /**
     * {@inheritdoc}
     */
    public $unitrate_activity;
    public function rules()
    {
        return [
            [['created_at', 'updated_at','unitrate_activity'], 'safe'],
            [['activity_code'], 'unique'],
            [['has_item', 'has_sow'], 'integer'],
            [['activity_code'], 'string', 'max' => 10],
            [['activity_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_code' => 'Activity Code',
            'activity_name' => 'Activity Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'has_item' => 'Has Item', 
            'has_sow' => 'Has Sow', 
        ];
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['master_activity_code' => 'id']);
    }

    /**
     * Gets query for [[MasterItemTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterItemTypes()
    {
        return $this->hasMany(MasterItemType::class, ['activity_id' => 'id']);
    }

    /**
     * Gets query for [[RequestOrderActivities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOrderActivities()
    {
        return $this->hasMany(RequestOrderActivity::class, ['activity_code' => 'id']);
    }

    
    /**
    * Gets query for [[ActivityUnitRates]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getActivityUnitRates() 
   { 
       return $this->hasMany(ActivityUnitRate::class, ['activity_code' => 'id']); 
   } 

   	/** 
    * Gets query for [[ContractActivityValues]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getContractActivityValues() 
    { 
        return $this->hasMany(ContractActivityValue::class, ['activity_id' => 'id']); 
    }
 
}

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
 *
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
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
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
        ];
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['master_activity_code' => 'activity_code']);
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
        return $this->hasMany(RequestOrderActivity::class, ['activity_code' => 'activity_code']);
    }
}

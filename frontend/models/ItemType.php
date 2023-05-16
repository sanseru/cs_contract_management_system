<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "master_item_type".
 *
 * @property int $id
 * @property int|null $activity_id
 * @property string|null $type_name
 * @property string|null $created_at
 *
 * @property MasterActivity $activity
 * @property Item[] $items
 */
class ItemType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_item_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id'], 'integer'],
            [['created_at'], 'safe'],
            [['type_name'], 'string', 'max' => 50],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => MasterActivity::class, 'targetAttribute' => ['activity_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'type_name' => 'Type Name',
            'created_at' => 'Created At',
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
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['item_type_id' => 'id']);
    }
}

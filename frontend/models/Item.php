<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string|null $size
 * @property string|null $class
 * @property string|null $description
 * @property string|null $master_activity_code
 * @property int|null $item_type_id
 *
 * @property ItemType $itemType
 * @property MasterActivity $masterActivityCode
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['item_type_id','master_activity_code'], 'integer'],
            [['size', 'class'], 'string', 'max' => 255],
            [['item_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemType::class, 'targetAttribute' => ['item_type_id' => 'id']],
            [['master_activity_code'], 'exist', 'skipOnError' => true, 'targetClass' => MasterActivity::class, 'targetAttribute' => ['master_activity_code' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'size' => 'Size',
            'class' => 'Class',
            'description' => 'Description',
            'master_activity_code' => 'Master Activity Code',
            'item_type_id' => 'Item Type ID',
        ];
    }

    /**
     * Gets query for [[ItemType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemType()
    {
        return $this->hasOne(ItemType::class, ['id' => 'item_type_id']);
    }

    /**
     * Gets query for [[MasterActivityCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterActivityCode()
    {
        return $this->hasOne(MasterActivity::class, ['id' => 'master_activity_code']);
    }
}

<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "request_order".
 *
 * @property int $id
 * @property int $contract_id
 * @property int $client_id
 * @property string $activity_code
 * @property string $so_number
 * @property string|null $ro_number
 * @property string $contract_type
 * @property string $start_date
 * @property string $end_date
 * @property int|null $status
 * @property int|null $created_by
 * @property string $created_at
 * @property int|null $updated_by
 * @property string $updated_at
 *
 * @property Client $client
 * @property ClientContract $contract
 * @property RequestOrderActivity[] $requestOrderActivities
 */
class RequestOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_order';
    }

    /**
     * {@inheritdoc}
     */

    public $activityCodeArray;
    public function rules()
    {
        return [
            [['contract_id', 'client_id', 'activity_code', 'so_number', 'contract_type', 'start_date', 'end_date', 'created_at', 'updated_at'], 'required'],
            [['contract_id', 'client_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at', 'activity_code', 'activityCodeArray'], 'safe'],
            [['so_number', 'ro_number', 'contract_type'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
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
            'client_id' => 'Client ID',
            'activity_code' => 'Activity Code',
            'so_number' => 'So Number',
            'ro_number' => 'Ro Number',
            'contract_type' => 'Contract Type',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
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

    /**
     * Gets query for [[RequestOrderActivities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOrderActivities()
    {
        return $this->hasMany(RequestOrderActivity::class, ['request_order_id' => 'id']);
    }

    public function getActivityContract()
    {
        return $this->hasMany(ActivityContract::class, ['contract_id' => 'id']);
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

<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\RequestOrder;

/**
 * RequestOrderSearch represents the model behind the search form of `frontend\models\RequestOrder`.
 */
class RequestOrderSearch extends RequestOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contract_id', 'client_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['activity_code', 'clientName' , 'so_number', 'ro_number', 'contract_type', 'start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RequestOrder::find()->joinWith('client');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        
    $dataProvider->sort->attributes['clientName'] = [
        'asc' => ['client.name' => SORT_ASC],
        'desc' => ['client.name' => SORT_DESC],
    ];
    
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'contract_id' => $this->contract_id,
            'client_id' => $this->client_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'activity_code', $this->activity_code])
            ->andFilterWhere(['like', 'so_number', $this->so_number])
            ->andFilterWhere(['like', 'ro_number', $this->ro_number])
            ->andFilterWhere(['like', 'contract_type', $this->contract_type])
            ->andFilterWhere(['like', 'client.name', $this->clientName]);

        return $dataProvider;
    }
}

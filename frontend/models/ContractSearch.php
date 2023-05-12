<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Contract;

/**
 * ContractSearch represents the model behind the search form of `frontend\models\Contract`.
 */
class ContractSearch extends Contract
{
    /**
     * {@inheritdoc}
     */

    public $clientName;

    public function rules()
    {
        return [
            [['id', 'client_id', 'status'], 'integer'],
            [['contract_number', 'clientName', 'so_number', 'contract_type', 'activity', 'start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = Contract::find()->joinWith('client');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    'id','contract_number', 'clientName', 'so_number',
                    'contract_type', 'activity', 'start_date',
                    'end_date', 'status'
                ]
            ]

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'contract_number', $this->contract_number])
            ->andFilterWhere(['like', 'so_number', $this->so_number])
            ->andFilterWhere(['like', 'contract_type', $this->contract_type])
            ->andFilterWhere(['like', 'activity', $this->activity])
            ->andFilterWhere(['like', 'client.name', $this->clientName]);

        return $dataProvider;
    }
}

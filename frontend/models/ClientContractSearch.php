<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ClientContract;

/**
 * ClientContractSearch represents the model behind the search form of `frontend\models\ClientContract`.
 */
class ClientContractSearch extends ClientContract
{
    /**
     * {@inheritdoc}
     */

    public $clientName;

    public function rules()
    {
        return [
            [['id', 'client_id', 'created_by', 'updated_by'], 'integer'],
            [['contract_number', 'start_date', 'end_date', 'created_at', 'updated_at', 'clientName'], 'safe'],
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
        $query = ClientContract::find(['client_id' => $this->client_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    'id', 'contract_number', 'clientName', 'start_date',
                    'end_date'
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
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'contract_number', $this->contract_number])
            ->andFilterWhere(['like', 'client.name', $this->clientName]);

        return $dataProvider;
    }
}

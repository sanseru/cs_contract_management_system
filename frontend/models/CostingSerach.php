<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Costing;

/**
 * CostingSerach represents the model behind the search form of `frontend\models\Costing`.
 */
class CostingSerach extends Costing
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'contract_id', 'unit_rate_id'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at','contractNumber','rateName','itemDetail','clientName'], 'safe'],
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
        $query = Costing::find()->joinWith('client')->joinWith('clientContract')->joinWith('unitRate');
        
        
        


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    'id','contractNumber', 'clientName', 'rateName',
                    'itemDetail'
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
            'contract_id' => $this->contract_id,
            'unit_rate_id' => $this->unit_rate_id,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);


        $query->andFilterWhere(['like', 'client.name', $this->clientName])
        ->andFilterWhere(['like', 'client_contract.contract_number', $this->contractNumber])
        ->andFilterWhere(['like', 'unit_rate.rate_name', $this->rateName]);

        return $dataProvider;
    }
}

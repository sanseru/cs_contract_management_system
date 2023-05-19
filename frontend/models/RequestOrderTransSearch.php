<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\RequestOrderTrans;

/**
 * RequestOrderTransSearch represents the model behind the search form of `frontend\models\RequestOrderTrans`.
 */
class RequestOrderTransSearch extends RequestOrderTrans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'request_order_id', 'costing_id', 'quantity'], 'integer'],
            [['unit_price', 'sub_total'], 'number'],
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
        $query = RequestOrderTrans::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'request_order_id' => $this->request_order_id,
            'costing_id' => $this->costing_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'sub_total' => $this->sub_total,
        ]);

        return $dataProvider;
    }
}

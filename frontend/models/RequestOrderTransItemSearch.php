<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\RequestOrderTransItem;

/**
 * RequestOrderTransItemSearch represents the model behind the search form of `frontend\models\RequestOrderTransItem`.
 */
class RequestOrderTransItemSearch extends RequestOrderTransItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'request_order_id', 'request_order_trans_id', 'qty', 'created_by', 'updated_by'], 'integer'],
            [['resv_number', 'ce_year', 'cost_estimate', 'ro_number', 'material_incoming_date', 'ro_start', 'ro_end', 'urgency', 'id_valve', 'size', 'class', 'equipment_type', 'sow', 'created_at', 'updated_at', 'date_to_status', 'progress'], 'safe'],
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
        $query = RequestOrderTransItem::find();

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
            'request_order_trans_id' => $this->request_order_trans_id,
            'material_incoming_date' => $this->material_incoming_date,
            'ro_start' => $this->ro_start,
            'ro_end' => $this->ro_end,
            'qty' => $this->qty,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'date_to_status' => $this->date_to_status,
        ]);

        $query->andFilterWhere(['like', 'resv_number', $this->resv_number])
            ->andFilterWhere(['like', 'ce_year', $this->ce_year])
            ->andFilterWhere(['like', 'cost_estimate', $this->cost_estimate])
            ->andFilterWhere(['like', 'ro_number', $this->ro_number])
            ->andFilterWhere(['like', 'urgency', $this->urgency])
            ->andFilterWhere(['like', 'id_valve', $this->id_valve])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'equipment_type', $this->equipment_type])
            ->andFilterWhere(['like', 'sow', $this->sow])
            ->andFilterWhere(['like', 'progress', $this->progress]);

        return $dataProvider;
    }
}

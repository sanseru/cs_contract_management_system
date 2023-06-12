<?php

namespace frontend\controllers;

use frontend\models\Client;
use frontend\models\ContractActivityValue;
use frontend\models\ContractActivityValueSow;
use frontend\models\RequestOrderTrans;
use frontend\models\RequestOrderTransItem;
use frontend\models\RequestOrderTransSearch;
use frontend\models\RoTransItemSow;
use Yii;
use yii\bootstrap5\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\jui\DatePicker;

/**
 * RequestOrderTransController implements the CRUD actions for RequestOrderTrans model.
 */
class RequestOrderTransController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all RequestOrderTrans models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RequestOrderTransSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single RequestOrderTrans model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RequestOrderTrans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RequestOrderTrans();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->save();
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => true];
            }
        } else {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => false, 'errors' => $model->getErrors()];
        }
    }

    /**
     * Updates an existing RequestOrderTrans model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RequestOrderTrans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $ro)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/request-order/view', 'id' => $ro]);
    }

    public function actionAddItem()
    {
        $model = new RequestOrderTransItem();

        if ($this->request->isPost && $this->request->post()) {


            $model->request_order_id =  $this->request->post('roid');
            $model->request_order_trans_id = $this->request->post('rotrans_id');
            $model->resv_number =  $this->request->post('resv-number');
            $model->ce_year =  $this->request->post('ce-year');
            $model->cost_estimate =  $this->request->post('cost-estimate');
            $model->ro_number =  $this->request->post('ro-number');
            $model->material_incoming_date =  $this->request->post('material-incoming-date');
            $model->ro_start =  $this->request->post('ro-start');
            $model->ro_end =  $this->request->post('ro-end');
            $model->urgency =  $this->request->post('urgency');
            $model->qty =  $this->request->post('qty');
            $model->id_valve =  $this->request->post('id-valve');
            $model->size =  $this->request->post('size');
            $model->class =  $this->request->post('class');
            $model->equipment_type =  $this->request->post('equipment-type');
            $model->sow =  $this->request->post('sow');
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = \Yii::$app->user->identity->id;
            $model->save();

            $tables = $this->actionShowDetails($this->request->post('rotrans_id'));

            // Return the order details as a JSON response
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => true,
                'table' => $tables,

            ];
        }
    }


    public function actionUpdateTransItem()
    {
        $id = $this->request->post('rotrans_id');
        $model = RequestOrderTransItem::findOne(['id' => $id]);
        if ($this->request->isPost && $this->request->post()) {
            $model->resv_number =  $this->request->post('resv-number');
            $model->ce_year =  $this->request->post('ce-year');
            $model->cost_estimate =  $this->request->post('cost-estimate');
            $model->ro_number =  $this->request->post('ro-number');
            $model->material_incoming_date =  $this->request->post('material-incoming-date');
            $model->ro_start =  $this->request->post('ro-start');
            $model->ro_end =  $this->request->post('ro-end');
            $model->urgency =  $this->request->post('urgency');
            $model->qty =  $this->request->post('qty');
            $model->id_valve =  $this->request->post('id-valve');
            $model->size =  $this->request->post('size');
            $model->class =  $this->request->post('class');
            $model->equipment_type =  $this->request->post('equipment-type');
            $model->sow =  $this->request->post('sow');
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = \Yii::$app->user->identity->id;
            $model->save();

            $tables = $this->actionShowDetails($model->request_order_trans_id);

            // Return the order details as a JSON response
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => true,
                'table' => $tables,

            ];
        }
    }

    /**
     * Finds the RequestOrderTrans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return RequestOrderTrans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RequestOrderTrans::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFindRequestOrderTransItems()
    {
        $id = Yii::$app->request->post('itemId');
        if (($model = RequestOrderTransItem::findOne(['id' => $id])) !== null) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => true,
                'orderDetails' => [
                    'roti' => $id,
                    'model' => $model,
                    // Add more order details as needed
                ]
            ];
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionShowDetails($id = '')
    {
        $id = $id ?: Yii::$app->request->post('id');

        $model = $this->findModel($id);
        // Your logic to retrieve the order details using the $orderId goes here
        $record = ContractActivityValue::find()
            ->where(['contract_id' => $model->requestOrder->contract_id, 'activity_id' => $model->costing->item->masterActivityCode->id])
            ->one();

        $record_item = RequestOrderTransItem::find()
            ->where(['request_order_trans_id' => $id, 'request_order_id' => $model->request_order_id])
            ->all();



        $column = ContractActivityValueSow::find()
            ->where(['contract_activity_value_id' => $record->id])
            ->all();

        $roitemsow = RoTransItemSow::find()
            ->where(['request_order_trans_id' => $id])
            ->all();


        $tables = '<div class="text-white d-flex justify-content-between align-items-center"><p style="color:black">Item Valve Repair</p><button type="button" id="btn_item" class="btn btn-sm btn-primary mb-2 float-end" data-id="' . $id . '" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button></div>';
        $tables .= ' <div class="table-responsive"><table class="table table-bordered" id="tablesed">
          <thead>
          <tr>
          ';

        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>RESV NUMBER</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>CE YEAR</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>COST ESTIMATE</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>RO NUMBER</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>MATERIAL INCOMING DATE</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>RO START</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>RO END</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>URGENCY</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>QTY</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>ID VALVE</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>SIZE</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>CLASS</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>EQUIPMENT TYPE</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>SOW</th>";
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>PROGRESS</th>";

        foreach ($column as $value) {
            $tables .= "<th style='font-size:12px' colspan='2'>" . $value->sow->name_sow . "</th>";
        }
        $tables .= "<th rowspan='2' style='font-size:0.8rem;width:100%'>Action</th>";
        $tables .= "
        </tr><tr>";
        // $tables .= "<th style='font-size:0.8rem' colspan='14'></th>";
        foreach ($column as $value) {
            $tables .= "<th style='font-size:0.8rem'>Tanggal</th>";
            $tables .= "<th style='font-size:0.8rem'>Ket</th>";
        }

        $tables .= "</tr>";
        $tables .= "</thead>
          <tbody>";

        foreach ($record_item as $value) {
            // print_r( $value);die;

            $tables .= "<tr>";
            $ro_start = date("d M Y", strtotime($value->ro_start));
            $ro_end = date("d M Y", strtotime($value->ro_end));
            $material_incoming_date = date("d M Y", strtotime($value->material_incoming_date));


            $tables .= "<td style='font-size:0.8rem'>$value->resv_number</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->ce_year</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->cost_estimate</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->ro_number</td>";
            $tables .= "<td style='font-size:0.8rem'>$material_incoming_date</td>";
            $tables .= "<td style='font-size:0.8rem'>$ro_start</td>";
            $tables .= "<td style='font-size:0.8rem'>$ro_end</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->urgency</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->qty</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->id_valve</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->size</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->class</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->equipment_type</td>";
            $tables .= "<td style='font-size:0.8rem'>$value->sow</td>";





            $filteredArray4 = array_filter($roitemsow, function ($item) use ($value) {
                return $item->request_order_trans_item_id == $value->id;
            });


            $filteredArray5 = array_filter($roitemsow, function ($item) use ($value) {
                return $item->request_order_trans_item_id == $value->id && $item->status == 1;
            });
            $count = count($column);
            $maxValue = count($filteredArray5);


            $persentvalue = 0;
            $progressBarWidth = 0;

            if ($count != 0 &&  $maxValue != 0) {
                // $progressBarWidth = ($count / $maxValue) * 100;
                $persentvalue = round(($maxValue / $count) * 100, 0);
                $progressBarWidth = round(($maxValue / $count) * 100, 0);
            }





            $tables .= "<td>
                <div class=\"progress\">
                    <div class=\"progress-bar text-center text-red\" role=\"progressbar\" style=\"width: $progressBarWidth%;color: greenyellow; font-weight: bolder;\" aria-valuenow=\"$count\" aria-valuemin=\"0\" aria-valuemax=\"$maxValue\"> $persentvalue%</div>
                </div>
            </td>";



            $filteredArray = array_filter($roitemsow, function ($item) use ($value) {
                return $item->request_order_trans_item_id == $value->id;
            });

            foreach ($column as $valuex) {
                $filteredArrays = array_filter($filteredArray, function ($item) use ($valuex) {
                    return $item->sow_id == $valuex->sow_id;
                });
                $tablex = "<td style='font-size:0.8rem'>-</td>";
                $tablexs = "<td style='font-size:0.8rem'>-</td>";
                foreach ($filteredArrays as $key => $valuez) {
                    if ($valuez) {
                        if ($valuez->status == 1) {
                            $check = '<i class="fa-solid fa-circle-check fa-xl" style="color: #29b503;"></i>';
                        } else {
                            $check = '<i class="fa-solid fa-circle-minus fa-xl" style="color: #c70505;"></i>';
                        }
                        $tablex = "<td style='font-size:0.8rem'>" . date("d M Y", strtotime($valuez->date_sow)) . "</td>";
                        $tablexs = "<td style='font-size:0.8rem;text-align: center'>" . $check . "</td>";
                    } else {
                        $tablex = "<td style='font-size:0.8rem'>-</td>";
                        $tablexs = "<td style='font-size:0.8rem'>-</td>";
                    }
                }
                $tables .= $tablex;
                $tables .= $tablexs;
            }
            $tables .= "<td style='font-size:0.8rem'>
            <button type='button' class='btn btn-outline-info btn-sm editItems' data-id='" . $value->id . "' data-reqid='" . $id . "' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class=\"fa-solid fa-list fa-2xs\"></i></button></i>
            <button type='button' class='btn btn-outline-info btn-sm editItem' data-id='" . $value->id . "' data-reqid='" . $id . "' data-bs-toggle='modal' data-bs-target='#addItemModal'><i class=\"fa-solid fa-pen-to-square fa-2xs\"></i></button></i>
            
            </td>";
            $tables .= "</tr>";
        }



        $tables .= '    </tbody>
          </table></div>';
        // Return the order details as a JSON response
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'orderDetails' => [
                'orderId' => $id,
                'table' => $tables,
                // Add more order details as needed
            ]
        ];
    }

    public function actionUpdateItem()
    {
        $itemId = Yii::$app->request->post('itemId');
        $reqId = Yii::$app->request->post('reqId');
        // Do something with $itemId and $reqId
        $model = $this->findModel($reqId);

        // Your logic to retrieve the order details using the $orderId goes here
        $record = ContractActivityValue::find()
            ->where(['contract_id' => $model->requestOrder->contract_id, 'activity_id' => $model->costing->item->masterActivityCode->id])
            ->one();

        $column = ContractActivityValueSow::find()
            ->where(['contract_activity_value_id' => $record->id])
            ->all();

        // Create the select form with options
        $options = [];
        foreach ($column as $c) {
            $options[$c->sow_id] = $c->sow->name_sow;
        }
        $selectLabel = Html::label('Select SOW:', 'select_input');
        $selectForm = Html::dropDownList('select_input', null, $options, ['class' => 'form-control mb-3', 'prompt' => 'Select SOW',  'required' => true]);
        // Create the date input and submit button
        $dateLabel = Html::label('Select Date:', 'date_input');
        // $dateInput = Html::input('date_input', 'date', date('Y-m-d'), ['class' => 'form-control mb-3']);
        $dateInput = '<input type="date" class="form-control mb-3" autocomplete="off" id="date_input" name="date_input" required>';
        $statusLabel = Html::label('Select Status:', 'status');

        $status = '<select name="status" class="form-control mb-3" required>
        <option >Select Status</option>
        <option value="0">Pending</option>
        <option value="1">Done</option>
      </select>';
        $ro_item_id = '<input type="hidden" class="form-control mb-3" autocomplete="off" value="' . $itemId . '" id="ro_item_id" name="ro_item_id">';
        $ro_trans_id = '<input type="hidden" class="form-control mb-3" autocomplete="off" value="' . $reqId . '" id="ro_trans_item_id" name="ro_trans_item_id">';
        $ro_id = '<input type="hidden" class="form-control mb-3" autocomplete="off" value="' . $model->request_order_id . '" id="ro_id" name="ro_id">';

        $submitButton = Html::submitButton('Submit', ['class' => 'btn btn-primary float-end']);
        $forms = $selectLabel . $selectForm .  $dateLabel . $dateInput . $statusLabel . $status . $ro_item_id . $ro_trans_id . $ro_id . $submitButton;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['success' => true, 'form' => $forms];
    }

    public function actionInsertUpdateItem()
    {
        $model = new RoTransItemSow();
        if ($this->request->isPost && $this->request->post()) {
            $selectInput = Yii::$app->request->post('select_input');
            $dateInput = Yii::$app->request->post('date_input');
            $roItemId = Yii::$app->request->post('ro_item_id');
            $roTransId = Yii::$app->request->post('ro_trans_item_id');
            $roId = Yii::$app->request->post('ro_id');
            $status = Yii::$app->request->post('status');

            // Check if a record with the given request_order_trans_id and request_order_trans_item_id exists
            $existingModel = RoTransItemSow::findOne([
                'request_order_trans_id' => $roTransId,
                'request_order_trans_item_id' => $roItemId,
                'sow_id' => $selectInput,

            ]);

            if ($existingModel) {
                // Update the existing record
                $existingModel->date_sow = $dateInput;
                $existingModel->status = $status;
                $existingModel->updated_at = date('Y-m-d H:i:s');
                $existingModel->updated_by = \Yii::$app->user->identity->id;
                $existingModel->save(false);
            } else {
                // Create a new record
                $model->request_order_trans_id = $roTransId;
                $model->request_order_trans_item_id = $roItemId;
                $model->sow_id = $selectInput;
                $model->date_sow = $dateInput;
                $model->status = $status;
                $model->created_at = date('Y-m-d H:i:s');
                $model->created_by = \Yii::$app->user->identity->id;
                $model->save(false);
            }

            $tables = $this->actionShowDetails($roTransId);
            // Return the order details as a JSON response
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => true,
                'tables' => $tables,

            ];
        }

 
    }
}

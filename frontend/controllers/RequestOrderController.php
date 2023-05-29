<?php

namespace frontend\controllers;

use frontend\models\Costing;
use frontend\models\RequestOrder;
use frontend\models\RequestOrderActivity;
use frontend\models\RequestOrderSearch;
use frontend\models\RequestOrderTrans;
use frontend\models\RequestOrderTransSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * RequestOrderController implements the CRUD actions for RequestOrder model.
 */
class RequestOrderController extends Controller
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
     * Lists all RequestOrder models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RequestOrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RequestOrder model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $dataRequestOrderTransModel = new RequestOrderTrans();
        $dataRequestOrderTranssearchModel = new RequestOrderTransSearch(['request_order_id' => $id]);
        $dataRequestOrderTransProvider = $dataRequestOrderTranssearchModel->search($this->request->queryParams);


        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataRequestOrderTranssearchModel' => $dataRequestOrderTranssearchModel,
            'dataRequestOrderTransProvider' => $dataRequestOrderTransProvider,
            'dataRequestOrderTransModel' => $dataRequestOrderTransModel,
        ]);
    }

    /**
     * Creates a new RequestOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RequestOrder();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->start_date = date('Y-m-d', strtotime($model->start_date));
                $model->end_date = date('Y-m-d', strtotime($model->end_date));
                $model->created_at = date('Y-m-d H:i:s');
                $model->created_by = \Yii::$app->user->identity->id;
                $model->updated_at = date('Y-m-d H:i:s');
                $model->activity_code = ' ';
                $model->save(false);
                foreach ($model->activityCodeArray as $activity_code) {
                    $pivot = new RequestOrderActivity();
                    $pivot->request_order_id = $model->id;
                    $pivot->activity_code = $activity_code;
                    $pivot->save(false);
                }

                return $this->redirect(['view', 'id' => $model->id]);
                // return $this->redirect(['create']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RequestOrder model.
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

        $selectedCodes = $model->requestOrderActivities; // assuming attribute name is activityCodes


        $activityCodes = [];

        foreach ($selectedCodes as $item) {
            $activityCodes[] = $item->attributes['activity_code'];
        }
        $model->activityCodeArray = json_encode($activityCodes);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RequestOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RequestOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return RequestOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RequestOrder::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionSelect2Get()
    {

        $search = \Yii::$app->request->get('q');
        $id = \Yii::$app->request->get('id');

        $data = $this->findModel($id);
        $activitiex = array_map(function ($activity) {
            return $activity->activityCode->id;
        }, $data->requestOrderActivities);
        $activityx =  implode(', ', $activitiex);
        $activityArray = explode(', ', $activityx);

        if (!empty($search)) {
            $costings = Costing::find()
                ->joinWith('item')
                ->joinWith('unitRate')
                ->joinWith('item.itemType')
                ->joinWith('item.masterActivityCode')
                ->where(['client_id' => $data->client_id])
                ->andWhere(['IN', 'item.master_activity_code', $activityArray]) // add any other conditions here
                ->andWhere([
                    'or',
                    ['like', 'activity_name', $search],
                    ['like', 'type_name', $search],
                    ['like', 'item.class', $search],
                    ['like', 'price', $search],
                    ['like', 'size', $search],
                    ['like', 'unitRate.rate_name', $search],
                ])
                ->all();
        } else {
            $costings = Costing::find()
                ->joinWith('item')
                ->joinWith('unitRate')
                ->where(['client_id' => $data->client_id])
                ->andWhere(['IN', 'item.master_activity_code', $activityArray]) // add any other conditions here
                ->all();
        }


        // Format the data as required by Select2
        $data = [];
        foreach ($costings as $cost) {

            $data[] = [
                'id' => $cost->id,
                'activity_name' => strtoupper($cost->item->masterActivityCode->activity_name),
                'type_name' => strtoupper($cost->item->itemType->type_name),
                'size' => strtoupper($cost->item->size),
                'class' => strtoupper($cost->item->class),
                'price' => number_format($cost->price, 0, ',', '.'),
                'unitrate' => strtoupper($cost->unitRate->rate_name),


            ];
        }

        // Output the data as JSON
        return Json::encode([
            'results' => $data,
            'pagination' => ['more' => false], // Pagination not implemented in this example
        ]);
    }
}

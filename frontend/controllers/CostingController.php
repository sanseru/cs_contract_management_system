<?php

namespace frontend\controllers;

use frontend\models\Client;
use frontend\models\Costing;
use frontend\models\CostingSerach;
use frontend\models\Item;
use frontend\models\UnitRate;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * CostingController implements the CRUD actions for Costing model.
 */
class CostingController extends Controller
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
     * Lists all Costing models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CostingSerach();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Costing model.
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
     * Creates a new Costing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Costing();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateAjax()
    {
        $model = new Costing();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');
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
     * Updates an existing Costing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if (\Yii::$app->getRequest()->get('url_back')) {
                Yii::$app->session->setFlash('success', 'Costing Record deleted successfully.');
                return $this->redirect(['client-contract/view', 'id' => \Yii::$app->getRequest()->get('contract_id')]);
            } else {
                Yii::$app->session->setFlash('success', 'Record deleted successfully.');

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Costing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if (\Yii::$app->getRequest()->get('url_back')) {
            Yii::$app->session->setFlash('success', 'Costing Record deleted successfully.');
            return $this->redirect(['client-contract/view', 'id' => \Yii::$app->getRequest()->get('contract_id')]);
        } else {
            Yii::$app->session->setFlash('success', 'Record deleted successfully.');

            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Costing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Costing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Costing::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSelect2Get()
    {
        // $clients =  Costing::find()->asArray()->all();
        $clients =  Costing::find()->all();
        // Format the data as required by Select2
        $data = [];
        foreach ($clients as $client) {

            $data[] = [
                'id' => $client['id'],
                'client_name' => $client->client->name,
                'unit_rate' => $client->unitRate->rate_name,
                'price' => $client->price,


            ];
        }

        // Output the data as JSON
        return Json::encode([
            'results' => $data,
            'pagination' => ['more' => false], // Pagination not implemented in this example
        ]);
    }

    public function actionGetprice($costingId)
    {
        $product = $this->findModel($costingId); // find the product with the given ID
        $price = $product->price; // get the price of the product

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; // set the response format to JSON
        return [
            'price' => $price
        ];
    }

    public function actionFetchOptionsUnitRate($item_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $item = Item::find()
            ->joinWith('masterActivityCode')
            ->where(['item.id' => $item_id])->one();

        $masterActivity = $item->masterActivityCode; // Accessing the related MasterActivity object



        $unitRateIds = [];
        foreach ($masterActivity->activityUnitRates as $activityUnitRate) {
            $unitRateIds[] = $activityUnitRate->unit_rate_id;
        }

        // Fetch the options based on the $item_id
        $options = UnitRate::find()
            ->where(['IN', 'id', $unitRateIds])
            ->all();

        $data = [];
        foreach ($options as $option) {
            $data[$option->id] = $option->rate_name;
        }

        return $data;
    }
}

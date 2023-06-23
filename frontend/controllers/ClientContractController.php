<?php

namespace frontend\controllers;

use frontend\models\ClientContract;
use frontend\models\ClientContractSearch;
use frontend\models\ContractActivityValueSearch;
use frontend\models\Costing;
use frontend\models\CostingSerach;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientContractController implements the CRUD actions for ClientContract model.
 */
class ClientContractController extends Controller
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
                            'matchCallback' => function ($rule, $action) {
                                return !Yii::$app->user->isGuest && (Yii::$app->user->identity->user_type_id == 1 || Yii::$app->user->identity->user_type_id == 2);
                            },
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
     * Lists all ClientContract models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientContractSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientContract model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id,$req_order)
    {
        $data = $this->findModel($id);

        $searchModelCosting = new CostingSerach(['client_id' => $data->client_id,'contract_id'=> $data->id]);
        $dataCostingProvider = $searchModelCosting->search($this->request->queryParams);
        $searchModelcav = new ContractActivityValueSearch(['contract_id' => $data->id]);
        $dataProvidercav = $searchModelcav->search($this->request->queryParams);
        $costing = new Costing();

        // $budgetData = $this->generateRandomData();
        $budgetData = $dataProvidercav->getModels();

        // Array of labels
        $budgets = [];
        // Loop over the array of objects and extract the id property
        foreach ($budgetData as $object) {
            $budgets[] = $object->value;
        }

        $actuals = [];
        // Loop over the array of objects and extract the id property
        foreach ($budgetData as $object) {
            $actuals[] = $object->value - rand(100000, 800000);
        }

        $actualsData = $this->generateRandomData();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModelCosting' => $searchModelCosting,
            'dataCostingProvider' => $dataCostingProvider,
            'searchModelcav' => $searchModelcav,
            'dataProvidercav' => $dataProvidercav,
            'costing' => $costing,
            'budgetData' => $budgets,
            'actualsData' => $actuals,


        ]);
    }


    private function generateRandomData()
    {
        return [
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
            rand(1000, 5000),
        ];
    }

    /**
     * Creates a new ClientContract model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ClientContract();

        if ($this->request->isAjax && $this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->start_date = date('Y-m-d', strtotime($model->start_date));
                $model->end_date = date('Y-m-d', strtotime($model->end_date));
                $model->created_at = date('Y-m-d H:i:s');
                $model->created_by = \Yii::$app->user->identity->id;

                if ($model->save()) {
                    return json_encode(['status' => 'success']);
                } else {
                    return json_encode(['status' => 'error']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClientContract model.
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
     * Deletes an existing ClientContract model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $clientId = \Yii::$app->request->get('client');

        if ($model->delete()) {
            \Yii::$app->session->setFlash('success', 'Delete Success');
            return $this->redirect(['client/view', 'id' => $clientId]);
        } else {
            \Yii::$app->session->setFlash('error', 'Failed Delete Data');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClientContract model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ClientContract the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientContract::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

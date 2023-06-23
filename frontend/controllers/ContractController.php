<?php

namespace frontend\controllers;

use frontend\models\Client;
use frontend\models\Contract;
use frontend\models\ContractSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ContractController implements the CRUD actions for Contract model.
 */
class ContractController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
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
            ]
        );
    }

    /**
     * Lists all Contract models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ContractSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        // print_r($searchModel);die;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contract model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $client = $model->getClient()->one();
        $activity = $model->getActivity()->all();
        return $this->render('view', [
            'model' => $model,
            'client' => $client,
            'activity' => $activity,

        ]);
    }

    /**
     * Creates a new Contract model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Contract();
        $modelCLient = new Client();
        if ($this->request->isPost) {
            // print_r($model->activity);die;

            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($model->load($this->request->post())) {
                    // $so_number = $this->request->post('so_number');
                    $so_number = $model->so_number;

                    if (!isset($so_number) && empty($so_number)) {
                        $so_number = "";
                    }

                    $exist = Client::find()->where(['name' => $this->request->post('client_name')])->count();
                    $clientId = 0;
                    // if ($exist == 0 && !isset($so_number) && empty($so_number)) {
                    if ($exist == 0) {


                        $modelCLient->name = $this->request->post('client_name');
                        $modelCLient->address = '';
                        $modelCLient->phone_number = '';
                        $modelCLient->email = '';
                        $modelCLient->created_by = \Yii::$app->user->identity->id;
                        $modelCLient->created_at = date('Y-m-d H:i:s');
                        $modelCLient->updated_at = date('Y-m-d H:i:s');

                        if (!$modelCLient->save(false)) {
                            throw new \Exception('Failed to save client');
                        }

                        $clientId = $modelCLient->id;
                    }
                    $activity = implode(',', $this->request->post('Contract')['activity']);
                    $model->activity = $activity;
                    $model->so_number = $so_number;
                    $model->client_id = $clientId;
                    $model->start_date = date('Y-m-d', strtotime($model->start_date));
                    $model->end_date = date('Y-m-d', strtotime($model->end_date));
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->created_by = \Yii::$app->user->identity->id;
                    $model->updated_at = date('Y-m-d H:i:s');


                    if (!$model->save(false)) {
                        throw new \Exception('Failed to save contract');
                    }
                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                \Yii::error($e->getMessage());
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contract model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $client = $model->getClient()->one();

        if ($this->request->isPost && $model->load($this->request->post())) {
            // $so_number = $this->request->post('so_number');
            $so_number = $model->so_number;

            $clientId = $model->getOldAttribute('client_id');

            if (!isset($so_number) && empty($so_number)) {
                $so_number = "";
            }
            // if ($model->getOldAttribute('so_number') != $so_number) {
            // print_r($this->request->post('client_name'));die;

            if ($model->getOldAttribute('client_name') != $this->request->post('client_name')) {
                $modelCLient = new Client();
                $exist = Client::find()->where(['id' => $this->request->post('client_name')])->count();
                $clientId = 0;
                // if ($exist == 0 && isset($so_number) && !empty($so_number)) {
                if ($exist == 0) {

                    $modelCLient->name = $this->request->post('client_name');
                    $modelCLient->address = '';
                    $modelCLient->phone_number = '';
                    $modelCLient->email = '';
                    $modelCLient->created_at = date('Y-m-d H:i:s');
                    $modelCLient->updated_at = date('Y-m-d H:i:s');

                    if (!$modelCLient->save(false)) {
                        throw new \Exception('Failed to save client');
                    }

                    $clientId = $modelCLient->id;
                } else {
                    $exist = Client::find()->where(['id' => $this->request->post('client_name')])->one();
                    $clientId = $exist->id;
                }
            }
            $activity = implode(',', $this->request->post('Contract')['activity']);
            $model->activity = $activity;

            $model->so_number = $so_number;
            $model->client_id = $clientId;
            $model->start_date = date('Y-m-d', strtotime($model->start_date));
            $model->end_date = date('Y-m-d', strtotime($model->end_date));
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->activity = explode(',', $model->activity);
        return $this->render('update', [
            'model' => $model,
            'client' => $client,

        ]);
    }

    /**
     * Deletes an existing Contract model.
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
     * Finds the Contract model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Contract the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contract::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

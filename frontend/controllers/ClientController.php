<?php

namespace frontend\controllers;

use frontend\models\Client;
use frontend\models\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use frontend\models\ClientContract;
use frontend\models\ClientContractSearch;
use Yii;
use yii\filters\AccessControl;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
     * Lists all Client models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModelClientContract = new ClientContractSearch(['client_id' => $id]);
        $dataProviderClientContract = $searchModelClientContract->search($this->request->queryParams);
        $modelClientContract = new ClientContract();
        $clientContract = $modelClientContract->getClient()->one();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModelClientContract' => $searchModelClientContract,
            'dataProviderClientContract' => $dataProviderClientContract,
            'modelClientContract' => $modelClientContract,
            'clientContract' => $clientContract
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');
                $model->save();
                Yii::$app->session->setFlash('success', "Client Created.");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Client Created.");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Client Delete Success.");

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSelect2Get()
    {
        $clients =  Client::find()->select(['id', 'name'])->asArray()->all();
        // Format the data as required by Select2
        $data = [];
        foreach ($clients as $client) {
            $data[] = [
                'id' => $client['id'],
                'text' => $client['name'],
            ];
        }

        // Output the data as JSON
        return Json::encode([
            'results' => $data,
            'pagination' => ['more' => false], // Pagination not implemented in this example
        ]);
    }

    public function actionGetClient($id)
    {
        $clients =  ClientContract::findOne(['id'=>$id]);
        
        $model = $this->findModel($clients->client_id);
        return Json::encode($model);
    }
}

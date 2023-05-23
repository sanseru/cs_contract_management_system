<?php

namespace frontend\controllers;

use frontend\models\Client;
use frontend\models\RequestOrderTrans;
use frontend\models\RequestOrderTransSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
    public function actionDelete($id,$ro)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/request-order/view', 'id'=>$ro]);
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
}

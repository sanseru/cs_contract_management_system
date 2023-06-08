<?php

namespace frontend\controllers;

use frontend\models\ContractActivityValue;
use frontend\models\ContractActivityValueSearch;
use frontend\models\ContractActivityValueSow;
use frontend\models\MasterScopeOfWork;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ContractActivityValueController implements the CRUD actions for ContractActivityValue model.
 */
class ContractActivityValueController extends Controller
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
     * Lists all ContractActivityValue models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ContractActivityValueSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ContractActivityValue model.
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
     * Creates a new ContractActivityValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id, $req_order)
    {
        $model = new ContractActivityValue();
        if ($this->request->isPost) {
            $sows = Yii::$app->request->post('sow', []);
            $kpisows = Yii::$app->request->post('kpisow', []);
            if ($model->load($this->request->post())) {
                $model->save();
                foreach ($sows as $key => $sowId) {
                    $cavsow = new ContractActivityValueSow();
                    $cavsow->contract_activity_value_id = $model->id;
                    $cavsow->sow_id = $sowId;
                    $cavsow->sow_kpi = $kpisows[$key];
                    $cavsow->save();
                }
                \Yii::$app->session->setFlash('success', "Add KPI Activity Success.");
                return $this->redirect(['/client-contract/view', 'id' => $id, 'req_order' => $req_order, 'kpi' => true]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'contract_id' => $id,
            'req_order' => $req_order,
        ]);
    }

    /**
     * Updates an existing ContractActivityValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $contract_id, $req_order)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $sows = Yii::$app->request->post('sow', []);
            $kpisows = Yii::$app->request->post('kpisow', []);
            ContractActivityValueSow::deleteAll(['contract_activity_value_id' => $id]);
            foreach ($sows as $key => $sowId) {
                $cavsow = new ContractActivityValueSow();
                $cavsow->contract_activity_value_id = $model->id;
                $cavsow->sow_id = $sowId;
                $cavsow->sow_kpi = $kpisows[$key];
                $cavsow->save();
            }
            \Yii::$app->session->setFlash('success', "Update KPI Activity Success.");
            return $this->redirect(['/client-contract/view', 'id' => $contract_id, 'req_order' => $req_order, 'kpi' => true]);

            // return $this->redirect(['view', 'id' => $model->id]);
        }

        $selectedSow = $model->contractActivityValueSows; // assuming attribute name is activityCodes
        $activitySowData = [];

        foreach ($selectedSow as $sow) {
            $activitySowData[] = $sow->sow_id;
        }

        $model->sow = json_encode($activitySowData);

        return $this->render('update', [
            'model' => $model,
            'contract_id' => $contract_id,
            'req_order' => $req_order,
        ]);
    }

    /**
     * Deletes an existing ContractActivityValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $contract_id, $req_order)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['/client-contract/view', 'id' => $contract_id, 'req_order' => $req_order, 'kpi' => true]);
    }

    /**
     * Finds the ContractActivityValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ContractActivityValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContractActivityValue::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionGetData($search = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $query = MasterScopeOfWork::find()
            ->select(['id', 'name_sow'])
            ->andFilterWhere(['like', 'name_sow', $search])
            ->limit(10)
            ->asArray()
            ->all();

        return $query;
    }
}

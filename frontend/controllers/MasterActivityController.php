<?php

namespace frontend\controllers;

use frontend\models\ActivityUnitRate;
use frontend\models\MasterActivity;
use frontend\models\MasterActivitySearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterActivityController implements the CRUD actions for MasterActivity model.
 */
class MasterActivityController extends Controller
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
     * Lists all MasterActivity models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterActivitySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterActivity model.
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
     * Creates a new MasterActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MasterActivity();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $existingActivity = MasterActivity::findOne(['id' => $model->activity_code]);

                if ($existingActivity) {
                    Yii::$app->session->setFlash('error', 'Activity code already exists. Please choose a different code.');
                    return $this->refresh();
                }
                $model->created_at = date('Y-m-d H:i:s');
                $model->save(false);
                foreach ($model->unitrate_activity as $activity_code) {
                    $ac_unit = new ActivityUnitRate();
                    $ac_unit->activity_code = $model->id;
                    $ac_unit->unit_rate_id = $activity_code;
                    $ac_unit->save();
                }
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterActivity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            // Clear existing activity unit rates for the model
            ActivityUnitRate::deleteAll(['id' => $model->id]);
            if ($model->unitrate_activity) {
                foreach ($model->unitrate_activity as $activity_code) {
                    // Check if the activity unit rate already exists for the model
                    $existingUnitRate = ActivityUnitRate::findOne([
                        'activity_code' => $model->id,
                        'unit_rate_id' => $activity_code,
                    ]);

                    if (!$existingUnitRate) {
                        $ac_unit = new ActivityUnitRate();
                        $ac_unit->activity_code = $model->id;
                        $ac_unit->unit_rate_id = $activity_code;
                        $ac_unit->save(false);
                    }
                }
            }
            return $this->redirect(['index']);
        }


        $selectedUnitRate = $model->activityUnitRates; // assuming attribute name is activityCodes
        $activityUnitRate = [];

        foreach ($selectedUnitRate as $item) {
            $activityUnitRate[] = $item->unit_rate_id;
        }

        $model->unitrate_activity = json_encode($activityUnitRate);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MasterActivity model.
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
     * Finds the MasterActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterActivity::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace frontend\controllers;

use frontend\models\ActivityContract;
use frontend\models\ActivityContractSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ActivityContractController implements the CRUD actions for ActivityContract model.
 */
class ActivityContractController extends Controller
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
     * Lists all ActivityContract models.
     *
     * @return string
     */
    public function actionIndex()
    {
        throw new NotFoundHttpException('The requested page does not exist.');

        $searchModel = new ActivityContractSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ActivityContract model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ActivityContract model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $model = new ActivityContract();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->created_by = \Yii::$app->user->identity->id;
                $model->save(false);
                return $this->redirect(['request-order/view', 'id' => $id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'id' => $id
        ]);
    }

    /**
     * Updates an existing ActivityContract model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $contract_id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save(false)) {
            return $this->redirect(['request-order/view', 'id' => $contract_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'id' => $contract_id
        ]);
    }

    /**
     * Deletes an existing ActivityContract model.
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
     * Finds the ActivityContract model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ActivityContract the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActivityContract::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }




    public function actionUploadImage()
    {
        if (\Yii::$app->request->isAjax) {
            $image = UploadedFile::getInstanceByName('image');
            $filename = uniqid() . time() . '.' . $image->extension;
            $image->saveAs('uploads/' . $filename);
            // if ($image->upload()) {
            //     $imageUrl = \Yii::getAlias('@web/uploads/') . $image->imageFile->name;
            //     var_dump($imageUrl);die;
            //     \Yii::$app->response->data = [
            //         'filelink' => $imageUrl,
            //     ];
            // }
            // process the data here
            //     return json_encode(['success' => true]); // return a JSON response
            return json_encode([
                'success' => true,
                'url' => \Yii::$app->urlManager->createUrl(['uploads/' . $filename])
            ]); // return a JSON response

        } else {
            throw new \yii\web\BadRequestHttpException('Invalid request'); // throw an error if the request is not AJAX
        }
    }
}

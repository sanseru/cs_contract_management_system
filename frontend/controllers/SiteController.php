<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\ActivityContract;
use frontend\models\Client;
use frontend\models\ClientContract;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\ContractActivityValue;
use frontend\models\ContractActivityValueSearch;
use frontend\models\Costing;
use frontend\models\RequestOrder;
use frontend\models\RequestOrderTrans;
use Symfony\Component\Finder\Finder;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'index', 'about'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    // render the login view if user is not authenticated
                    return $this->redirect(['site/login']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
                'layout' => 'error-layout', // Set the new layout here
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        if (Yii::$app->user->identity->user_type_id != 3) {
            $client = Client::find()->count();

            $requestreceive = RequestOrder::find()->where(['status' => 1])->count();
            $requestWorkinProgress = RequestOrder::find()->where(['status' => 2])->count();

            $requestProgress = RequestOrder::find()->where(['in', 'status',[1,2]])->count();
            $requestCompleted = RequestOrder::find()->where(['status' => 3])->count();

            $requestInvoiced = RequestOrder::find()->where(['status' => 4])->count();

            $requestPaid = RequestOrder::find()->where(['status' => 9])->count();
            $contractCount = ClientContract::find()->count();

            $invoiced = RequestOrder::find()->where(['status' => 4])->joinWith('requestOrderTrans')->sum('request_order_trans.sub_total');
            $paid = RequestOrder::find()->where(['status' => 9])->joinWith('requestOrderTrans')->sum('request_order_trans.sub_total');

            $activityOpen = ActivityContract::find()->where(['status' => 1])->count();
            $activityProcess = ActivityContract::find()->where(['status' => 2])->count();

            return $this->render('index', [
                'client' => $client??0,
                'requestreceive' => $requestreceive??0,
                'requestWorkinProgress' => $requestWorkinProgress??0,
                'requestProgress' => $requestProgress??0,
                'requestCompleted' => $requestCompleted??0,
                'requestInvoiced' => $requestInvoiced??0,
                'requestPaid' => $requestPaid??0,
                'contractCount' => $contractCount??0,
                'activityOpen' => $activityOpen??0,
                'activityProcess' => $activityProcess??0,
                'invoiced' => $invoiced??0,
                'paid' => $paid??0,
            ]);
        } else {
            $request = \Yii::$app->request;
            $id = $request->get('id'); // Mengambil nilai 'id' dari parameter URL
            $clientId = Yii::$app->user->identity->client_id;
            $contractdata = ClientContract::find()->where(['client_id' => $clientId])->all();
            $resultArray = [];

            if (!empty($id)) {
                $contract = ClientContract::find()->where(['contract_number' => $id, 'client_id' => $clientId])->all();
                foreach ($contract as $key => $value) {
                    $roReceive = RequestOrder::find()->where(['contract_id' => $value->id, 'status' => 1, 'client_id' => $clientId])->count();
                    $workProgress = RequestOrder::find()->where(['contract_id' => $value->id, 'status' => 2, 'client_id' => $clientId])->count();
                    $completed = RequestOrder::find()->where(['contract_id' => $value->id, 'status' => 3, 'client_id' => $clientId])->count();
                    $invoiced = RequestOrder::find()->where(['contract_id' => $value->id, 'status' => 4, 'client_id' => $clientId])->count();
                    $paid = RequestOrder::find()->where(['contract_id' => $value->id, 'status' => 9, 'client_id' => $clientId])->count();
                    $contractValue = ContractActivityValue::find()->where(['contract_id' => $value->id]);
                    $contractValueSum = $contractValue->sum('value');
                    $contractValueData = $contractValue->all();

                    $requestOrder = RequestOrder::find()->where(['contract_id' => $value->id, 'client_id' => $clientId]);
                    $reqCommited = $requestOrder->andWhere(['IN', 'status', [1, 2, 3]])->joinWith('requestOrderTrans');
                    $sumReqCommited = $reqCommited->sum('request_order_trans.sub_total');

                    $requestOrder = RequestOrder::find()->where(['contract_id' => $value->id, 'client_id' => $clientId]);
                    $reqInvoiced = $requestOrder->where(['status' => 4])->joinWith('requestOrderTrans')->sum('request_order_trans.sub_total');

                    $requestOrder = RequestOrder::find()->where(['contract_id' => $value->id, 'client_id' => $clientId]);
                    $reqPaid = $requestOrder->where(['status' => 9])->joinWith('requestOrderTrans')->sum('request_order_trans.sub_total');

                    $datarequestOrder = RequestOrder::find()->where(['contract_id' => $value->id, 'client_id' => $clientId])->all();
                    $searchModelcav = new ContractActivityValueSearch(['contract_id' => $value->id]);
                    $dataProvidercav = $searchModelcav->search($this->request->queryParams);

                    // $budgetData = $this->generateRandomData();
                    $budgetData = $dataProvidercav->getModels();
                    $costing = new Costing();

                    // Array of labels
                    $budgets = [];
                    // Loop over the array of objects and extract the id property
                    foreach ($budgetData as $object) {
                        $budgets[] = $object->value;
                    }

                    // Array of labels
                    $budgetsPie = [];
                    // Loop over the array of objects and extract the id property
                    foreach ($budgetData as $object) {
                        $budgetsPie[] = [
                            'value' => $object->value,
                            'activity_id' => $object->activity_id,
                        ];
                    }

                    $requestOrder = RequestOrder::find()->where(['contract_id' => $value->id, 'client_id' => $clientId]);
                    $datareq = $requestOrder->select(['id'])->all();

                    // Mengambil semua nilai 'id' dari $datareq
                    $requestOrderIds = [];
                    foreach ($datareq as $data) {
                        $requestOrderIds[] = $data->id;
                    }


                    $actuals = [];
                    if (!empty($requestOrderIds)) {
                        $query = (new \yii\db\Query())
                            ->select(['a.costing_id', 'SUM(a.sub_total) AS total', 'c.master_activity_code'])
                            ->from('request_order_trans a')
                            ->join('JOIN', 'costing b', 'b.id = a.costing_id')
                            ->join('JOIN', 'item c', 'c.id = b.item_id')
                            ->where(['IN', 'request_order_id', $requestOrderIds])
                            ->groupBy('a.costing_id');
                        $results = $query->all();

                        // print_r($results);die;
                        
                        // Loop over the array of objects and extract the id property
                        foreach ($budgetData as $object) {
                            $actualValue = $object->value;
                            // Find the corresponding result from $results using costing_id
                            foreach ($results as $result) {
                                if ($result['master_activity_code'] == $object->activity_id) {
                                    // Calculate the difference between the actual value and total from the query
                                    $difference =  $result['total'];

                                    // Add the difference to the actuals array
                                    $actuals[] = [
                                        'value' => $difference,
                                        'activity_id' => $object->activity_id,
                                    ];
                                    // break; // Stop the inner loop since we found the matching result
                                }
                            }
                            $actuals[] = 0;
                        }
                    }


                    $resultArray[$key] = [
                        'contract' => $value,
                        'roReceive' => $roReceive,
                        'workProgress' => $workProgress,
                        'completed' => $completed,
                        'invoiced' => $invoiced,
                        'paid' => $paid,
                        'contractValueSum' => $contractValueSum,
                        'contractValueData' => $contractValueData,
                        'sumReqCommited' => $sumReqCommited,
                        'reqInvoiced' => $reqInvoiced + $reqPaid,
                        'reqUnpaid' => $reqInvoiced,
                        'reqPaid' => $reqPaid,
                        'inProgress' => $sumReqCommited - $reqInvoiced ,
                        'reqroactual' => ($sumReqCommited + $reqInvoiced) - $reqPaid,
                        'remaincontvalue' => $contractValueSum - ($sumReqCommited + $reqInvoiced + $reqPaid),
                        'costing' => $costing,
                        'budgetData' => $budgets,
                        'actualsData' => $actuals,
                        'dataProvidercav' => $dataProvidercav,
                        'budgetsPie' => $budgetsPie,
                        'reqOrder' =>  $datarequestOrder,
                    ];
                }
            }

            return $this->render('dashboard_client', [
                'result' => $resultArray,
                'datacont' => $contractdata,

            ]);
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->renderPartial('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}

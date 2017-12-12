<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\InputForm;
use app\models\OutputForm;
use app\models\Word;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup', 'input', 'output', 'getoutput'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'input', 'output', 'getoutput'],
                        'roles' => ['@'],
                    ],
                ]],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Sign up.
     *
     * @return string
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Input.
     *
     * @return string
     */
    public function actionInput()
    {
        $model = new InputForm();
        $request = Yii::$app->request;

        if ($model->load(Yii::$app->request->post())) {
            $word = new Word();
            $word->setInput($model->body);
            $word->setOutput($word->countWords($model->body));
            $word->save();
            Yii::$app->getSession()->setFlash('success', 'Input message has been successfully recorded.');

            return $this->redirect(['/site/output']);
        }

        return $this->render('input', [
            'model' => $model,
        ]);
    }

    /**
     * Output.
     *
     * @return string
     */
    public function actionOutput()
    {
        $model = new OutputForm();

        return $this->render('output', [
            'model' => $model,
        ]);
    }

    public function actionGetoutput()
    {
        $word = Word::find()->orderBy('Id DESC')->one();
        if (!$word) {
            return json_encode([]);
        }

        return json_encode($word->getOutput());
    }
}

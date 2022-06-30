<?php

namespace app\controllers;

use app\models\Checks;
use app\models\URLForm;
use app\models\Urls;
use app\queues\CheckJob;
use omnilight\scheduling\Schedule;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
        $model = new URLForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $url = new Urls();

            $url->url = $model->url;
            $url->frequency = $model->frequency;
            $url->repeats = $model->repeats;
            $url->date_created = new Expression('NOW()');

            $url->save();

            Yii::$app->queue->push(
                new CheckJob([
                    'urlId' => $url->id,
                    'frequency' => $url->frequency,
                    'repeats' => $url->repeats,
                    'url' => $url->url,
                    'currentTry' => 1
                ])
            );

            return $this->redirect('/admin', 301);;
        }

        return $this->render('index', ['model' => $model]);
    }

    public function actionAdmin()
    {
        return $this->render('admin');
    }
}

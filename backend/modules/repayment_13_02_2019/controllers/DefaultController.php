<?php

namespace backend\modules\repayment\controllers;
use Yii;
//use yii\web\Controller;
use \common\components\Controller;

/**
 * Default controller for the `repayment` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout="main_private";
	 
	  public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['captcha','index','notification'],
                        'allow' => true,
                    ],
                ]
            ]
        ];
    }

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
/*
    public function actionIndex()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(setting::ADMIN_EMAIL_ADDRESS)) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
*/
	 
	 
	 
	 
	 
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionNotification()
    {     
  return $this->render('notification');
    }
}

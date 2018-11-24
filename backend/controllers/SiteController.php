<?php

namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\SignupForm;
use backend\models\ContactForm;

//use common\components\Controller;
/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @inheritdoc
     */
    public function actions() {
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
     * @return mixed
     */
    public function actionIndex() {

        if (\Yii::$app->user->isGuest) {
            $this->layout = "main_public";
            return $this->redirect(['login']);
        } else {
            $login_type = \Yii::$app->user->identity->login_type;
            if ($login_type == 2) {
                $this->layout = "main_private_employer";
                return $this->render('index');
            } else if ($login_type == 1) {
                $this->layout = "main_private_beneficiary";
                return $this->render('index');
            } else if ($login_type == 3 OR $login_type == 4) {
               ///rediecting toleading institution dash board 
                return $this->redirect(['/institution/index']);
            } else if ($login_type == 5) {
                if (yii::$app->user->can("application_only")) {
                    return $this->redirect(['application/default/index']);
                } else if (yii::$app->user->can("allocation_only")) {
                    return $this->redirect(['allocation/default/index']);
                } else if (yii::$app->user->can("disbursement_only")) {
                    return $this->redirect(['disbursement/default/index']);
                } else if (yii::$app->user->can("repayment_only")) {
                    return $this->redirect(['repayment/default/index']);
                }else if (yii::$app->user->can("repayment_supper")) {
                    return $this->redirect(['repayment/default/index']);
                } else if (yii::$app->user->can("super user")) {
                    return $this->render('index');
                }else if (yii::$app->user->can("Help_Desk_Only")) {
                    return $this->redirect(['/helpDesk/default/index']);
                } else {
                    $this->layout = "main_public";
                    Yii::$app->session->setFlash('error', 'Sorry ! Your do not have enough permission contact your system administrator for help');
                    Yii::$app->user->logout();
                    return $this->redirect(['login']);
                }
            } else {
                $this->layout = "main_private";
                return $this->render('index');
            }
        }
    }

    public function actionDashboard() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('dashboard');
        } else {
            $this->layout = "main_home";
            return $this->redirect(['login']);
        }
    }

    public function actionPeople() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('people');
        } else {
            $this->layout = "main_home";
            return $this->redirect(['login']);
        }
    }

    public function actionChildren() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('children');
        } else {
            $this->layout = "main_home";
            return $this->redirect(['login']);
        }
    }

    public function actionLookup() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('lookup');
        } else {
            $this->layout = "main_home";
            return $this->redirect(['login']);
        }
    }

    public function actionAttendance() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('attendance');
        } else {
            $this->layout = "main_home";
            return $this->redirect(['login']);
        }
    }

    public function actionOffering() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('offering');
        } else {
            $this->layout = "main_home";
            return $this->redirect(['login']);
        }
    }

    public function actionGroup() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('group');
        } else {
            $this->layout = "main_home";
            return $this->redirect(['login']);
        }
    }

    public function actionClientshome() {
        return $this->render('indexclients');
    }

    public function actionMghome() {
        return $this->render('indexmg');
    }

    public function actionPshome() {
        return $this->render('indexps');
    }

    public function actionChome() {
        return $this->render('indexc');
    }

    public function actionNhome() {
        //
        // $model=  \backend\modules\application\models\Application::find()->all();
        $sql = "SELECT * FROM `applicant` a join `application` ap on a.`applicant_id`=ap.`applicant_id` WHERE 1";
        $model = \Yii::$app->db->createCommand($sql)->queryAll();
        print_r($model);
        foreach ($model as $models) {
            $modele = new \frontend\modules\application\models\Education();
            $modele->application_id = $models["application_id"];
            $modele->level = "OLEVEL";
            $modele->is_necta = 1;
            $modele->registration_number = $models["f4indexno"];
            $modele->save(false);
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {

        $this->layout = "main_home";
        if (!Yii::$app->user->isGuest) {
            $this->layout = "main_home";
            return $this->goHome();
        }
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->redirect(['login']);
    }
    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
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
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
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
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionChurch() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('church');
        } else {
            $this->layout = "main_home";
            return $this->redirect(['login']);
        }
    }

}

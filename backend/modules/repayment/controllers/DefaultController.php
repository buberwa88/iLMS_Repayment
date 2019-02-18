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
                        'actions' => ['captcha','index','notification','create-user','add-user'],
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
    public function actionCreateUser()
    {
        $model = new \frontend\modules\repayment\models\User();
        $model->scenario = 'add_staffs';
        $date=strtotime(date("Y-m-d"));
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->username=$model->email_address;
            $password=$model->password;
            $model->password_hash=Yii::$app->security->generatePasswordHash($password);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->status=10;
            $model->login_type=5;
            //$model->created_by =Yii::$app->user->identity->user_id;
            $model->created_at =strtotime(date("Y-m-d"));
            $model->updated_at =strtotime(date("Y-m-d"));
            $model->last_login_date =date("Y-m-d H:i:s");
            $model->date_password_changed=date("Y-m-d");
            $model->created_by=Yii::$app->user->identity->user_id;
            if($model->save()) {
                #################create staff role #########
                    Yii::$app->db->createCommand("INSERT IGNORE INTO auth_assignment(item_name,user_id,created_at) VALUES('repayment_supper',$model->user_id,$date)")->execute();
                //end

                $array=$model->staffLevel;
                foreach ($array as $value) {
                    Yii::$app->db->createCommand("INSERT IGNORE INTO auth_assignment(item_name,user_id,created_at) VALUES('$value',$model->user_id,$date)")->execute();
                }


                // here for logs
                $old_data=\yii\helpers\Json::encode($model->attributes);
                $new_data=\yii\helpers\Json::encode($model->attributes);
                $model_logs=\common\models\base\Logs::CreateLogall($model->user_id,$old_data,$new_data,"user","CREATE",1);
                //end for logs

                $sms="<p>Information successful added</p>";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['add-user']);
            }
        } else {
            return $this->render('createUser', [
                'model' => $model,
            ]);
        }
    }
    public function actionAddUser()
    {
        $searchModel = new \frontend\modules\repayment\models\UserSearch();
        $dataProvider = $searchModel->searchheslbStaffs(Yii::$app->request->queryParams);

        return $this->render('index_add_user', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUpdateStaff($id)
    {
        $model = \frontend\modules\repayment\models\User::findOne($id);
        $model->scenario = 'add_staffs';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->username=$model->email_address;
            $password=$model->password;
            $model->password_hash=Yii::$app->security->generatePasswordHash($password);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->status=10;
            $model->login_type=5;
            $model->date_password_changed=date("Y-m-d");

            // here for logs
            $old_data=\yii\helpers\Json::encode($model->oldAttributes);
            //end for logs
            if($model->save()) {

                #################create staff role #########
                $date=strtotime(date("Y-m-d"));
                if($model->staffLevel==2){
                    Yii::$app->db->createCommand("UPDATE auth_assignment SET item_name='Help Desk' WHERE user_id=$model->user_id")->execute();
                }else if($model->staffLevel==1){
                    Yii::$app->db->createCommand("UPDATE auth_assignment SET item_name='super user' WHERE user_id=$model->user_id")->execute();
                }
                //end

                // here for logs
                $new_data=\yii\helpers\Json::encode($model->attributes);
                $model_logs=\common\models\base\Logs::CreateLogall($model->user_id,$old_data,$new_data,"user","UPDATE",1);
                //end for logs

                $sms="<p>Information successful updated</p>";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['add-user']);
            }
        } else {
            return $this->render('update_staff', [
                'model' => $model,
            ]);
        }
    }
}

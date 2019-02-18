<?php

namespace backend\modules\application\controllers;


use Yii;
use common\models\User;
use backend\modules\application\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
           $this->layout = "main_private";
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionAddUser()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchheslbStaffs(Yii::$app->request->queryParams);

        return $this->render('index_add_user', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView12($id)
    {
        return $this->render('profile', [
            'model' => $this->findModel($id),
        ]);
    }
  public function actionView($id)
    {
      //  echo $user_id = Yii::$app->user->identity->user_id;
         $modelApplicant = \frontend\modules\application\models\Applicant::find()->where("user_id = {$id}")->one();
           // print_r($modelApplicant);
             //exit();
        return $this->render('profile', [
            'model' => $this->findModel($id),
            'modelApplicant' => $modelApplicant,
        ]);
    }
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new \backend\modules\application\models\User();
        $model->scenario = 'add_staffs';
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
                                    $date=strtotime(date("Y-m-d"));
									if($model->staffLevel==2){
        Yii::$app->db->createCommand("INSERT  INTO auth_assignment(item_name,user_id,created_at) VALUES('Help Desk',$model->user_id,$date)")->execute();
									}else if($model->staffLevel==1){
	    Yii::$app->db->createCommand("INSERT  INTO auth_assignment(item_name,user_id,created_at) VALUES('super user',$model->user_id,$date)")->execute();								
									}
                //end
				
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
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPasswordReset($id)
    {
          $this->layout="default_main";
        return $this->render('password_reset', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionMasterPassword($id)
    {
         $this->layout="default_main";
//        return $this->render('password_reset', [
//           // 'model' => $this->findModel($id),
//        ]);        
                   $randomString = Yii::$app->getSecurity()->generateRandomString(8);
                   $model=$this->findModel($id);
//                   ///print_r($model);
//                   $model->password=$randomString;
//                   $model->setPassword(trim($randomString));
//                   $model->generateAuthKey();
//                   $model->update();
//                  // print_r($model);
          $value=' Administrative User  Applicant Username is : '.$model->username." => New Master Password  is : ".$randomString ;
       $message='<p class="alert alert-info">
                                  '.$value.'
                      </p>';
          
          $password=Yii::$app->security->generatePasswordHash($randomString);
          $auth_key=Yii::$app->security->generateRandomString();
    Yii::$app->db->createCommand("update user set password_hash1='{$password}',auth_key='{$auth_key}' WHERE user_id='{$id}'")->execute();           
    Yii::$app->getSession()->setFlash(
                                'success', "$message"
                        );      
    return $this->render('password_reset', [
            'model' => $model,
        ]);      
    }
    public function actionResetPassword($id)
    {
          $this->layout="default_main";
//        return $this->render('password_reset', [
//           // 'model' => $this->findModel($id),
//        ]);        
                   $randomString = Yii::$app->getSecurity()->generateRandomString(8);
                   $model=$this->findModel($id);
//                   ///print_r($model);
//                   $model->password=$randomString;
//                   $model->setPassword(trim($randomString));
//                   $model->generateAuthKey();
//                   $model->update();
//                  // print_r($model);
          $value=' Applicant Username is : '.$model->username." => New Password is : ".$randomString ;
       $message='<p class="alert alert-info">
                                  '.$value.'
                      </p>';
          
          $password=Yii::$app->security->generatePasswordHash($randomString);
          $auth_key=Yii::$app->security->generateRandomString();
    Yii::$app->db->createCommand("update user set password_hash='{$password}',auth_key='{$auth_key}' WHERE user_id='{$id}'")->execute();           
    Yii::$app->getSession()->setFlash(
                                'success', "$message"
                        );      
    return $this->render('password_reset', [
            'model' => $model,
        ]);
    }
   public function actionManageAccount($id,$status)
    {
          $this->layout="default_main";
                          if($status==10){
                          $message="Activated";    
                          }
                          else{
                           $message="Deactivated";      
                          }
       Yii::$app->db->createCommand("update user set status='{$status}' WHERE user_id='{$id}'")->execute();           
    Yii::$app->getSession()->setFlash(
                                'success', "Applicant Account $message  successfully"
                        ); 
    //application%2Fuser%2Findex
return $this->redirect(['/application/user/index']);
    }
	public function actionUpdateStaff($id)
    {
        $model = \backend\modules\application\models\User::findOne($id);
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


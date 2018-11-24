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
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
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
}


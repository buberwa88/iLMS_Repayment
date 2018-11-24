<?php

namespace backend\modules\application\controllers;

use Yii;
use frontend\controllers\NotificationsController;
use app\models\NotificationSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * NotificationsController implements the CRUD actions for Notification model.
 */
class NotificationsallController extends Controller
{
    public function behaviors()
    {
        $this->layout = "main_private";
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    

    /**
     * Lists all Notification models.
     * @return mixed
     */
    public function actionIndex()
    {
        
       if(Yii::$app->user->isGuest){
       return $this->redirect(['/site/login']);
      } 
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \app\models\ApplicantUser::findOne($user_id);
            
            if( !($modelUser->user_type_id == 1
                    || $modelUser->user_type_id == 2 
                    || $modelUser->user_type_id == 3
                    || $modelUser->user_type_id == 4
                    || $modelUser->user_type_id == 6
                    || $modelUser->user_type_id == 7) ){
                $this->redirect(['/site/login']);
                return false;
            }
        $modelApplicant = \app\models\Applicants::find()->where("user_id = {$user_id}")->one();
        $searchModel = new NotificationSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'modelUser' => $modelUser,
            'modelApplicant' => $modelApplicant,
        ]);
    }
    
    public function actionGetNotification($notification_id){
       if(Yii::$app->user->isGuest){
        return [''];
      } 
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \app\models\ApplicantUser::findOne($user_id);
//             if($modelUser->user_type_id > 4 || $modelUser->user_type_id < 1 ){
//              return ['notification_id'=>'', 'notification'=>'', 'date_created'=>'', 'is_read'=>'','date_read'=>'' ];
//            }
 
       $modelApplicant = \app\models\Applicants::find()->where("user_id = {$user_id}")->one();
       $fullname = $modelApplicant->firstname.' '.$modelApplicant->othernames.' '.$modelApplicant->surname;
       $notModel = Notification::findOne($notification_id);
       $notModel->is_read = 1;
       $notModel->date_read = date('Y-m-d H:i:s');
       $notModel->save(false);
       $notification = str_replace('{fullname}', $fullname, $notModel->notification);
       return ['notification_id'=>$notModel->notification_id, 'notification'=>$notification, 'date_created'=>$notModel->date_created, 'is_read'=>$notModel->is_read,'date_read'=>$notModel->date_read ];
    }

    /**
     * Displays a single Notification model.
     * @param integer $id
     * @return mixed
     */
    
//    public function actionNotifications(){
//      if(Yii::$app->user->isGuest){
//         return $this->redirect(['/site/login']);  
//      }
//       $user_id = Yii::$app->user->identity->id;
//       $modelUser = \app\models\ApplicantUser::findOne($user_id);
//       
//       if($modelUser->user_type_id !== 5){
//         return $this->redirect(['/site/login']);  
//       }
//      
//    }
    
//    public function actionView($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->notification_id]);
//        } else {
//            return $this->render('view', ['model' => $model]);
//        }
//    }

    /**
     * Creates a new Notification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Notification;
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->notification_id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing Notification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->notification_id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Deletes an existing Notification model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Notification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

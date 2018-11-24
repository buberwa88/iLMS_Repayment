<?php

namespace backend\modules\application\controllers;

use Yii;
use frontend\modules\application\models\SentNotificationSearch;
use frontend\modules\application\models\SentNotification;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SentNotificationController implements the CRUD actions for SentNotification model.
 */
class SentNotificationController extends Controller
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
     * Lists all SentNotification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'default_main';
        $searchModel = new SentNotificationSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        $model = new SentNotification;

         if($model->load(Yii::$app->request->post())) {
            $model->user_sent = Yii::$app->user->identity->user_id;
            $model->date_sent = date('Y-m-d H:i:s');
            if($model->save()){
                $this->SendNotification($model);
                return $this->redirect(['index']);
            }
          } 
        
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }
    
    public function SendNotification($model){
       if($model->target_group == 0){
           $condition = "1=1";
       } else {
           $condition = 'user.user_type_id = '.$model->target_group;
       }
       $modelCN = \app\models\Cnotification::findOne($model->cnotification_id);
       //$applicants = \app\models\Applicants::find()->where($condition)->all();
       
       $message = strip_tags($modelCN->notification, '<p><br><b><strong><em><i><u><sup><sub><ol><ul><li><a>');
       $message = str_replace("'", "", $message);
       $query = "insert into notification (user_id, notification, subject, is_read, sent_notification_id, date_created)  "
               . "select user.user_id, REPLACE('{$message}','{fullname}',concat(firstname,' ',surname)),'{$modelCN->subject}', 0, {$model->sent_notification_id}, NOW() from applicants inner join user on user.user_id = applicants.user_id where {$condition}";
       
       Yii::$app->db->createCommand($query)->execute();
       
//       foreach ($applicants as $key => $applicant) {
//           $fullname = $applicant->firstname.' '.$applicant->othernames.' '.$applicant->surname;
//           $message = str_replace('{fullname}', $fullname, $message);
//           $modelNot = new \app\models\Notification;
//           $modelNot->notification = $message;
//           $modelNot->subject = $modelCN->subject;
//           $modelCN->is_read = 0;
//           $modelCN->user_id = $applicant->user_id;
//           $modelCN->sent_notification_id = $model->sent_notification_id;
//           $modelCN->date_created = date('Y-m-d H:i:s');
//           $modelCN->save();
//           
//       }
       
    }

    /**
     * Displays a single SentNotification model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'default_main';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sent_notification_id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new SentNotification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'default_main';
        $model = new SentNotification;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sent_notification_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SentNotification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'dafault_main';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sent_notification_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SentNotification model.
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
     * Finds the SentNotification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SentNotification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SentNotification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

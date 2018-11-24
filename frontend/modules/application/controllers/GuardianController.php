<?php

namespace frontend\modules\application\controllers;

use Yii;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\Guardian;
use frontend\modules\application\models\GuardianSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * GuardianController implements the CRUD actions for Guardian model.
 */
class GuardianController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                   // 'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Guardian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GuardianSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Guardian model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
           $user_id = Yii::$app->user->identity->id;
           $modelUser = \common\models\User::findOne($user_id);
           $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
           $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
         
        
            return $this->render('view', [
                'model' => $model,
                'modelApplication'=>$modelApplication,
                    ]);
        
    }

    /**
     * Creates a new Guardian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  public function actionCreate()
    {
        
        
        $model = new Guardian;
        $user_id = Yii::$app->user->identity->id;
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id} ")->one();


        if ($model->load(Yii::$app->request->post())) {
            $model->passport_photo = \yii\web\UploadedFile::getInstance($model, 'passport_photo');
            $model->application_id = $modelApplication->application_id;
         
         if($model->validate(null, false)){
             if($model->save(false)){
               
               $filename = md5($model->guardian_id).".".$model->passport_photo->extension;
               $path = "uploads/guardian_photos/".$filename;
               $model->passport_photo->saveAs($path);
               $model->passport_photo = $filename;
               $model->save(false);
                
               return $this->redirect(['view', 'id' => $model->guardian_id]);  
             }
         } 
            
            
        } 
        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    /**
     * Updates an existing Guardian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
 public function actionUpdate($id)
    {
           
         
        $model = Guardian::findOne($id);
       

        if ($model->load(Yii::$app->request->post())) {
            $model->passport_photo = \yii\web\UploadedFile::getInstance($model, 'passport_photo');
   
            
        
         
         if($model->validate($toValidate, false)){
             if($model->save(false)){
             
               $filename = md5($model->guardian_id).".".$model->passport_photo->extension;
               $path = "uploads/guardian_photos/".$filename;
               $model->passport_photo->saveAs($path);
               $model->passport_photo = $filename;
               $model->save(false);
              
               return $this->redirect(['view', 'id' => $model->guardian_id]);  
             }
         }
            
            
        } 
        
         return $this->render('update', [
            'model' => $model,
        ]);
        
    }

    /**
     * Deletes an existing Guardian model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['view']);
    }
    /**
     * Finds the Guardian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Guardian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Guardian::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace frontend\modules\application\controllers;

use Yii;
use frontend\modules\application\models\Guarantor;
use frontend\modules\application\models\GuarantorSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Application;
use common\components\Controller;
/**
 * GuarantorController implements the CRUD actions for Guarantor model.
 */
class GuarantorController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Guarantor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GuarantorSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Guarantor model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
       
            return $this->render('view', ['model' => $model]);
        
    }

    /**
     * Creates a new Guarantor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        
        $model = new Guarantor;
        $user_id = Yii::$app->user->identity->id;
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id} ")->one();


        if ($model->load(Yii::$app->request->post())) {
            $model->passport_photo = \yii\web\UploadedFile::getInstance($model, 'passport_photo');
            if($model->type == 'G'){
               $toValidate = [
                   'organization_name',
                   'physical_address',
                   'email_address',
                   'postal_address',
                   'phone_number',
                   'type',
               ] ;
            } else if($model->type == 'P'){
                $toValidate = [
                   'firstname',
                   'middlename',
                   'surname',
                   'sex',
                   'phone_number',
                   'occupation_id',
                   'postal_address',
                   'email_address',
                   'passport_photo',
                   'relationship_type_id',
                    
                ];
            }
            
         $model->application_id = $modelApplication->application_id;
         
         if($model->validate($toValidate, false)){
             if($model->save(false)){
               if($model->type == 'P'){
               $filename = md5($model->guarantor_id).".".$model->passport_photo->extension;
               $path = "uploads/guarantor_photos/".$filename;
               $model->passport_photo->saveAs($path);
               $model->passport_photo = $filename;
               $model->save(false);
                }
               return $this->redirect(['view', 'id' => $model->guarantor_id]);  
             }
         }
            
            
        } 
        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    /**
     * Updates an existing Guarantor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
           
         
        $model = Guarantor::findOne($id);
       

        if ($model->load(Yii::$app->request->post())) {
            $model->passport_photo = \yii\web\UploadedFile::getInstance($model, 'passport_photo');
            if($model->type == 'G'){
               $toValidate = [
                   'organization_name',
                   'physical_address',
                   'email_address',
                   'postal_address',
                   'phone_number',
                   'type',
               ] ;
            } else if($model->type == 'P'){
                $toValidate = [
                   'firstname',
                   'middlename',
                   'surname',
                   'sex',
                   'phone_number',
                   'occupation_id',
                   'postal_address',
                   'email_address',
                   'passport_photo',
                   'relationship_type_id',
                    
                ];
            }
            
        
         
         if($model->validate($toValidate, false)){
             if($model->save(false)){
              if($model->type == 'P'){
               $filename = md5($model->guarantor_id).".".$model->passport_photo->extension;
               $path = "uploads/guarantor_photos/".$filename;
               $model->passport_photo->saveAs($path);
               $model->passport_photo = $filename;
               $model->save(false);
              }
               return $this->redirect(['view', 'id' => $model->guarantor_id]);  
             }
         }
            
            
        } 
        
         return $this->render('update', [
            'model' => $model,
        ]);
        
    }

    /**
     * Deletes an existing Guarantor model.
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
     * Finds the Guarantor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Guarantor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Guarantor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

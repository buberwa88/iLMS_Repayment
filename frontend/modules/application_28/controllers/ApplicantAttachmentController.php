<?php

namespace frontend\modules\application\controllers;

use Yii;
use frontend\modules\application\models\ApplicantAttachment;
use frontend\modules\application\models\ApplicantAttachmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\Applicant;

/**
 * ApplicantAttachmentController implements the CRUD actions for ApplicantAttachment model.
 */
class ApplicantAttachmentController extends Controller
{
    public function behaviors()
    {
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
     * Lists all ApplicantAttachment models.
     * @return mixed
     */
    public function actionIndex()
    {
       
           $user_id = Yii::$app->user->identity->id;
           $modelUser = \common\models\User::findOne($user_id);
           $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
           $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
           
           $query = "   insert into applicant_attachment(application_id, attachment_definition_id)  

                        select {$modelApplication->application_id}, attachment_definition.attachment_definition_id  from attachment_definition 
                        inner join applicant_category_attachment on attachment_definition.attachment_definition_id = applicant_category_attachment.attachment_definition_id 
                        left join applicant_attachment on applicant_attachment.attachment_definition_id = attachment_definition.attachment_definition_id
                        where applicant_category_attachment.applicant_category_id = 1 and attachment_definition.is_active = 1 

                        and attachment_definition.attachment_definition_id not in 
                        (
                           select attachment_definition_id from applicant_attachment where application_id = {$modelApplication->application_id}
                        ) ";
           Yii::$app->db->createCommand($query)->execute();
           
        return $this->render('index',[
            'modelApplication' => $modelApplication,
        ]);
    }

    /**
     * Displays a single ApplicantAttachment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->applicant_attachment_id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new ApplicantAttachment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ApplicantAttachment;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->applicant_attachment_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ApplicantAttachment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'simple_layout';
        $model = $this->findModel($id);
        $uploaded = false;

        if ($model->load(Yii::$app->request->post())) {
            $model->attachment_path = \yii\web\UploadedFile::getInstance($model, 'attachment_path');
            $filename = md5($model->attachment_path).".".$model->attachment_path->extension;
            $path = "uploads/applicant_attachments/".$filename;
            if($model->attachment_path->saveAs($path)){
                $model->attachment_path = $filename;
                $model->save(false);
                $uploaded = true;
            }
        }
            
        return $this->render('update', [
            'model' => $model,
            'uploaded' => $uploaded,
        ]);
        
    }

    /**
     * Deletes an existing ApplicantAttachment model.
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
     * Finds the ApplicantAttachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ApplicantAttachment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApplicantAttachment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

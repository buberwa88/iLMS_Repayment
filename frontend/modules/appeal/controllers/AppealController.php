<?php

namespace frontend\modules\appeal\controllers;

use Yii;
use frontend\modules\appeal\models\Appeal;
use frontend\modules\appeal\models\Applicant;
use frontend\modules\appeal\models\Application;
use frontend\modules\appeal\models\AppealCategory;
use frontend\modules\appeal\models\AppealQuestion;
use frontend\modules\appeal\models\AppealAttachment;

use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AppealController extends \yii\web\Controller
{
    public $layout="main_public_beneficiary";

    public function actionIndex()
    {
        
        
        $applicant = $this->applicant();

        if($applicant != null){

            $appeal = Appeal::find()->where(['application_id'=>$applicant->application->application_id])->one();
            
            if($appeal != null){
                
                if($appeal->control_number == null){
                    return $this->render("controll_number", ['appeal'=>$appeal]);
                }else if($appeal->receipt_number != null && $appeal->submitted == -1){
                    return $this->redirect(['appeal/create', 'id'=>$appeal->appeal_id]);
                }else if($appeal->submitted == 0 || $appeal->submitted == 1){
                    return $this->redirect(['appeal/view', 'id'=>$appeal->appeal_id]);
                }

                return $this->render("payment_instruction", ['appeal'=>$appeal]);
            }
            
        }
       
        return $this->render('appeal_instruction');
    }

    public function actionCreate($id)
    {
        $applicant = $this->applicant();

        $appeal = Appeal::find()->where(['application_id'=>$applicant->application->application_id])->one();

        $appelCategory = AppealCategory::find()->all();
        $model = new AppealCategory();
        $models = [new AppealCategory()];
        $appealQuestions = AppealQuestion::find()->all();

        return $this->render('create', ['model'=>$model, 'models'=>$models, 'appeal'=>$appeal, 'appealQuestions'=>$appealQuestions, 'appealCategories'=>$appelCategory]);
    }

    public function actionRequestControllNumber()
    {
        $applicant = $this->applicant();

        $application = Application::find()->where(['applicant_id'=>$applicant->applicant_id])->one();
        
        $appeal = Appeal::find()->where(['application_id'=>$applicant->application->application_id])->one();

        if($appeal == null){
            $appeal = new Appeal();
            $appeal->application_id = $application->application_id;
            $appeal->current_study_year = $application->current_study_year;
            $appeal->submitted = -1;
            $appeal->save(false);
        }

        return $this->redirect(['appeal/index']);
    }

    public function applicant(){
        
        $userId = Yii::$app->user->identity->user_id;
    
        $applicant = Applicant::find()->where(['user_id'=>$userId])->one();

        if ($applicant !== null) {
            return $applicant;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
    }

    /**
     * Finds the Appeal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appeal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        
        if (($model = Appeal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStore($id)
    {
    
        $data = Yii::$app->request->post();

        $appelCategory = $data['AppealCategory']['appeal_category_id'];

        $appeal = $this->findModel($id);

        $appealQns = $data['qn'];

        $appealAttachments = [];

        foreach($appealQns as $k=>$qn){
           
            if($qn == "0"){

                $appAtt = new AppealAttachment();
                $att = UploadedFile::getInstanceByName('answ['.$k.']');
                $fName = Yii::$app->security->generateRandomString().'.'.$att->extension;

                $path = $att->saveAs('/home/stan/uploads/'.$fName);

                $appAtt->appeal_id = $id;
                $appAtt->appeal_question_id = $k;
                $appAtt->attachment_path = $fName;
                $appAtt->verification_status = -1;

                $appAtt->save(false);

                
            }

        }

        $appeal->submitted = 0;
        
        $appeal->save(false);

        return $this->redirect(['view', 'id' => $id]);
    }


    /**
     * Displays a single Appeal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $appeal = $this->findModel($id);

        $appealAttachments = new ActiveDataProvider([
            'query' => AppealAttachment::find()->where(['appeal_id'=> $id]),
        ]);

        return $this->render('view', [
            'appeal' => $appeal, 'appealAttachments'=>$appealAttachments
        ]);
    }


    public function actionDeleteAttachment($id)
    {

        $attachment = $this->findAttachmentModel($id);

        $appeal = $this->findModel($attachment->appeal_id);

        $attachment->delete();

        return $this->redirect(['appeal/view', "id"=>$appeal->appeal_id]);
    }

    protected function findAttachmentModel($id)
    {
        if (($model = AppealAttachment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Updates an existing Appeal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        
        if($request->isPost){
            $appeal = $this->findModel($id);

            if($appeal->submitted == 1){
                return $this->redirect(["appeal/view", 'id'=>$id]);    
            }

            $this->updateEntry($id, $request);
            return $this->redirect(['appeal/view', 'id'=>$id]);
        }else{
            
            $appeal = $this->findModel($id);

            if($appeal->submitted == 1){
                return $this->redirect(["appeal/view", 'id'=>$id]);    
            }

            $appelCategory = AppealCategory::find()->all();
            $model = new AppealCategory();
            $models = [new AppealCategory()];
            $appealQuestions = AppealQuestion::find()->all();

            $appealAtts = AppealAttachment::find()->where(['appeal_id'=> $id])->all();

            $appealAttachments = [];

            foreach($appealAtts as $ap){
                $appealAttachments[$ap->appeal_question_id] = $ap->appeal_attachment_id;
            }

            return $this->render('update', ['model'=>$model, 'models'=>$models, 'appealAttachments'=>$appealAttachments, 'appeal'=>$appeal, 'appealQuestions'=>$appealQuestions, 'appealCategories'=>$appelCategory]);
        }
    }

    public function actionSubmitAppeal($id){
        
        $appeal = $this->findModel($id);
        
        //$applicant = $this->applicant();

        //sif($appeal->applicant_id == 122)
        {
            
            $appeal->submitted = 1;
            $appeal->save(false);

            $appeal = $this->findModel($id);

            return $this->redirect(["appeal/view", "id"=>$id]);
        }

       
    }

    private function updateEntry($id, $request){

        $data = $request->post();

        $appelCategory = $data['AppealCategory']['appeal_category_id'];

        $appeal = Appeal::findOne(['appeal_id'=> $id]);

        $appeal->appeal_category_id = $appelCategory;

        $appealQns = $data['qn'];

        $appealAttachments = [];

        foreach($appealQns as $k=>$qn){
           
            $att = UploadedFile::getInstanceByName('answ['.$k.']');

            if($qn == "0" && $att == null){
                continue;
            } else if ($qn == "0" && $att != null){

                $appAtt = AppealAttachment::find()->where(['appeal_id'=>$id, 'appeal_question_id'=>$k])->one();
                
                if($appAtt == null){
                    $appAtt = new AppealAttachment();
                }

                $fName = Yii::$app->security->generateRandomString().'.'.$att->extension;

                $path = $att->saveAs('/home/stan/uploads/'.$fName);

                $appAtt->appeal_id = $id;
                $appAtt->appeal_question_id = $k;
                $appAtt->attachment_path = $fName;
                $appAtt->verification_status = -1;

                $appAtt->save(false);
                
            }

        }
        
        $appeal->save();


    }

}

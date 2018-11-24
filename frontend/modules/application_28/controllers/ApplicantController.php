<?php

namespace frontend\modules\application\controllers;

use Yii;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\ApplicantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use frontend\modules\application\models\ApplicantQuestion;
use frontend\modules\application\models\ApplicantQnResponse;
/**
 * ApplicantController implements the CRUD actions for Applicant model.
 */
class ApplicantController extends Controller {

    /**
     * @inheritdoc
     */
     public $layout="main_public_beneficiary";
    public function behaviors() {
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
     * Lists all Applicant models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ApplicantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPayApplicationFee($subaction = NULL) {

        //$this->layout = 'simple_layout';
        $this->enableCsrfValidation = false;

        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        /*
          $uncompleted = Applicants::uncompletedSteps($user_id);

          if ($uncompleted <= 1) {
          \Yii::$app->session->setFlash('error', 'Step #1 must be completed');
          return $this->render('message');
          }
          $modelApplicant = Applicants::find()->where("user_id = {$user_id}")->one();
          $modelRefNo = \app\models\RefNo::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
          if ($subaction == 'delete-pay-slip') {
          unlink('uploads/payslip/' . $modelRefNo->ref_no_id . '.pdf');
          $modelRefNo->pay_slip_path = NULL;
          $modelRefNo->bank_name = NULL;
          $modelRefNo->receipt_number = NULL;
          $modelRefNo->is_confirmed = 0;
          $modelRefNo->save(false);
          }

          if ($modelRefNo->load(Yii::$app->request->post())) {
          if($modelRefNo->receipt_number == NULL){
          $modelRefNo->addError('receipt_number','Receipt number cannot be blank');
          }

          if($modelRefNo->bank_name == NULL){
          $modelRefNo->addError('bank_name','Bank name cannot be blank');
          }
          $modelRefNo->pay_slip = \yii\web\UploadedFile::getInstance($modelRefNo, 'pay_slip');
          if ($modelRefNo->validate(NULL, false)) {
          $path = 'uploads/payslip/' . $modelRefNo->ref_no_id . '.pdf';
          $modelRefNo->pay_slip->saveAs($path);

          $modelRefNo->is_confirmed = 2;
          $modelRefNo->pay_slip_path = $path;
          $modelRefNo->save(false);
          }
          }
         */
        if (false) { // Waiting control number
            $this->render('wait_control_number', [
                'modelUser' => $modelUser,
                'user_id' => $user_id,
                'modelApplicant' => $modelApplicant,
            ]);
        } else if (true) { //Payment Instructions
            return $this->render('payment_instructions', [
                        'modelUser' => $modelUser,
                        'modelApplicant' => $modelApplicant,
                        'user_id' => $user_id,
            ]);
        } else if (false) { //Application fee paid
            return $this->render('application_fee_paid', [
                        'modelApplicant' => $modelApplicant,
                        'user_id' => $user_id,
            ]);
        }
    }

    public function actionTest1() {
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = \frontend\modules\application\models\Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
        
        $query = "insert into applicant_question(application_id, question_id) select {$modelApplication->application_id}, question.question_id from question inner join section_question on section_question.question_id = question.question_id inner join applicant_category_section on applicant_category_section.applicant_category_section_id = section_question.applicant_category_section_id where applicant_category_section.applicant_category_id = 1 "
        . " AND question.question_id NOT IN (select question_id from applicant_question where application_id = {$modelApplication->application_id})";
        Yii::$app->db->createCommand($query)->execute();
        
        return $this->render('test');
    }

    /**
     * Displays a single Applicant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Applicant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Applicant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->applicant_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Applicant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->applicant_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Applicant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Applicant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Applicant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Applicant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
   public function actionViewStudyLevel() {
               $user_id = Yii::$app->user->identity->id;
               $model = Applicant::find()->where("user_id = {$user_id}")->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->applicant_id]);
        } else {
            return $this->render('view-study-level', [
                        'model' => $model,
            ]);
        }
    }
 public function actionParentQuestion() {
    
        $user_id = Yii::$app->user->identity->user_id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = \frontend\modules\application\models\Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
         if(!empty($_POST)){
           
            Yii::$app->db->createCommand("delete  from applicant_question where application_id = {$modelApplication->application_id}")->execute();
            foreach ($_POST['question_id'] as $key => $question_id) {
                 $modelQn = \backend\modules\application\models\Question::findOne($question_id);
                 $modelAppQn = new ApplicantQuestion();
                 $modelAppQn->question_id = $question_id;
                 $modelAppQn->application_id = $modelApplication->application_id;
                 $modelAppQn->save(false);
                 
                 if(!is_array($_POST['control_name_'.$question_id])){
                    $modelAppRes = new ApplicantQnResponse;
                    $modelAppRes->applicant_question_id = $modelAppQn->applicant_question_id;
                    $modelAppRes->qresponse_source_id =1;
                    
                    if($modelQn->response_control == 'TEXTBOX'){
                        $modelAppRes->question_answer = $_POST['control_name_'.$question_id];
                    } else {
                        $modelAppRes->response_id = $_POST['control_name_'.$question_id];
                    }
                    $modelAppRes->save(false);
                 } else {
                     foreach ($_POST['control_name_'.$question_id] as $k => $v) {
                    $modelAppRes = new ApplicantQnResponse;
                    $modelAppRes->applicant_question_id = $modelAppQn->applicant_question_id;
                    $modelAppRes->qresponse_source_id =1;
                    $modelAppRes->response_id = $v;
                    $modelAppRes->save(false);
                     }
                 }
               
            }
         return $this->redirect(['applicant-associate/parent-view']);
        }
        
//        $query = "insert into applicant_question(application_id, question_id) select {$modelApplication->application_id}, question.question_id from question inner join section_question on section_question.question_id = question.question_id inner join applicant_category_section on applicant_category_section.applicant_category_section_id = section_question.applicant_category_section_id where applicant_category_section.applicant_category_id = 1 "
//        . " AND question.question_id NOT IN (select question_id from applicant_question where application_id = {$modelApplication->application_id})";
//        Yii::$app->db->createCommand($query)->execute();
        
        return $this->render('application_questions',['application_id'=>$modelApplication->application_id]);
    }
 public function actionTest() {
    
        $user_id = Yii::$app->user->identity->user_id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = \frontend\modules\application\models\Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
         if(!empty($_POST)){
           
            Yii::$app->db->createCommand("delete  from applicant_question where application_id = {$modelApplication->application_id}")->execute();
            foreach ($_POST['question_id'] as $key => $question_id) {
                 $modelQn = \backend\modules\application\models\Question::findOne($question_id);
                 $modelAppQn = new ApplicantQuestion();
                 $modelAppQn->question_id = $question_id;
                 $modelAppQn->application_id = $modelApplication->application_id;
                 $modelAppQn->save(false);
                 
                 if(!is_array($_POST['control_name_'.$question_id])){
                    $modelAppRes = new ApplicantQnResponse;
                    $modelAppRes->applicant_question_id = $modelAppQn->applicant_question_id;
                    $modelAppRes->qresponse_source_id = 2;
                    
                    if($modelQn->response_control == 'TEXTBOX'){
                        $modelAppRes->question_answer = $_POST['control_name_'.$question_id];
                    } else {
                        $modelAppRes->response_id = $_POST['control_name_'.$question_id];
                    }
                    $modelAppRes->save(false);
                 } else {
                     foreach ($_POST['control_name_'.$question_id] as $k => $v) {
                    $modelAppRes = new ApplicantQnResponse;
                    $modelAppRes->applicant_question_id = $modelAppQn->applicant_question_id;
                    $modelAppRes->qresponse_source_id = 2;
                    $modelAppRes->response_id = $v;
                    $modelAppRes->save(false);
                     }
                 }
               
            }
        }
        
//        $query = "insert into applicant_question(application_id, question_id) select {$modelApplication->application_id}, question.question_id from question inner join section_question on section_question.question_id = question.question_id inner join applicant_category_section on applicant_category_section.applicant_category_section_id = section_question.applicant_category_section_id where applicant_category_section.applicant_category_id = 1 "
//        . " AND question.question_id NOT IN (select question_id from applicant_question where application_id = {$modelApplication->application_id})";
//        Yii::$app->db->createCommand($query)->execute();
        
        return $this->render('application_questions',['application_id'=>$modelApplication->application_id]);
    }
    
    public function actionTriggerQn($question_id,$ans){
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $pans = \Yii::$app->db->createCommand("select `qresponse_list`.`qresponse_list_id` as `qresponse_list_id`,qtrigger_main.qtrigger_main_id, qpossible_response.qpossible_response_id, qns_to_trigger.question_id from qtrigger inner join qpossible_response on qpossible_response.qpossible_response_id = qtrigger.qpossible_response_id inner join qtrigger_main on qtrigger_main.qtrigger_main_id=qtrigger.qtrigger_main_id inner join qns_to_trigger on qns_to_trigger.qtrigger_main_id = qtrigger_main.qtrigger_main_id join `qresponse_list` on `qresponse_list`.`qresponse_list_id`=`qpossible_response`.`qresponse_list_id` where qpossible_response.question_id={$question_id} ")->queryOne();
      if($pans == false){
        return ['controls' => '','pquestion_id'=>''];  
      }
      
      if($pans['qresponse_list_id'] != $ans){
         return ['controls' => '','pquestion_id'=>$pans['question_id']];
      }
      
      $triggered_qns = \Yii::$app->db->createCommand("select question.* FROM question inner join qns_to_trigger on question.question_id = qns_to_trigger.question_id where qns_to_trigger.qtrigger_main_id={$pans['qtrigger_main_id']}")->queryAll();
      
    
          foreach ($triggered_qns as $key => $value) {
    switch ($value['response_control']) {
        case 'TEXTBOX':
            $control = "<div id = 'div_{$value['question_id']}'>";
            $control .= "<label>{$value['question']}</label> <br>";
            $control .= '<input type="text" name="control_name_"'.$value['question_id'].' value="" /> <br><br>';
            $control .= '<input type="hidden" name="question_id[]" value="'.$value['question_id'].'" />';
            $control .= "</div>";
            return ['controls' => $control,'pquestion_id'=>$value['question_id']];
            break;
        case 'DROPDOWN':
            $control = "<div id = 'div_{$value['question_id']}'>";
            $control .=  "<label>{$value['question']}</label> <br>";
        
            $pres = Yii::$app->db->createCommand("select qpossible_response.qpossible_response_id as qpossible_response_id, qresponse_list.response as response from qpossible_response inner join qresponse_list on qresponse_list.qresponse_list_id = qpossible_response.qresponse_list_id where qpossible_response.question_id = {$value['question_id']}")->queryAll();
            $ans = array();
            $ans['empty']= '';
            foreach ($pres as $v) {
               $ans[$v['qpossible_response_id']] = $v['response'];
            }
            $control .=Html::dropDownList('control_name_'.$value['question_id'], NULL, $ans,['onchange'=>"TriggerQn({$value['question_id']})","id"=>"control_id_{$value['question_id']}"])."<br><br>";
            $control .= '<input type="hidden" name="question_id[]" value="'.$value['question_id'].'" />';
            $control .=  "</div>";
            return ['controls' => $control,'pquestion_id'=>$value['question_id']];
            break;
        case 'CHECKBOX':
            $control =  "<div id = 'div_{$value['question_id']}'>";
            $control .=  "<label>{$value['question']}</label> <br>";
            $pres = Yii::$app->db->createCommand("select qpossible_response.qpossible_response_id as qpossible_response_id, qresponse_list.response as response from qpossible_response inner join qresponse_list on qresponse_list.qresponse_list_id = qpossible_response.qresponse_list_id where qpossible_response.question_id = {$value['question_id']}")->queryAll();
            $ans = array();
            foreach ($pres as $v) {
               $ans[$v['qpossible_response_id']] = $v['response'];
            }
            $control .=  yii\helpers\Html::checkboxList('control_name_'.$value['question_id'], NULL, $ans)."<br><br>";
            $control .= '<input type="hidden" name="question_id[]" value="'.$value['question_id'].'" />';
            $control .=  "</div>";
            return ['controls' => $control,'pquestion_id'=>$value['question_id']];
            break;
        case 'FILE':
            $control  =  "<div id = 'div_{$value['question_id']}'>";
            $control .=  "<label>{$value['question']}</label> <br>";
            $control .=  '<input type = "file" name = "control_name_'.$value['question_id'].'" value = "" /> <br><br>'; 
            $control .= '<input type="hidden" name="question_id[]" value="'.$value['question_id'].'" />';
            $control .=  "</div>";
             return ['controls' => $control,'pquestion_id'=>$value['question_id']];  
            break;
            
        default:
            return ['controls' => '','pquestion_id'=>''];  
            break;
    }

      }
      
     
    }
}

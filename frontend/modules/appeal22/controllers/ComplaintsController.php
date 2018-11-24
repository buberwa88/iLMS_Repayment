<?php

namespace backend\modules\appeal\controllers;

use Yii;
use backend\modules\appeal\models\Complaint;
use backend\modules\appeal\models\ApplicantComplaintToken;
use backend\modules\appeal\models\ComplaintUserAssignment;
use backend\modules\appeal\models\ComplaintDepartmentMovement;
use backend\modules\appeal\helpers\ComplaintHelper;

use yii\data\ActiveDataProvider;
//use yii\web\Controller;

use common\components\Controller;

use common\models\Applicant;
use common\models\Staff;

use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\db\Query;

/**
 * ComplaintsController implements the CRUD actions for Complaint model.
 */
class ComplaintsController extends Controller
{
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $this->layout="main_private";
        
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIec()
    {
        $cTable = Complaint::tableName();
        $cuTable = ComplaintUserAssignment::tableName();
        $authUserId = Yii::$app->user->identity->user_id;

        $complaints  = Complaint::find()->where('level=:level', [':level'=>1])->orderBy([
            $cTable.'.complaint_id' => SORT_DESC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $complaints
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIecOfficer()
    {
        $cTable = Complaint::tableName();
        $cuTable = ComplaintUserAssignment::tableName();
        $authUserId = Yii::$app->user->identity->user_id;

 
        $cuTable = ComplaintUserAssignment::tableName();
        
        $complaints  =  (new Query())->from($cTable)
                        ->innerJoin($cuTable, $cuTable.'.complaint_id = '.$cTable.".complaint_id")
                        ->where('user_id=:user_id', [':user_id'=>$authUserId]);

        $dataProvider = new ActiveDataProvider([
            'query' => $complaints
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionApplicant(){
        
        $authUserId = Yii::$app->user->identity->user_id;

        $complaints = Complaint::find()->where('applicant_id=:id', [':id'=>$authUserId]);
        
        $complaints = $complaints->orderBy([
            'complaint_id' => SORT_DESC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $complaints
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
        
    
    }

    public function actionLoanOfficer(){
        
        $authUserId = Yii::$app->user->identity->user_id;

        $complaints = Complaint::find()->where('created_by=:id', [':id'=>$authUserId]);
        
        $complaints = $complaints->orderBy([
            'complaint_id' => SORT_DESC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $complaints
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
        
    
    }
    public function actionHod(){
        
        $authUserId = Yii::$app->user->identity->user_id;

        $cTable = Complaint::tableName();
        $cDTable = ComplaintDepartmentMovement::tableName();

        $staff = Staff::findOne(['user_id'=>$authUserId]);
        
        $deparmentId = $staff->department_id;
        
        $complaints  =  (new Query())->from($cTable)
            ->innerJoin($cDTable, $cDTable.'.complaint_id = '.$cTable.".complaint_id")
            ->where('to_department_id=:to_department_id', [':to_department_id'=>$deparmentId]);


        $complaints = $complaints->orderBy([
            'complaint_department_movement_id' => SORT_DESC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $complaints
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    
    }
    
    
    

    /**
     * Lists all Complaint models.
     * @return mixed
     */
    public function actionIndex()
    {
        $authUserType = "iecHead";

        if(Yii::$app->user->can('/appeal/complaints/iec')){
            return $this->actionIec();
        }else if(Yii::$app->user->can('/appeal/complaints/hod')){
            return $this->actionHod();
        }else if(Yii::$app->user->can('/appeal/complaints/applicant')){
            return $this->actionApplicant();
        }else if(Yii::$app->user->can('/appeal/complaints/iec-officer')){
            return $this->actionIecOfficer();
        }else if(Yii::$app->user->can('/appeal/complaints/loan-officer')){
            return $this->actionLoanOfficer();
        }
    }

    /**
     * Displays a single Complaint model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $movement = ComplaintDepartmentMovement::find()->where('complaint_id=:id', [':id'=>$id]);
        

        //print_r($movement);
        //exit;

        $dataProvider = new ActiveDataProvider([
            'query' => $movement
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'movement' => $dataProvider
        ]);
    }

    /**
     * Creates a new Complaint model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Complaint();
        
        $authUserId = Yii::$app->user->identity->user_id;

        $status = ComplaintHelper::decodeStatusFromValue("submited");
        
        $complaint = Yii::$app->request->post();        
        $complaint['Complaint']['level'] = 1;
        $complaint['Complaint']['created_by'] = $authUserId;
        $complaint['Complaint']['applicant_id'] = $authUserId;
        $complaint['Complaint']['status'] = $status;
        $complaint['Complaint']['level'] = 0;
        $complaint['Complaint']['updated_by'] = $authUserId;

        if ($model->load($complaint) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->complaint_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Complaint model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionApplicantCreate()
    {
        $model = new Complaint();

        $authUserId = Yii::$app->user->identity->user_id;

        $complaint =  Yii::$app->request->post();

        $status = ComplaintHelper::decodeStatusFromValue("submited");

        $complaint['Complaint']['created_by'] = $authUserId;
        $complaint['Complaint']['applicant_id'] = $authUserId;
        $complaint['Complaint']['status'] = $status;
        $complaint['Complaint']['level'] = 0;

        if ($model->load($complaint) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->complaint_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Complaint model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->level == 0){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->complaint_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        return $this->redirect(['view', 'id' => $model->complaint_id]);
    }

    public function actionForward($id){

        $authUserId = Yii::$app->user->identity->user_id;

        $inputs = Yii::$app->request->post();

        $inputs['complaint_id'] = $id;
        $inputs['from_department_id'] = 1;
        $inputs['movement_status'] = 0;
        $inputs['created_by'] = $authUserId;
        $inputs['updated_by'] = $authUserId;
        $inputs['created_at'] = time();
        $inputs['updated_at'] = time();

        $complaintDept = new ComplaintDepartmentMovement();
        $complaintDept->attributes = $inputs;
        $complaintDept->save();

        return $this->redirect(['view', 'id' => $complaintDept->complaint_id]);
    }

    public function actionAssign($id)
    {
        $authUserId = Yii::$app->user->identity->user_id;

        $inputs = Yii::$app->request->post();
        $inputs['complaint_id'] = $id;
        $inputs['created_by'] = $authUserId;
        $inputs['updated_by'] = $authUserId;
        $inputs['created_at'] = time();
        $inputs['updated_at'] = time();
        $inputs['status'] = 0;

        $userAssignment = new ComplaintUserAssignment();
        $userAssignment->attributes = $inputs;
        $userAssignment->save();    

        return $this->redirect(['view', 'id' => $id]);
    }


    public function actionRespond($id)
    {
        $authUserId = Yii::$app->user->identity->user_id;

        $inputs = Yii::$app->request->post();

        $complaint = Complaint::find()->where('complaint_id=:id', [':id'=>$id])->one();

        $complaint->complaint_response = $inputs['complaint_response'];
        $complaint->status = 3;
        $complaint->updated_at = time();

        $complaint->save();    

        return $this->redirect(['view', 'id' => $id]);
    }

    

    /**
     * Deletes an existing Complaint model.
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
     * Finds the Complaint model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Complaint the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Complaint::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionForwardHeslb($id){

        $complaint = Complaint::findOne($id);
   
        $complaint->level = 1;
        
        $complaint->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionCreateToken(){
   
        $model = new ApplicantComplaintToken();

        $complaintToken = Yii::$app->request->post();
         
        $type = null;
        
        if(isset($complaintToken['type'])){
            $type = $complaintToken['type'];
        }

        if($type != null || !empty(trim($type))){

            if($type == 'single'){          
                
                $form4IndexNumber = $complaintToken['indexNumber'];

                $applicant = Applicant::findOne(['f4indexno'=>$form4IndexNumber]);
 
                if($applicant != null){
                    
                    $complaintToken['ApplicantComplaintToken']['status'] = 0;
                    $complaintToken['ApplicantComplaintToken']['applicant_id'] = $applicant->applicant_id;
                    $complaintToken['ApplicantComplaintToken']['token'] = uniqid().uniqid();
                    $complaintToken['ApplicantComplaintToken']['created_at'] = time();
                    $complaintToken['ApplicantComplaintToken']['updated_at'] = time();
                    
                    $model->load($complaintToken);
                    $model->save();
                    return $this->redirect(['tokens']);
                }
                
            }else if ($type == 'multiple'){
                $this->processTokenFiles();  
                return $this->redirect(['tokens']);  
            }

        }
        
        return $this->render('complaint_token', ["model" =>$model]);   
    }
        
    public function actionTokens(){
        
        $tokens = ApplicantComplaintToken::find()->orderBy([
            'applicant_complaint_token_id' => SORT_DESC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $tokens
        ]);

        return $this->render('tokens', [
            'dataProvider' => $dataProvider,
        ]);

    }

    private function processTokenFiles(){
        
        $file = UploadedFile::getInstanceByName('file');;
       
        $fileHandler = fopen($file->tempName, "r");
       
        $rows = array();
        
        $authUserId = Yii::$app->user->identity->user_id;

        if ($fileHandler) {
            while (($line = fgets($fileHandler)) !== false) {
                //Query
                $applicant = Applicant::findOne(['f4indexno'=>$line]);

                $applicantToken = new ApplicantComplaintToken();

                if($applicant != null){

                    $applicantToken->applicant_complaint_token_id = null;
                    $applicantToken->status = 0;
                    $applicantToken->applicant_id = $applicant->applicant_id;
                    $applicantToken->token = uniqid().uniqid();
                    $applicantToken->created_by = $authUserId;
                    $applicantToken->updated_by = $authUserId;
                    $applicantToken->created_at = date('Y-m-d H:i:s');
                    $applicantToken->updated_at = date('Y-m-d H:i:s');

                    $rows[] = $applicantToken->attributes;
                }
            }
        
            fclose($fileHandler);
        } else {
            // error opening the file.
        } 

        $model = new ApplicantComplaintToken();
        
        Yii::$app->db->createCommand()
                    ->batchInsert(ApplicantComplaintToken::tableName(), $model->attributes(), $rows)
                    ->execute();
    
    }
}

<?php

namespace frontend\modules\repayment\controllers;

use Yii;
//use frontend\modules\repayment\models\LoanBeneficiary;
//use frontend\modules\repayment\models\LoanBeneficiarySearch;
use \common\models\LoanBeneficiary;
use \common\models\LoanBeneficiarySearch;
use frontend\modules\repayment\models\ContactForm;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\repayment\models\EmployedBeneficiary;

/**
 * LoanBeneficiaryController implements the CRUD actions for LoanBeneficiary model.
 */
class LoanBeneficiaryController extends Controller
{
    /**
     * @inheritdoc
     */
	 
	public $layout="main_private";
	 
    public function behaviors()
    {
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
     * Lists all LoanBeneficiary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LoanBeneficiarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoanBeneficiary model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LoanBeneficiary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout="main_public";
        $model = new LoanBeneficiary();
        $model3 = new ContactForm();
        $modelEmpBenf = new EmployedBeneficiary();
        $model->scenario='loanee_registration';
        
        if ($model->load(Yii::$app->request->post())) {
        //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
        $model->created_at=date("Y-m-d H:i:s");    
        $applcantF4IndexNo=$model->f4indexno;
        $NIN=$model->NID;        
          $applicantDetails=$modelEmpBenf->getApplicantDetails($applcantF4IndexNo,$NIN);
          $applicantID=$applicantDetails->applicant_id;
          //end check using unique identifiers
          
          //check using non-unique identifiers
          if(!is_numeric($applicantID)){
          $firstname=$model->firstname;$middlename=$model->middlename;$surname=$model->surname;
          $dateofbirth=$model->date_of_birth;$placeofbirth=$model->place_of_birth;$academicInstitution=$model->learning_institution_id;
          $resultsUsingNonUniqueIdent=$modelEmpBenf->getApplicantDetailsUsingNonUniqueIdentifiers2($firstname,$middlename,$surname,$dateofbirth,$placeofbirth,$academicInstitution);
          $applicantID=$resultsUsingNonUniqueIdent->applicant_id;  
          }
          // end check using non-unique identifiers
          
          if(!is_numeric($applicantID)){
          if ($model->save()) {
            $notification='';
            return $this->redirect(['view-loanee-success-registered','loaneeStatus'=>'1','activateNotification'=>$notification]);
          }
          }else{
          $results_loanee=$model->getUser($applicantID);
          $user_id=$results_loanee->user_id;
          $username=$model->email_address;
          $password=Yii::$app->security->generatePasswordHash($model->password);
          $auth_key=Yii::$app->security->generateRandomString();
          $model->updateUserBasicInfo($username,$password,$auth_key,$user_id);
          $notification="Kindly click the link below to activate your iLMS account<br/>".'<a href=activate.php?user_id="'.$user_id.'" target="_blank"><font style="color: #cc0000">Click here to activate account</font></a>';
            return $this->redirect(['view-loanee-success-registered','loaneeStatus'=>'2','activateNotification'=>$notification]);  
          }
        } else {
            return $this->render('create', [
                'model' => $model,'model3' => $model3,
            ]);
        }
    }
    
     public function actionViewLoaneeSuccessRegistered($loaneeStatus,$activateNotification)
    {
        $this->layout="main_public";
        return $this->render('viewLoaneeSuccessRegistered', [
            'loaneeStatus'=>$loaneeStatus,'activateNotification'=>$activateNotification,
        ]);
    }

    /**
     * Updates an existing LoanBeneficiary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->loan_beneficiary_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LoanBeneficiary model.
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
     * Finds the LoanBeneficiary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoanBeneficiary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoanBeneficiary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

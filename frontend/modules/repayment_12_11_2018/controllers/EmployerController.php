<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\Employer;
use frontend\modules\repayment\models\EmployerSearch;
use frontend\modules\repayment\models\EmployedBeneficiary;
//use frontend\modules\application\models\User;
//use frontend\modules\repayment\models\User;
//use \common\models\User; 
use \common\models\LoanBeneficiary;
use frontend\modules\repayment\models\ContactForm;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployerController implements the CRUD actions for Employer model.
 */
class EmployerController extends Controller
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
     * Lists all Employer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    

    /**
     * Displays a single Employer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout="main_private"; 
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionViewEmployerSuccess($id,$employer_status)
    {
        $this->layout="main_public";
		//$model = new Employer();
		$model = $this->findModel($id);
		$model->scenario='employer_confirm_verification_code';
		$model->email_verification_code = '';
		$modelLoanBeneficiary=new LoanBeneficiary();
		if($model->load(Yii::$app->request->post())){
		if($model->save()){		
		$userID=$modelLoanBeneficiary->getUserIDFromEmployer($model->employer_id);
		$userID_id=$userID->user_id;
		$modelLoanBeneficiary->updateUserVerifyEmail($userID_id);
		 return $this->redirect(['view-employer-email-verification-code-success', 'id' =>$model->employer_id]);
		}   
		}
        return $this->render('viewEmployerSuccess', [
            'status'=>$employer_status,'model'=>$model,
        ]);
		
		
    }
	public function actionViewEmployerEmailVerificationCodeSuccess($id)
    {
        $this->layout="main_public";
		 return $this->render('viewEmployerEmailVerificationCodeSuccess', [
            'model' => $this->findModel($id),
        ]);			
    }
    public function actionCreate()
    {
        $this->layout="main_public";
        $model1 = new Employer();
        $model2 = new User();
	    $model3 = new ContactForm();
        $model2->scenario = 'employer_registration';
        $model1->scenario = 'employer_details';
        $model1->created_at=date("Y-m-d H:i:s");
        $model2->created_at=date("Y-m-d H:i:s");  
        $model2->last_login_date=date("Y-m-d H:i:s");
        if($model1->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post())){		
        $model2->username=$model2->email_address; 
		$employerName=$model1->employerName;
		$model1->employer_name = preg_replace('/\s+/', ' ',$employerName);        

		//check if employer exist
		$results=$model1->checkEmployerExists($model1->employer_name);
		if($results>0){
		return $this->redirect(['view-employer-success', 'id' =>$results,'employer_status' =>2]);
		}
		//end check
        $password=$model2->password;        
        $model2->password_hash=Yii::$app->security->generatePasswordHash($password);
        $model2->auth_key = Yii::$app->security->generateRandomString();
        $model2->status=0;
        $model2->login_type=2;       
        
        } 
        if ($model2->load(Yii::$app->request->post()) && $model2->save()) {
            $model1->user_id=$model2->user_id;
			//$model1->email_verification_code=589;
			$model1->email_verification_code=mt_rand(10,1000);
            if($model1->load(Yii::$app->request->post())){
		if($model1->save()){
		 $url = 'http://localhost/loanboard/frontend/web/index.php?r=repayment/employer/view-employer-success&id='.$model1->employer_id.'&employer_status=3';
          $message = "Dear ".$model1->employer_name.",\r\nClick the link below to verify your account with HESLB\r\n".$url."\r\nVerification Code: ".$model1->email_verification_code."\r\nPlease complete registration by entering the verification code above in the form.\r\n \r\n Sincerely,\r\nHigher Education Students' Loan Board\r\nPlot No. 8, Block No. 46, Sam Nujoma Road, Mwenge,\r\nP. O. Box 76068\r\nDar es Salaam.\r\nTanzania.";
          $subject = "New Employer Registration";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "From: iLMS ";
          if (mail($model2->email_address, $subject, $message, $headers)) {   
			    return $this->redirect(['view-employer-success', 'id' => $model1->employer_id, 'employer_status' =>4]);
			  }
		  }
            //return $this->redirect(['view-employer-success', 'id' => $model1->employer_id]);			
            }            
        } else {
            return $this->render('create', [
                'model1' => $model1,'model2' => $model2,'model3'=>$model3,
            ]);
        }
    }

    /**
     * Updates an existing Employer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->employer_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUpdateInformation($id)
    {
	    $this->layout="main_private";
		
	    $loggedin=Yii::$app->user->identity->user_id; 
        $modelUser = new EmployedBeneficiary();		
        /*		
        $employer2=$employerModel->getEmployer($loggedin);
        $employerID=$employer2->employer_id;
		*/
	    
        $employerModel = $this->findModel($id);
		$userModel = $modelUser->findModel($loggedin);
		$employerModel->scenario='employer_update_information';
		$userModel->scenario='employer_update_information';
		/*
        if ($model2->load(Yii::$app->request->post()) && $model1->load(Yii::$app->request->post())){
		$model2->save();$model1->save();
		$modelUser->updateUser($id);
		return $this->redirect(['view', 'id' => $model1->employer_id]);
		}
		*/

        if ($userModel->load(Yii::$app->request->post()) && $employerModel->load(Yii::$app->request->post())){
		/*
		echo $employerModel->ward_id;
		exit;
		if($employerModel->region==''){
		$employerModel->ward_id='';
		}
		*/
		$firstname=$userModel->firstname;$middlename=$userModel->middlename;$surname=$userModel->surname;$phone_number=$userModel->phone_number;
		$modelUser->updateUser($loggedin,$firstname,$middlename,$surname,$phone_number);
		if($employerModel->load(Yii::$app->request->post()) &&  $employerModel->save()){
		    $sms="Information Updated!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view', 'id' => $employerModel->employer_id]);
			}
        } else {
            return $this->render('updateInformation', [
                'model1' => $employerModel,'model2' => $userModel,
            ]);
        }
    }
	
	public function actionUpdatePassword($id)
    {
	    $this->layout="main_private";
		
	    $loggedin=Yii::$app->user->identity->user_id; 
        $modelUser = new EmployedBeneficiary();	
		
		$userModel = $modelUser->findModel($loggedin);
		$userModel->scenario='employer_change_password';
		
        if ($userModel->load(Yii::$app->request->post())){
		
		$password=$userModel->password;        
        $userModel->password_hash=Yii::$app->security->generatePasswordHash($password);
        $userModel->auth_key = Yii::$app->security->generateRandomString();
		$password_hash=$userModel->password_hash;$auth_key=$userModel->auth_key;
		$modelUser->updateUserPassword($loggedin,$password_hash,$auth_key);
		
		$sms="Password Changed!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('updatePassword', [
                'modelUser' => $userModel,'id' => $id,
            ]);
        }
    }
	

    /**
     * Deletes an existing Employer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionWardName() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $districtId = $parents[0];
                $out = Employer::getWardName($districtId);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }
	
	public function actionDistrictName() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $RegionId = $parents[0];
                $out = Employer::getDistrictName($RegionId);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }

    /**
     * Finds the Employer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionVerifyEmailVerificationCode()
    {
	    $this->layout="main_private";		
	    $loggedin=Yii::$app->user->identity->user_id; 
        $model = new Employer();	
		
        if ($model->load(Yii::$app->request->post())){	
		$sms="Matched!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view-employer-success', 'id' => $model->employer_id]);
        } 
    }
	public function actionEmployerActivateAccount($id)
    {
        $this->layout="main_public";
		$modelLoanBeneficiary=new LoanBeneficiary();	
		$userID=$modelLoanBeneficiary->getUserIDFromEmployer($id);
		$modelLoanBeneficiary->updateUserActivateAccount($userID->user_id);		
		return $this->redirect(['/site/login','activated_successful'=>1]);
		/*
        return $this->render('viewEmployerSuccess', [
            'status'=>$employer_status,'model'=>$model,
        ]);
		*/
		
    }
}

<?php

namespace backend\modules\repayment\controllers;

use Yii;
//use frontend\modules\repayment\models\LoanBeneficiary;
//use frontend\modules\repayment\models\LoanBeneficiarySearch;
use common\models\LoanBeneficiary;
use backend\modules\repayment\models\LoanBeneficiarySearch;
use frontend\modules\repayment\models\ContactForm;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\repayment\models\EmployedBeneficiary;
use backend\modules\application\models\ApplicationSearch;

/**
 * LoanBeneficiaryController implements the CRUD actions for LoanBeneficiary model.
 */
class LoanBeneficiaryController extends Controller {

    /**
     * @inheritdoc
     */
    public $layout = "main_private";

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
     * Lists all LoanBeneficiary models.
     * @return mixed
     */
    public function actionIndex() {
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
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LoanBeneficiary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->layout = "main_public";
        $model = new LoanBeneficiary();
        $model3 = new ContactForm();
        $modelEmpBenf = new EmployedBeneficiary();
        $model->scenario = 'loanee_registration';

        if ($model->load(Yii::$app->request->post())) {
            //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
            $model->created_at = date("Y-m-d H:i:s");
            $applcantF4IndexNo = $model->f4indexno;
            $NIN = $model->NID;
            $applicantDetails = $modelEmpBenf->getApplicantDetails($applcantF4IndexNo, $NIN);
            $applicantID = $applicantDetails->applicant_id;
            //end check using unique identifiers
            //check using non-unique identifiers
            if (!is_numeric($applicantID)) {
                $firstname = $model->firstname;
                $middlename = $model->middlename;
                $surname = $model->surname;
                $dateofbirth = $model->date_of_birth;
                $placeofbirth = $model->place_of_birth;
                $academicInstitution = $model->learning_institution_id;
                $resultsUsingNonUniqueIdent = $modelEmpBenf->getApplicantDetailsUsingNonUniqueIdentifiers2($firstname, $middlename, $surname, $dateofbirth, $placeofbirth, $academicInstitution);
                $applicantID = $resultsUsingNonUniqueIdent->applicant_id;
            }
            // end check using non-unique identifiers

            if (!is_numeric($applicantID)) {
                if ($model->save()) {
                    $notification = '';
                    return $this->redirect(['view-loanee-success-registered', 'loaneeStatus' => '1', 'activateNotification' => $notification]);
                }
            } else {
                $results_loanee = $model->getUser($applicantID);
                $user_id = $results_loanee->user_id;
                $username = $model->email_address;
                $password = Yii::$app->security->generatePasswordHash($model->password);
                $auth_key = Yii::$app->security->generateRandomString();
                $model->updateUserBasicInfo($username, $password, $auth_key, $user_id);
                $notification = "Kindly click the link below to activate your iLMS account<br/>" . '<a href=activate.php?user_id="' . $user_id . '" target="_blank"><font style="color: #cc0000">Click here to activate account</font></a>';
                return $this->redirect(['view-loanee-success-registered', 'loaneeStatus' => '2', 'activateNotification' => $notification]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model, 'model3' => $model3,
            ]);
        }
    }

    public function actionViewLoaneeSuccessRegistered($loaneeStatus, $activateNotification) {
        $this->layout = "main_public";
        return $this->render('viewLoaneeSuccessRegistered', [
                    'loaneeStatus' => $loaneeStatus, 'activateNotification' => $activateNotification,
        ]);
    }

    /**
     * Updates an existing LoanBeneficiary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $modelLoanBeneficiary = new LoanBeneficiary();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $NIN = '';
            $applcantF4IndexNo = $model->f4indexno;
            $employeeID = $modelLoanBeneficiary->getApplicantDetails($applcantF4IndexNo, $NIN);
            $model->applicant_id = $employeeID->applicant_id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->applicant_id > 0) {
                $applicantDetail = $modelLoanBeneficiary->getApplicantDetailsUsingApplicantID($model->applicant_id);
                $user_id = $applicantDetail->user_id;
                $password12 = $model->password;
                $username = $model->email_address;
                $password = Yii::$app->security->generatePasswordHash($password12);
                $auth_key = Yii::$app->security->generateRandomString();
                $modelLoanBeneficiary->updateUserBasicInfo3($username, $password, $auth_key, $user_id);
                $fullName = $model->firstname . " " . $model->middlename . " " . $model->surname;

                $message = "Dear " . $fullName . ",\r\nKindly use the following credentials for login in iLMS.\r\nUsername: " . $username . "\r\nPassword: " . $password12 . "\r\n\r\nThis email has been sent by Higher Education Students' Loan Board(HESLB).\r\nIf you believe you have received it by mistake, please ignore and sorry for inconvenience.";
                $subject = "iLMS login credentials";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "From: iLMS ";
                if (mail($model->email_address, $subject, $message, $headers)) {
                    $sms = '<p>Information updated successful.</p>';
                    Yii::$app->getSession()->setFlash('success', $sms);
                }
            } else {
                $sms = '<p>Error: Incorrect form IV index number.</p>';
                Yii::$app->getSession()->setFlash('error', $sms);
            }

            return $this->redirect(['index']);
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
    public function actionDelete($id) {
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
    protected function findModel($id) {
        $id = \yii\bootstrap\Html::encode($id);
        if (($model = LoanBeneficiary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAllLoanees() {
        $searchModel = new LoanBeneficiarySearch();
        $dataProvider = $searchModel->searchRepaymentInitiate(Yii::$app->request->queryParams);
        if ($searchModel->check_search == 'CheckSearch') {
            $search_params = Yii::$app->request->queryParams['LoanBeneficiarySearch'];

            if (!empty($search_params['f4indexno']) OR ! empty($search_params['NID']) OR ! empty($search_params['loan_no']) OR ! empty($search_params['name']) OR ! empty($search_params['academic_year_id']) OR ! empty($search_params['learning_institution_id'])) {
                $dataProvider = $searchModel->getAllLoanees(Yii::$app->request->queryParams);
            }
        }
        return $this->render('allLoanees', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewLoaneeDetails($id) {
        $applicant_id = \yii\bootstrap\Html::encode($id);
        $searchModel = new ApplicationSearch();
        $searchModelLoanBeneficiary = new LoanBeneficiarySearch();
        $searchModelApplicantAssociate = new \frontend\modules\application\models\ApplicantAssociateSearch();
        $searchModelApplicantAttachment = new \frontend\modules\application\models\ApplicantAttachmentSearch();
        $searchModeleducation = new \frontend\modules\application\models\EducationSearch();
        $searchModelAllocatedLoan = new \backend\modules\allocation\models\AllocationSearch();
        $searchModelDisbursement = new \backend\modules\disbursement\models\DisbursementSearch();
        $dataProvider = $searchModel->searchHelpDesk(Yii::$app->request->queryParams);

        $model = \backend\modules\application\models\Application::find()
                ->where(['application.applicant_id' => $applicant_id])
                ->JoinWith('applicant')
                ->joinwith(["applicant", "applicant.user"])
                ->orderBy(['application.application_id' => SORT_DESC])
                ->one();
        $application_id = $model->application_id;
        $dataProviderApplicantAssociate = $searchModelApplicantAssociate->searchHelpDesk(Yii::$app->request->queryParams, $application_id);
        $dataProviderApplicantAttachment = $searchModelApplicantAttachment->searchAttachments(Yii::$app->request->queryParams, $application_id);
        $dataProviderEducation = $searchModeleducation->searchHelpDesk(Yii::$app->request->queryParams, $applicant_id);
        $dataProviderDisbursement = $searchModelDisbursement->searchDisbursedLoan(Yii::$app->request->queryParams, $applicant_id);
        //getting beneficiarry disbursements per application
        $dataProviderBeneficiaryApplications = \backend\modules\disbursement\models\Disbursement::find()->select('DISTINCT(application_id) AS application_id')
                ->where('application_id IN(SELECT application_id from application WHERE applicant_id=:applicant_id)', [':applicant_id' => $model->applicant_id])
                ->all();
        return $this->render('viewLoaneeDetails', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'searchModelApplicantAssociate' => $searchModelApplicantAssociate,
                    'dataProviderApplicantAssociate' => $dataProviderApplicantAssociate,
                    'dataProviderApplicantAttachment' => $dataProviderApplicantAttachment,
                    'searchModelApplicantAttachment' => $searchModelApplicantAttachment,
                    'dataProviderEducation' => $dataProviderEducation,
                    'searchModeleducation' => $searchModeleducation,
                    'searchModelAllocatedLoan' => $searchModelAllocatedLoan,
                    'dataProviderAllocatedLoan' => $dataProviderAllocatedLoan,
                    'searchModelLoanBeneficiary' => $searchModelLoanBeneficiary,
                    'dataProviderDisbursement' => $dataProviderDisbursement,
                    'searchModelDisbursement' => $searchModelDisbursement,
                    'dataProviderBeneficiaryApplications' => $dataProviderBeneficiaryApplications
        ]);
    }

    public function actionViewApplicationsDetails($applicant_id) {
        $this->layout = "default_main";
        return $this->render('viewApplicationsDetails', [
                    'applicant_id' => $applicant_id,
        ]);
    }

    public function actionPrintOperations() {
        $this->layout = "default_main";
        $model = new LoanBeneficiary();
        if ($model->load(Yii::$app->request->post())) {
            $category = $model->operation;
            $applicantID = $model->applicant_id;
            return $this->render('printOperations', [
                        'category' => $category, 'applicant_id' => $applicantID,
            ]);
        }
    }

    public function actionViewLoaneeDetailsRefund($id) {
        $modelLoanBeneficiary = new LoanBeneficiary();
        return $this->render('viewLoaneeDetailsRefund', [
                    'model' => $modelLoanBeneficiary->findApplicant($id), 'applicant_id' => $id, 'modelLoanBeneficiary' => $modelLoanBeneficiary,
        ]);
    }

    public function actionNewRefundClaim() {
        $searchModel = new LoanBeneficiarySearch();
        $dataProvider = $searchModel->getAllLoanees(Yii::$app->request->queryParams);

        return $this->render('newRefundClaim', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReprocessLoan() {
        $model = new LoanBeneficiary();
        $model->scenario = 'reprocessloan';
        if ($model->load(Yii::$app->request->post())) {
            ##################### run VRF check ###################
            \frontend\modules\repayment\models\LoanSummary::updateVRFaccumulatedGeneral();
            ########################		
            $startDate = $model->start_date;
            $endDate = $model->end_date;
            $dateToday = date("Y-m-d");
            $beneficiariesResults = \backend\modules\repayment\models\LoanRepaymentDetail::getBeneficiariesOnRepaymentWithinDateRange($startDate, $endDate);
            foreach ($beneficiariesResults AS $applicantDetails) {
                $applicant_id = $applicantDetails->applicant_id;
                //check original amount disbursed
                $totalAmountDisbursed = \common\models\LoanBeneficiary::getPrincipleNoReturn($applicant_id);
                $totalDisbursed = $totalAmountDisbursed->disbursed_amount;

                //check amount calculated in a first loan summary
                //---------------This is for PRC-----------
                $itemCodePRC = "PRC";
                $PRC_id = \backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePRC);
                $resultPRC = \backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountInFirstLoanSummary($applicant_id, $PRC_id);
                $totalPRC = $resultPRC->amount;
                //--------------END PRC------------------
                if ($totalPRC != $totalDisbursed) {
                    //---------------This is for LAF-----------
                    $itemCodeLAF = "LAF";
                    $LAF_id = \backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeLAF);
                    $resultLAF = \backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountInFirstLoanSummary($applicant_id, $LAF_id);
                    $totalLAF = $resultLAF->amount;
                    //--------------END LAF------------------	
                    //---------------This is for PNT-----------
                    $itemCodePNT = "PNT";
                    $PNT_id = \backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePNT);
                    $resultPNT = \backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountInFirstLoanSummary($applicant_id, $PNT_id);
                    $totalPNT = $resultPNT->amount;
                    //--------------END PNT------------------
                    //---------------This is for VRF-----------
                    $itemCodeVRF = "VRF";
                    $VRF_id = \backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeVRF);
                    $resultVRF = \backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountInFirstLoanSummary($applicant_id, $VRF_id);
                    $totalVRF = $resultVRF->amount;
                    //--------------END VRF------------------
                    $reSid = 1;

                    ############### Looping for checking disbursed amount Again #######################
                    $getDistinctAccademicYrPerApplicant = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
                    $count = 0;
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                        $academicYearID = $resultsApp->disbursementBatch->academic_year_id;
                        $academicYearEndate = $resultsApp->disbursementBatch->academicYear->end_date;
                        $statusDate = $resultsApp->status_date;
                        $pricipalLoanwettggg = \common\models\LoanBeneficiary::getAmountSubtotalPerAccademicYNoReturned($applicant_id, $academicYearID);
                        $pricipalLoan = $pricipalLoanwettggg->disbursed_amount;
                        if ($pricipalLoan == '' OR $pricipalLoan < 0) {
                            $pricipalLoan = 0;
                        }

                        //-----------comparing the amount disbursed with the amount in first loanSummary----------				
                        $PRCamountInfirstLoanSummaryPerAcademicYear = \backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountPRCInFirstLoanSummaryPerAcademicYear($applicant_id, $PRC_id, $academicYearID);
                        $PRCamountFirstLoanSummary = $PRCamountInfirstLoanSummaryPerAcademicYear->amount;
                        if ($pricipalLoan != $PRCamountFirstLoanSummary) {
                            $missingAmount = $pricipalLoan - $PRCamountFirstLoanSummary;
                        }
                        //------check if exist in the loan summary before -------
                        $checkExistsStatus = \backend\modules\repayment\models\LoanSummaryDetail::checkPRCexistPerAcademicYearInfirstLoanSummary($applicant_id, $PRC_id, $academicYearID);
                        $activeLoanSummary = \backend\modules\repayment\models\LoanSummaryDetail::getActiveLoanSummaryOfBeneficiary($applicant_id);
                        $loan_summary_id = $activeLoanSummary->loan_summary_id;
                        $lastLoanSummaryAcademicYearID = $activeLoanSummary->academic_year_id;
                        if ($checkExistsStatus->loan_summary_id > 0) {
                            if ($missingAmount > 0) {
                                //-------------update last loan summary with missing amount-------------	
                                if ($lastLoanSummaryAcademicYearID == '') {
                                    \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $missingAmount, $PRC_id);
                                } else {
                                    \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdatePRCperAcademicYear($loan_summary_id, $applicant_id, $missingAmount, $PRC_id, $lastLoanSummaryAcademicYearID);
                                }
                            }
                            //-------------checking other repayment items exists in first loan summary----checkAmountMissingUpdateGeneral
                            $otherItemExistsFirstLoanSummaryLAF = \backend\modules\repayment\models\LoanSummaryDetail::checkOtherItemsexistInfirstLoanSummary($applicant_id, $LAF_id);
                            $otherItemExistsFirstLoanSummaryPNT = \backend\modules\repayment\models\LoanSummaryDetail::checkOtherItemsexistInfirstLoanSummary($applicant_id, $PNT_id);
                            $otherItemExistsFirstLoanSummaryVRF = \backend\modules\repayment\models\LoanSummaryDetail::checkOtherItemsexistInfirstLoanSummary($applicant_id, $VRF_id);
                            if ($otherItemExistsFirstLoanSummaryLAF > 0) {
                                $additionalAmountLAFreprocessLoan = \backend\modules\repayment\models\EmployedBeneficiary::getIndividualLAFReprocessLoan($missingAmount);
                                \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $additionalAmountLAFreprocessLoan, $LAF_id);
                            }
                            if ($otherItemExistsFirstLoanSummaryPNT > 0) {
                                $additionalAmountPNTreprocessLoan = \backend\modules\repayment\models\EmployedBeneficiary::getIndividualPNTreprocessLoan($missingAmount);
                                \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $additionalAmountPNTreprocessLoan, $PNT_id);
                            }
                            if ($otherItemExistsFirstLoanSummaryVRF > 0) {
                                $additionalAmountVRFreprocessLoan = \backend\modules\repayment\models\EmployedBeneficiary::getIndividualVRFreprocessLoan($applicant_id, $dateToday, $missingAmount, $statusDate, $academicYearEndate);
                                \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $additionalAmountVRFreprocessLoan, $VRF_id);
                            }
                        } else {
                            //---------------check for last loan summary---------------------	
                            $activeLoanSummary = \backend\modules\repayment\models\LoanSummaryDetail::getActiveLoanSummaryOfBeneficiary($applicant_id);
                            $loan_summary_id = $activeLoanSummary->loan_summary_id;
                            $lastLoanSummaryAcademicYearID = $activeLoanSummary->academic_year_id;

                            \backend\modules\repayment\models\LoanSummaryDetail::insertItemPRCperAcademicYear($loan_summary_id, $applicant_id, $PRC_id, $academicYearID, $pricipalLoan);

                            //--------------------OTHER ITEM------------------
                            $otherItemExistsFirstLoanSummaryLAF = \backend\modules\repayment\models\LoanSummaryDetail::checkOtherItemsexistInfirstLoanSummary($applicant_id, $LAF_id);
                            $otherItemExistsFirstLoanSummaryPNT = \backend\modules\repayment\models\LoanSummaryDetail::checkOtherItemsexistInfirstLoanSummary($applicant_id, $PNT_id);
                            $otherItemExistsFirstLoanSummaryVRF = \backend\modules\repayment\models\LoanSummaryDetail::checkOtherItemsexistInfirstLoanSummary($applicant_id, $VRF_id);
                            if ($otherItemExistsFirstLoanSummaryLAF > 0) {
                                //--------------LAF---------------------------
                                $additionalAmountLAFreprocessLoan = \backend\modules\repayment\models\EmployedBeneficiary::getIndividualLAFReprocessLoan($pricipalLoan);
                                \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $additionalAmountLAFreprocessLoan, $LAF_id);
                            }
                            if ($otherItemExistsFirstLoanSummaryPNT > 0) {
                                //--------------PNT--------------------------
                                $additionalAmountPNTreprocessLoan = \backend\modules\repayment\models\EmployedBeneficiary::getIndividualPNTreprocessLoan($pricipalLoan);
                                \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $additionalAmountPNTreprocessLoan, $PNT_id);
                            }
                            if ($otherItemExistsFirstLoanSummaryVRF > 0) {
                                //--------------VRF--------------------------
                                $additionalAmountVRFreprocessLoan = \backend\modules\repayment\models\EmployedBeneficiary::getIndividualVRFreprocessLoan($applicant_id, $dateToday, $pricipalLoan, $statusDate, $academicYearEndate);
                                \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $additionalAmountVRFreprocessLoan, $VRF_id);
                            }
                            //---------------END OTHER ITEM-------------------
                        }
                        ++$count;
                    }
                    ############################## Looping for checking disbursed amount Again ################
                    #####################Updating the general summary latest########################
                    \backend\modules\repayment\models\LoanSummaryDetail::updateGeneralAmountLastLoanSummary($loan_summary_id);
                } else {
                    //check status of the amount already paid per item against orgin amount from first loanSummary
                    #######################Items id#####################
                    $itemCodeLAF = "LAF";
                    $LAF_id = \backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeLAF);
                    $itemCodePNT = "PNT";
                    $PNT_id = \backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePNT);
                    $itemCodeVRF = "VRF";
                    $VRF_id = \backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeVRF);
                    $itemCodePRC = "PRC";
                    $PRC_id = \backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePRC);
                    #####################################end items id#########
                    ###############################ORGIN###########################
                    //---------------This is for LAF-----------
                    $resultLAF = \backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountInFirstLoanSummary($applicant_id, $LAF_id);
                    $totalLAFORGN = $resultLAF->amount;
                    //---------------This is for PNT-----------
                    $resultPNT = \backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountInFirstLoanSummary($applicant_id, $PNT_id);
                    $totalPNTORGN = $resultPNT->amount;
                    //----------------This is for VRF-----------------
                    $totalVRFORGN = \backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($applicant_id, $dateToday);
                    //---------------this is for PRC-------------
                    $resultPRC = \backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountInFirstLoanSummary($applicant_id, $PRC_id);
                    $totalPRCORGN = $resultPRC->amount;
                    ####################################end for ORGIN####################################
                    ########################here for amount paid in each loan repayment item#################################
                    $AmountPaidPerItemTotalLAF = \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id, $LAF_id);
                    $totalAmountAlreadyPaidLAF = $AmountPaidPerItemTotalLAF->amount;
                    $AmountPaidPerItemTotalPNT = \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id, $PNT_id);
                    $totalAmountAlreadyPaidPNT = $AmountPaidPerItemTotalPNT->amount;
                    $AmountPaidPerItemTotalVRF = \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id, $VRF_id);
                    $totalAmountAlreadyPaidVRF = $AmountPaidPerItemTotalVRF->amount;
                    $AmountPaidPerItemTotalPRC = \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id, $PRC_id);
                    $totalAmountAlreadyPaidPRC = $AmountPaidPerItemTotalPRC->amount;
                    #########################end for amount paid in each loan repayment item######################
                    #######################LAST LOAN SUMMARY get amount remained##########################################
                    $activeLoanSummary = \backend\modules\repayment\models\LoanSummaryDetail::getActiveLoanSummaryOfBeneficiary($applicant_id);
                    $loan_summary_id = $activeLoanSummary->loan_summary_id;
                    $lastLoanSummaryAcademicYearID = $activeLoanSummary->academic_year_id;
                    $vrfAmountLastLoanSummaryUnpaid = \frontend\modules\repayment\models\EmployedBeneficiary::getIndividualEmployeesVRFUnderBill($applicant_id, $loan_summary_id);
                    $LAFAmountLoanSummaryUnpaid = \frontend\modules\repayment\models\EmployedBeneficiary::getIndividualEmployeesLAFUnderBill($applicant_id, $loan_summary_id);
                    $penaltyAmountLastLoanSummaryUnpaid = \frontend\modules\repayment\models\EmployedBeneficiary::getIndividualEmployeesPenaltyUnderBill($applicant_id, $loan_summary_id);
                    $PRCAmountLastLoanSummaryUnpaid = \frontend\modules\repayment\models\EmployedBeneficiary::getOutstandingPrincipalLoanUnderBill($applicant_id, $loan_summary_id);
                    ###############################################################################################
                    if ((($totalLAFORGN - $totalAmountAlreadyPaidLAF) - $LAFAmountLoanSummaryUnpaid) > 0) {
                        $generalMissingAmountLAF = ($totalLAFORGN - $totalAmountAlreadyPaidLAF) - $LAFAmountLoanSummaryUnpaid;
                        \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $generalMissingAmountLAF, $LAF_id);
                    }
                    if ((($totalPNTORGN - $totalAmountAlreadyPaidPNT) - $penaltyAmountLastLoanSummaryUnpaid) > 0) {
                        $generalMissingAmountPNT = ($totalPNTORGN - $totalAmountAlreadyPaidPNT) - $penaltyAmountLastLoanSummaryUnpaid;
                        \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $generalMissingAmountPNT, $PNT_id);
                    }
                    if ((($totalVRFORGN - $totalAmountAlreadyPaidVRF) - $vrfAmountLastLoanSummaryUnpaid) > 0) {
                        $generalMissingAmountVRF = ($totalVRFORGN - $totalAmountAlreadyPaidVRF) - $vrfAmountLastLoanSummaryUnpaid;
                        \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $generalMissingAmountVRF, $VRF_id);
                    }
                    if ((($totalPRCORGN - $totalAmountAlreadyPaidPRC) - $PRCAmountLastLoanSummaryUnpaid) > 0) {
                        $generalMissingAmountPRC = ($totalPRCORGN - $totalAmountAlreadyPaidPRC) - $PRCAmountLastLoanSummaryUnpaid;
                        if ($lastLoanSummaryAcademicYearID == '') {
                            \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdateGeneral($loan_summary_id, $applicant_id, $generalMissingAmountPRC, $PRC_id);
                        } else {
                            \backend\modules\repayment\models\LoanSummaryDetail::checkAmountMissingUpdatePRCperAcademicYear($loan_summary_id, $applicant_id, $generalMissingAmountPRC, $PRC_id, $lastLoanSummaryAcademicYearID);
                        }
                    }
                    #############################################################################################
                    #####################Updating the general summary latest########################
                    \backend\modules\repayment\models\LoanSummaryDetail::updateGeneralAmountLastLoanSummary($loan_summary_id);
                }
            }
            return $this->redirect(['reprocess-loan']);
        } else {
            return $this->render('reprocessLoan', [
                        'model' => $model
            ]);
        }
    }

    public function actionConfirmStatement($id) {
        $id = \yii\bootstrap\Html::encode($id);
        $model = LoanBeneficiary::find()->where(['applicant_id' => $id])->one();
        if (!$model) {
            $applicant = \backend\modules\application\models\Applicant::find()->where(['applicant_id' => $id])->one();
            if ($applicant) {
                $model = new LoanBeneficiary;
                $model->applicant_id = $applicant->applicant_id;
                $model->firstname = $applicant->user->firstname;
                $model->middlename = $applicant->user->middlename;
                $model->surname = $applicant->user->surname;
                $model->sex = $applicant->sex;
                $model->f4indexno = $applicant->f4indexno;
                $model->NID = $applicant->NID;
                $model->physical_address = $applicant->physical_address;
                $model->save();
            }
            if (!$model) {
                $sms = 'Operation failed, No details available in the Beneficiary List';
                Yii::$app->session->setFlash('failure', $sms);
                return $this->redirect(['/repayment/loan-beneficiary/view-loanee-details', 'id' => $id]);
            }
        }

        $model->loan_confirmation_status = LoanBeneficiary::LOAN_STATEMENT_CONFIRMED;
        $model->date_confirmed = Date('Y-m-d H:i:s', time());
        $model->confirmed_by = Yii::$app->user->id;
        if (!$model->save()) {
            $sms = 'Operation failed';
        }
        Yii::$app->session->setFlash('failure', $sms);
        return $this->redirect(['/repayment/loan-beneficiary/view-loanee-details', 'id' => $id]);
    }

    public function actionRecalculateLoan($id) {
        
    }

    public function actionIssueRiquidation($id) {
        $id = \yii\bootstrap\Html::encode($id);
        $model = LoanBeneficiary::find()->where(['applicant_id' => $id])->one();
        if (!$model) {
            $sms = 'Operation failed, No details available in the Beneficiary List';
            Yii::$app->session->setFlash('failure', $sms);
            return $this->redirect(['/repayment/loan-beneficiary/view-loanee-details', 'id' => $id]);
        }
        $model->liquidation_letter_status =LoanBeneficiary::LOAN_LIQUIDATION_ISSUED;
        $model->liquidation_date_issued = Date('Y-m-d H:i:s', time());
        $model->liquidation_issued_by = Yii::$app->user->id;
        if (!$model->save()) {
            $sms = 'Operation failed';
        }
      
        Yii::$app->session->setFlash('failure', $sms);
        return $this->redirect(['/repayment/loan-beneficiary/view-loanee-details', 'id' => $id]);
    }

}

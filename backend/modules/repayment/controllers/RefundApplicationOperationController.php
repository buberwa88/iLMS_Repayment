<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\RefundApplicationOperation;
use backend\modules\repayment\models\RefundApplicationOperationSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RefundApplicationOperationController implements the CRUD actions for RefundApplicationOperation model.
 */
class RefundApplicationOperationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $this->layout = "main_private";
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
     * Lists all RefundApplicationOperation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefundApplicationOperationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefundApplicationOperation model.
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
     * Creates a new RefundApplicationOperation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RefundApplicationOperation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->refund_application_operation_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RefundApplicationOperation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->refund_application_operation_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RefundApplicationOperation model.
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
     * Finds the RefundApplicationOperation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefundApplicationOperation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefundApplicationOperation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionUnverifiedref() {
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $current_status = 0;
        $dataProvider = $searchModel->searchVerification(Yii::$app->request->queryParams,$current_status);
        return $this->render('unverified_refundapplications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionViewRefund($id,$action = null) {
        if($action == 'view'){
            //$model = $this->findModel($id);
            $model =\frontend\modules\repayment\models\RefundApplication::findOne($id);
            return $this->render('refund_application_details', [
                'model' => $model,
            ]);
        }
        else{
            if (isset($_POST['RefundVerificationFrameworkItem'])) {
                $posted_data = Yii::$app->request->post();
                $applicant_attachment_id = $posted_data['RefundVerificationFrameworkItem']['refund_claimant_attachment_id'];
                $verification_status = $posted_data['RefundVerificationFrameworkItem']['verification_status'];
                $comment = $posted_data['RefundVerificationFrameworkItem']['refund_comment_id'];
                $other_description = $posted_data['RefundVerificationFrameworkItem']['other_description'];
                $attachment_definition_id = $posted_data['RefundVerificationFrameworkItem']['attachment_definition_id'];
                $attachment_path = $posted_data['RefundVerificationFrameworkItem']['attachment_path'];
                $verificationFrameworkIDP = $posted_data['RefundVerificationFrameworkItem']['refund_verification_framework_id'];
                $todate=date("Y-m-d H:i:s");
                $userID=Yii::$app->user->identity->user_id;
                if($applicant_attachment_id !=''){
                    $applicant_attachment = \backend\modules\repayment\models\RefundClaimantAttachment::findOne(['refund_claimant_attachment_id'=>$applicant_attachment_id]);

                    $applicant_attachment->verification_status = $verification_status;
                    $applicant_attachment->refund_comment_id = $comment;
                    $applicant_attachment->other_description = $other_description;
                    if($attachment_path==''){
                        $applicant_attachment->attachment_path = "refund_attachment/refund_verification_missing_image.jpg";
                    }
                    $applicant_attachment->last_verified_by = $userID;
                    $applicant_attachment->last_verified_at  = $todate;
                    // here for logs
                    $old_data=\yii\helpers\Json::encode($applicant_attachment->oldAttributes);
                    //end for logs
                    $applicant_attachment->save(false);
                    // here for logs
                    $new_data=\yii\helpers\Json::encode($applicant_attachment->attributes);
                    $model_logs=\common\models\base\Logs::CreateLogall($applicant_attachment->refund_claimant_attachment_id,$old_data,$new_data,"refund_claimant_attachment","UPDATE",1);
                    //end for logs
                }
                if($applicant_attachment_id==''){
                    $applicantAttachmentModel = new \backend\modules\repayment\models\RefundClaimantAttachment();
                    $applicantAttachmentModel->refund_application_id=$id;
                    $applicantAttachmentModel->attachment_definition_id=$attachment_definition_id;
                    $applicantAttachmentModel->attachment_path="applicant_attachment/profile/verification_missing_image.jpg";
                    $applicantAttachmentModel->verification_status = $verification_status;
                    $applicantAttachmentModel->refund_comment_id = $comment;
                    $applicantAttachmentModel->other_description = $other_description;
                    $applicantAttachmentModel->last_verified_by = $userID;
                    $applicantAttachmentModel->last_verified_at  = $todate;

                    // here for logs
                    $old_data=\yii\helpers\Json::encode($applicantAttachmentModel->oldAttributes);
                    //end for logs
                    $applicantAttachmentModel->save(false);
                    // here for logs
                    $new_data=\yii\helpers\Json::encode($applicantAttachmentModel->attributes);
                    $model_logs=\common\models\base\Logs::CreateLogall($applicantAttachmentModel->refund_claimant_attachment_id,$old_data,$new_data,"refund_claimant_attachment","UPDATE",1);
                    //end for logs
                }

                $vreificationFrameworkResults = \frontend\modules\repayment\models\RefundApplication::findOne(['refund_application_id'=>$id]);
                if($vreificationFrameworkResults->refund_verification_framework_id==''){
                    $vreificationFrameworkResults->refund_verification_framework_id=$verificationFrameworkIDP;
                    // here for logs
                    $old_data=\yii\helpers\Json::encode($vreificationFrameworkResults->oldAttributes);
                    //end for logs
                    $vreificationFrameworkResults->save(false);
                    // here for logs
                    $new_data=\yii\helpers\Json::encode($vreificationFrameworkResults->attributes);
                    $model_logs=\common\models\base\Logs::CreateLogall($vreificationFrameworkResults->refund_application_id,$old_data,$new_data,"refund_application","UPDATE",1);
                    //end for logs
                }

                $vreificationFrameworkResultsAttemptedBy = \frontend\modules\repayment\models\RefundApplication::findOne(['refund_application_id'=>$id]);
                $userAttempted = Yii::$app->user->identity->user_id;
                $date_verified=$vreificationFrameworkResultsAttemptedBy->updated_at;
                $todate=date("Y-m-d");
                //if(($vreificationFrameworkResultsAttemptedBy->updated_by != $userAttempted) && ($date_verified !=$todate)){
                    $userAttempted = Yii::$app->user->identity->user_id;
                    $vreificationFrameworkResultsAttemptedBy->updated_by=$userAttempted;
                    $vreificationFrameworkResultsAttemptedBy->updated_at=date("Y-m-d H:i:s");
                    $vreificationFrameworkResultsAttemptedBy->last_verified_by=$userAttempted;
                    $vreificationFrameworkResultsAttemptedBy->date_verified=date("Y-m-d H:i:s");
                    // here for logs
                    $old_data=\yii\helpers\Json::encode($vreificationFrameworkResultsAttemptedBy->oldAttributes);
                    //end for logs
                    $vreificationFrameworkResultsAttemptedBy->save(false);
                    // here for logs
                    $new_data=\yii\helpers\Json::encode($vreificationFrameworkResultsAttemptedBy->attributes);
                    $model_logs=\common\models\base\Logs::CreateLogall($vreificationFrameworkResultsAttemptedBy->refund_application_id,$old_data,$new_data,"refund_application","UPDATE",1);
                    //end for logs
                //}
                $this->checkApplicationStatus($verificationFrameworkIDP,$id);
            }

            $model =\frontend\modules\repayment\models\RefundApplication::findOne($id);

            $condition =$model->refund_application_id;
            $applicationID=$model->refund_application_id;
            $applicantCategory=$model->refund_type_id;
            $released=$model->submitted;
            $verificationStatus=$model->current_status;

            $verification_framework_id =$model->refund_verification_framework_id;
            if($verification_framework_id==''){
                $verificationF=\backend\modules\repayment\models\RefundVerificationFramework::getActiveFramework($applicantCategory);
                $verificationFrameworkID=$verificationF->refund_verification_framework_id;
            }else{
                $verificationFrameworkID=$verification_framework_id;
            }
            $dataProvider=\backend\modules\repayment\models\RefundVerificationFrameworkItem::getVerificationAttachments($applicationID, $verificationFrameworkID);


            return $this->render('viewRefund', [
                'dataProvider' => $dataProvider,
                'model' => $model,'application_id'=>$condition,'released'=>$released,'verificationStatus'=>$verificationStatus,
            ]);
        }
    }

    function checkApplicationStatus($verification_framework_id,$applicationId) {
        //
        $models = \backend\modules\repayment\models\RefundVerificationFrameworkItem::find()->where(['refund_verification_framework_id' => $verification_framework_id])->all();
        if (count($models) > 0) {
            $invalid = $valid = $waiting = $empty = $pending = $incomplete = 0;
            foreach ($models as $model) {
                $attachment_definition_id=$model->attachment_definition_id;
                // below line changed today 13-08-2018
                $category_=$model->status;
                $modelsAttachment = \backend\modules\repayment\models\RefundClaimantAttachment::find()->where(['refund_application_id' => $applicationId,'attachment_definition_id' => $attachment_definition_id])->one();
                if(count($modelsAttachment) >0){
                    if ($modelsAttachment->verification_status == 0) {
                        //check for pending
                        $pending=1;
                    }else{
                        // below line changed today 13-08-2018
                        if($category_==1){
                            if ($modelsAttachment->verification_status == 1) {
                                //check for valid
                                $valid+=$modelsAttachment->verification_status;
                            } else if ($modelsAttachment->verification_status == 2) {
                                //check for invalid
                                $invalid+=$modelsAttachment->verification_status;
                            } else if ($modelsAttachment->verification_status == 3) {
                                //check for waiting
                                $waiting+=$modelsAttachment->verification_status;
                            } else if ($modelsAttachment->verification_status == 4) {
                                //check for incomplete
                                $incomplete+=$modelsAttachment->verification_status;
                            }else {
                                $empty+=1;
                            }
                        }
                    }
                }
            }
            //$this->updateApplicationStatus($applicationId,$valid,$invalid,$empty,$waiting);
            $modelApplication=\frontend\modules\repayment\models\RefundApplication::findone($applicationId);
            $status=0;
            if($pending > 0){
                //pending
                $status = 5;
            }else if ($valid > 0 && $invalid == 0 && $waiting==0 && $pending==0 && $incomplete==0) {
                //complete
                    $status = 1;
            } else if ($pending==0 && $invalid > 0) {
                //invalid
                $status = 4;
                // below line changed today 13-08-2018
            } elseif ($pending==0 && $invalid == 0 && $waiting== 0 && $incomplete > 0 && ($valid > 0 || $valid == 0)) {
                //Incomplete
                $status = 2;
                // below line changed today 13-08-2018
            }elseif ($pending==0 && $invalid == 0 && $waiting > 0 && ($incomplete > 0  || $incomplete == 0) && ($valid > 0 || $valid == 0)) {
                //waiting
                $status = 3;
            }
            $modelApplication->current_status  = $status;
            // here for logs
            $old_data=\yii\helpers\Json::encode($modelApplication->oldAttributes);
            //end for logs
            $modelApplication->save(false);
            // here for logs
            $new_data=\yii\helpers\Json::encode($modelApplication->attributes);
            $model_logs=\common\models\base\Logs::CreateLogall($modelApplication->refund_application_id,$old_data,$new_data,"refund_application","UPDATE",1);
            //end for logs
        }
        // Automatic send refund to next level if overall status is 1
        if($status==1) {
            $resultsSetting=\backend\modules\repayment\models\RefundInternalOperationalSetting::getSettingDetails();
            $refund_application_id=$applicationId; $refund_internal_operational_id=$resultsSetting->refund_internal_operational_id; $access_role_master=$resultsSetting->access_role_master; $access_role_child=$resultsSetting->access_role_child;
            //check if exists
            $applicationDetails = \backend\modules\repayment\models\RefundApplicationOperation::findBySql("SELECT * FROM refund_application_operation
                    where  refund_application_id='$refund_application_id'")->count();
            //end
            if ($applicationDetails ==0) {
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation($refund_application_id, $refund_internal_operational_id, $access_role_master, $access_role_child);
            }
        }
        return $this->redirect(['view-refund','id' => $applicationId]);

    }
    public function actionCompleteref() {
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $current_status = [1,6,7,8,9];
        $dataProvider = $searchModel->searchVerification(Yii::$app->request->queryParams,$current_status);
        return $this->render('complete_refundapplications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPendingref() {
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $current_status = [5];
        $dataProvider = $searchModel->searchVerification(Yii::$app->request->queryParams,$current_status);
        return $this->render('pending_refundapplications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionInvalidref() {
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $current_status = [4];
        $dataProvider = $searchModel->searchVerification(Yii::$app->request->queryParams,$current_status);
        return $this->render('invalid_refundapplications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIncompleteref() {
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $current_status = [2];
        $dataProvider = $searchModel->searchVerification(Yii::$app->request->queryParams,$current_status);
        return $this->render('incomplete_refundapplications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAllapplications() {
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $current_status = [0,1,2,3,4,5];
        $dataProvider = $searchModel->searchVerification(Yii::$app->request->queryParams,$current_status);
        return $this->render('allapplications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionFinalSubmitform($frameworkID,$id) {
        if($frameworkID !=0 && $id !=''){
            $this->checkApplicationStatus($frameworkID,$id);
        }
        return $this->redirect(['unverifiedref']);

    }
    public function actionVerifyapplication() {
        $searchModel = new \backend\modules\repayment\models\RefundApplicationOperationSearch();

        $user_id=Yii::$app->user->identity->user_id;
        $allRoles1=\backend\modules\repayment\models\RefundApplicationOperation::getUserRoleByUserID($user_id);
        $roles=explode(",",$allRoles1->item_name);
        $dataProvider = $searchModel->searchVerification(Yii::$app->request->queryParams,$roles);
        return $this->render('verifyapplication', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionViewRefundlevel($id=null) {
           $modelRefundAppOper = new RefundApplicationOperation();
        $modelRefundAppOper->scenario='refundApplicationOeration';
        $modelRefundAppOper->created_at=date("Y-m-d H:i:s");
        if ($modelRefundAppOper->load(Yii::$app->request->post()) && $modelRefundAppOper->validate()) {
            $id=$modelRefundAppOper->refund_application_id;
            $refOperatDetailsID =\backend\modules\repayment\models\RefundApplicationOperation::find()->where(['refund_application_id'=>$id,'is_current_stage'=>1])->one()->refund_application_operation_id;
            //echo $refOperatDetailsID;exit;

            $refApplicOperat = \backend\modules\repayment\models\RefundApplicationOperation::findOne($refOperatDetailsID);
            $currentFlow_id=$refApplicOperat->refund_internal_operational_id;
            $currentVerificationResponse=$modelRefundAppOper->needStopDeductionOrNot;
            //$refApplicOperat->current_verification_response=$currentVerificationResponse;

            $refApplicOperat->is_current_stage=0;
            $refApplicOperat->save(false);
            //After insert set is_current_stage=0 of the previous stage
            $flow_type=\backend\modules\repayment\models\RefundInternalOperationalSetting::FLOW_TYPE_APPLICATION;
            $internalOperatSettV=\backend\modules\repayment\models\RefundInternalOperationalSetting::findOne($currentFlow_id);
            $current_flow_order_list=$internalOperatSettV->flow_order_list;
 $refund_application_id=$modelRefundAppOper->refund_application_id;
 $verificationStatus=$modelRefundAppOper->verificationStatus;$refundStatusReasonSettingId=$modelRefundAppOper->refund_statusreasonsettingid;
 $narration=$modelRefundAppOper->narration;
 $previousInterOperatID=$modelRefundAppOper->previous_internal_operational_id;
 $lastVerifiedBy=Yii::$app->user->identity->user_id;
 $dataVerified=date("Y-m-d H:i:s");
 $generalStatus=1;
 $responseICode=\backend\modules\repayment\models\RefundVerificationResponseSetting::getVerificationResponseCode($currentVerificationResponse);
 $denialLetterCode=\backend\modules\repayment\models\RefundVerificationResponseSetting::Issue_denial_letter;
 $Permanent_stop_deduction_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Permanent_stop_deduction_letter;
 $Concluded_Valid=\backend\modules\repayment\models\RefundVerificationResponseSetting::Concluded_Valid;
 $No_stop_deduction_needed=\backend\modules\repayment\models\RefundVerificationResponseSetting::No_stop_deduction_needed;
 $Need_investigation=\backend\modules\repayment\models\RefundVerificationResponseSetting::Need_investigation;
 $Temporary_stop_Deduction_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Temporary_stop_Deduction_letter;
if($responseICode->response_code==$denialLetterCode){
    $generalStatus=2;
}
            if($responseICode->response_code==$Permanent_stop_deduction_letter || $responseICode->response_code==$Concluded_Valid || $responseICode->response_code==$denialLetterCode){
                //insert to the refund flow
                //$refApplicOperat->current_verification_response=$modelRefundAppOper->needStopDeductionOrNot;
                //$currentFlow_id=$refApplicOperat->refund_internal_operational_id;
                $statusResponse='REFUND_DATA_SECTION';
                $orderList_ASC_DESC='';
                $condition='';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);

            }else if($responseICode->response_code==$No_stop_deduction_needed || $responseICode->response_code==$Need_investigation){
                //indsert to the next flow if not to audit depart, else send to refund data sesection for response
                $statusResponse='AUDIT_INVEST_SECTION';
                $orderList_ASC_DESC='';
                $condition='';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);
            }else if($responseICode->response_code==$Temporary_stop_Deduction_letter){
                $statusResponse='REFUND_DATA_SECTION';
                $orderList_ASC_DESC='';
                $condition='';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperationTemporaryLetter($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);


                $statusResponse='AUDIT_INVEST_SECTION';
                $orderList_ASC_DESC='';
                $condition='';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);
            }else{
                $statusResponse='';
                $orderList_ASC_DESC=' ASC  ';
                $condition=' > ';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);
            }
            $sms="Information added!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view-refundlevel', 'id' => $id]);
        }else {
            $user_id=Yii::$app->user->identity->user_id;
            $allRoles1=\backend\modules\repayment\models\RefundApplicationOperation::getUserRoleByUserID($user_id);
            $allRoles=$allRoles1->item_name;

            $model = \frontend\modules\repayment\models\RefundApplication::findOne($id);
            $resultRefundApplicatOperatCount = \backend\modules\repayment\models\RefundApplicationOperation::find()->where(['refund_application_id' => $id])->count();
            $detailsAccessRoleCurrent = \backend\modules\repayment\models\RefundApplicationOperation::find()->where(['refund_application_id' => $id,'is_current_stage'=>1])->orderBy(['refund_application_operation_id'=>SORT_DESC])->one();
            $checkIfClosed = \backend\modules\repayment\models\RefundApplicationOperation::find()->where(['refund_application_id' => $id,'general_status'=>2])->count();
            $finalValue='';
            $countCommas=substr_count($allRoles,",");
            for($i=0;$i<=$countCommas;){
                $arrayFound=explode(",",$allRoles);
                if($i==$countCommas){
                    $val='"';
                }else{
                    $val='",';
                }
                $value='"'.$arrayFound[$i].$val;
                $finalValue.=$value;
                $i++;
            }

            $myCurrentStageActive = \backend\modules\repayment\models\RefundApplicationOperation::findBySql("SELECT is_current_stage  FROM refund_application_operation
                    where  	refund_application_id='$id' AND (access_role_master IN($finalValue) OR access_role_child  IN($finalValue)) ORDER BY refund_application_operation_id DESC")->one();

            $isAcurrentStageOnProgress=$myCurrentStageActive->is_current_stage;
            //$isaccess_role_master =$myCurrentStageActive->access_role_master;
            //$isaccess_role_master=$finalValue;

            $condition = $model->refund_application_id;
            $applicationID = $model->refund_application_id;
            $applicantCategory = $model->refund_type_id;
            $released = $resultRefundApplicatOperatCount;
            $verificationStatus = $model->current_status;
            $social_fund_status=$model->social_fund_status;
            $refund_type_id=$model->refund_type_id;
            $access_role_master=$detailsAccessRoleCurrent->access_role_master;
            $isApplicationClosed=$checkIfClosed;
            $refund_internal_operational_id=$detailsAccessRoleCurrent->refund_internal_operational_id;

            $verification_framework_id = $model->refund_verification_framework_id;
            if ($verification_framework_id == '') {
                $verificationF = \backend\modules\repayment\models\RefundVerificationFramework::getActiveFramework($applicantCategory);
                $verificationFrameworkID = $verificationF->refund_verification_framework_id;
            } else {
                $verificationFrameworkID = $verification_framework_id;
            }
            $dataProvider = \backend\modules\repayment\models\RefundVerificationFrameworkItem::getVerificationAttachments($applicationID, $verificationFrameworkID);


            return $this->render('viewRefundlevel', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'application_id' => $condition,
                'released' => $released,
                'verificationStatus' => $verificationStatus,
                'modelRefundAppOper' => $modelRefundAppOper,
                'social_fund_status'=>$social_fund_status,
                'refund_type_id'=>$refund_type_id,
                'access_role_master'=>$access_role_master,
                'isApplicationClosed'=>$isApplicationClosed,
                'currentStageStatus'=>$isAcurrentStageOnProgress,
                'previous_internal_operational_id'=>$refund_internal_operational_id,
                //'currentStageStatus'=>$isaccess_role_master,
            ]);
        }

    }

/*
    public function actionVerifyapplication() {
        $searchModel = new \backend\modules\repayment\models\RefundApplicationOperationSearch();

        $user_id=Yii::$app->user->identity->user_id;
        $allRoles1=\backend\modules\repayment\models\RefundApplicationOperation::getUserRoleByUserID($user_id);
        $roles=explode(",",$allRoles1->item_name);
        $dataProvider = $searchModel->searchVerification(Yii::$app->request->queryParams,$roles);
        return $this->render('verifyapplication', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
*/
    public function actionVerifiedrefappl(){
    $loan_recovery_data_section_code=\backend\modules\repayment\models\RefundInternalOperationalSetting::loan_recovery_data_section_c;
    $currentResonse1=\backend\modules\repayment\models\RefundInternalOperationalSetting::findBySql("SELECT * FROM refund_internal_operational_setting WHERE code='$loan_recovery_data_section_code'")->one();
       $currentLevel=$currentResonse1->refund_internal_operational_id;
        //$searchModel = new \backend\modules\repayment\models\RefundApplicationOperationSearch();
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $dataProvider = $searchModel->searchVerifiedRefundAppl(Yii::$app->request->queryParams,$currentLevel);
        return $this->render('verifiedrefapplication', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionViewVerifref($id=null) {
        $modelRefundAppOper = new RefundApplicationOperation();
        $modelRefundAppOper->scenario='refundApplicationOeration';
        $modelRefundAppOper->created_at=date("Y-m-d H:i:s");
        if ($modelRefundAppOper->load(Yii::$app->request->post()) && $modelRefundAppOper->validate()) {
            $id=$modelRefundAppOper->refund_application_id;
            $refOperatDetailsID =\backend\modules\repayment\models\RefundApplicationOperation::find()->where(['refund_application_id'=>$id,'is_current_stage'=>1])->one()->refund_application_operation_id;
            //echo $refOperatDetailsID;exit;

            $refApplicOperat = \backend\modules\repayment\models\RefundApplicationOperation::findOne($refOperatDetailsID);
            $currentFlow_id=$refApplicOperat->refund_internal_operational_id;
            $internalOperatSettV=\backend\modules\repayment\models\RefundInternalOperationalSetting::findOne($currentFlow_id);
            $current_flow_order_list=$internalOperatSettV->flow_order_list;
            $currentVerificationResponse=$modelRefundAppOper->needStopDeductionOrNot;
            $refApplicOperat->current_verification_response=$currentVerificationResponse;

            $refApplicOperat->is_current_stage=0;
            $refApplicOperat->save(false);
            //After insert set is_current_stage=0 of the previous stage
            $flow_type=\backend\modules\repayment\models\RefundInternalOperationalSetting::FLOW_TYPE_APPLICATION;
            $refund_application_id=$modelRefundAppOper->refund_application_id;
            $verificationStatus=$modelRefundAppOper->verificationStatus;$refundStatusReasonSettingId=$modelRefundAppOper->refund_statusreasonsettingid;
            $narration=$modelRefundAppOper->narration;
            $previousInterOperatID=$modelRefundAppOper->previous_internal_operational_id;
            $lastVerifiedBy=Yii::$app->user->identity->user_id;
            $dataVerified=date("Y-m-d H:i:s");
            $generalStatus=1;
            $responseICode=\backend\modules\repayment\models\RefundVerificationResponseSetting::getVerificationResponseCode($currentVerificationResponse);
            $denialLetterCode=\backend\modules\repayment\models\RefundVerificationResponseSetting::Issue_denial_letter;
            $Permanent_stop_deduction_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Permanent_stop_deduction_letter;
            $Concluded_Valid=\backend\modules\repayment\models\RefundVerificationResponseSetting::Concluded_Valid;
            $No_stop_deduction_needed=\backend\modules\repayment\models\RefundVerificationResponseSetting::No_stop_deduction_needed;
            $Need_investigation=\backend\modules\repayment\models\RefundVerificationResponseSetting::Need_investigation;
            $Temporary_stop_Deduction_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Temporary_stop_Deduction_letter;
            if($responseICode->response_code==$denialLetterCode){
                $generalStatus=2;
            }
            if($responseICode->response_code==$Permanent_stop_deduction_letter || $responseICode->response_code==$Concluded_Valid || $responseICode->response_code==$denialLetterCode){
                //insert to the refund flow
                //$refApplicOperat->current_verification_response=$modelRefundAppOper->needStopDeductionOrNot;
                //$currentFlow_id=$refApplicOperat->refund_internal_operational_id;
                $statusResponse='REFUND_DATA_SECTION';
                $orderList_ASC_DESC='';
                $condition='';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);

            }else if($responseICode->response_code==$No_stop_deduction_needed || $responseICode->response_code==$Need_investigation){
                //indsert to the next flow if not to audit depart, else send to refund data sesection for response
                $statusResponse='AUDIT_INVEST_SECTION';
                $orderList_ASC_DESC='';
                $condition='';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);
            }else if($responseICode->response_code==$Temporary_stop_Deduction_letter){
                $statusResponse='REFUND_DATA_SECTION';
                $orderList_ASC_DESC='';
                $condition='';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperationTemporaryLetter($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);


                $statusResponse='AUDIT_INVEST_SECTION';
                $orderList_ASC_DESC='';
                $condition='';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);
            }else{
                $statusResponse='';
                $orderList_ASC_DESC=' ASC  ';
                $condition=' > ';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;
                \backend\modules\repayment\models\RefundApplicationOperation::insertRefundapplicationoperation_inoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID);
            }
            $sms="Information added!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['view-verifref', 'id' => $id]);
        }else {
            $user_id=Yii::$app->user->identity->user_id;
            $allRoles1=\backend\modules\repayment\models\RefundApplicationOperation::getUserRoleByUserID($user_id);
            $allRoles=$allRoles1->item_name;

            $model = \frontend\modules\repayment\models\RefundApplication::findOne($id);
            $resultRefundApplicatOperatCount = \backend\modules\repayment\models\RefundApplicationOperation::find()->where(['refund_application_id' => $id])->count();
            $detailsAccessRoleCurrent = \backend\modules\repayment\models\RefundApplicationOperation::find()->where(['refund_application_id' => $id,'is_current_stage'=>1])->orderBy(['refund_application_operation_id'=>SORT_DESC])->one();
            $checkIfClosed = \backend\modules\repayment\models\RefundApplicationOperation::find()->where(['refund_application_id' => $id,'general_status'=>2])->count();
            $finalValue='';
            $countCommas=substr_count($allRoles,",");
            for($i=0;$i<=$countCommas;){
                $arrayFound=explode(",",$allRoles);
                if($i==$countCommas){
                    $val='"';
                }else{
                    $val='",';
                }
                $value='"'.$arrayFound[$i].$val;
                $finalValue.=$value;
                $i++;
            }

            $myCurrentStageActive = \backend\modules\repayment\models\RefundApplicationOperation::findBySql("SELECT is_current_stage  FROM refund_application_operation
                    where  	refund_application_id='$id' AND (access_role_master IN($finalValue) OR access_role_child  IN($finalValue)) ORDER BY refund_application_operation_id DESC")->one();

            $isAcurrentStageOnProgress=$myCurrentStageActive->is_current_stage;
            //$isaccess_role_master =$myCurrentStageActive->access_role_master;
            //$isaccess_role_master=$finalValue;

            $condition = $model->refund_application_id;
            $applicationID = $model->refund_application_id;
            $applicantCategory = $model->refund_type_id;
            $released = $resultRefundApplicatOperatCount;
            $verificationStatus = $model->current_status;
            $social_fund_status=$model->social_fund_status;
            $refund_type_id=$model->refund_type_id;
            $access_role_master=$detailsAccessRoleCurrent->access_role_master;
            $isApplicationClosed=$checkIfClosed;
            $refund_internal_operational_id=$detailsAccessRoleCurrent->refund_internal_operational_id;

            $verification_framework_id = $model->refund_verification_framework_id;
            if ($verification_framework_id == '') {
                $verificationF = \backend\modules\repayment\models\RefundVerificationFramework::getActiveFramework($applicantCategory);
                $verificationFrameworkID = $verificationF->refund_verification_framework_id;
            } else {
                $verificationFrameworkID = $verification_framework_id;
            }
            $dataProvider = \backend\modules\repayment\models\RefundVerificationFrameworkItem::getVerificationAttachments($applicationID, $verificationFrameworkID);


            return $this->render('viewVerifiedRefundapp', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'application_id' => $condition,
                'released' => $released,
                'verificationStatus' => $verificationStatus,
                'modelRefundAppOper' => $modelRefundAppOper,
                'social_fund_status'=>$social_fund_status,
                'refund_type_id'=>$refund_type_id,
                'access_role_master'=>$access_role_master,
                'isApplicationClosed'=>$isApplicationClosed,
                'currentStageStatus'=>$isAcurrentStageOnProgress,
                'previous_internal_operational_id'=>$refund_internal_operational_id,
                //'currentStageStatus'=>$isaccess_role_master,
            ]);
        }

    }

    public function actionCreateref() {
        $modelRefundAppOper = new RefundApplicationOperation();
        $modelRefundAppOper->scenario='refundApplicationOeration';
        if ($modelRefundAppOper->load(Yii::$app->request->post()) && $modelRefundAppOper->validate()) {
            $id=$modelRefundAppOper->refund_application_id;
            $refOperatDetailsID =\backend\modules\repayment\models\RefundApplicationOperation::find()->where(['refund_application_id'=>$id,'is_current_stage'=>1])->one()->refund_application_operation_id;

            $refApplicOperat = \backend\modules\repayment\models\RefundApplicationOperation::findOne($refOperatDetailsID);
            $refApplicOperat->status=$modelRefundAppOper->verificationStatus;
            $refApplicOperat->refund_status_reason_setting_id=$modelRefundAppOper->refund_statusreasonsettingid;
            $refApplicOperat->narration=$modelRefundAppOper->narration;
            $refApplicOperat->save(false);
        }else {
            return $this->render('refundTest', [
                'modelRefundAppOper' => $modelRefundAppOper,
            ]);
        }
    }
}

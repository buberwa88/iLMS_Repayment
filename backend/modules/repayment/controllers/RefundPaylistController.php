<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\RefundPaylist;
use backend\modules\repayment\models\RefundPaylistDetails;
use backend\modules\repayment\models\RefundPaylistSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RefundPaylistController implements the CRUD actions for RefundPaylist model.
 */
class RefundPaylistController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all RefundPaylist models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = "main_private";
        ///
        ///paylist models
        $paylistModel = new RefundPaylistSearch();
        $paylists = $paylistModel->search(Yii::$app->request->queryParams);
        ///
        ///pending application models for paylist creation
        $pendingModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $pending_refunds = $pendingModel->searchPendingRefunds(Yii::$app->request->queryParams);
        ///
        ///paid models
        $check=0;
        $paidModel = new RefundPaylistDetails();
        $paid_refunds = $paidModel->searchPaidRefunds(Yii::$app->request->queryParams);
        if($check==0) {
            return $this->render('index_executive', [
                'model' => $paylistModel,
                'dataProvider' => $paylists,
                'paylistModel' => $paylistModel,
                'paylists' => $paylists,
                'pendingModel' => $pendingModel,
                'pending_refunds' => $pending_refunds,
                'paidModel' => $paidModel,
                'paid_refunds' => $paid_refunds
            ]);
        }else{
            return $this->render('index', [
                'paylistModel' => $paylistModel,
                'paylists' => $paylists,
                'pendingModel' => $pendingModel,
                'pending_refunds' => $pending_refunds,
                'paidModel' => $paidModel,
                'paid_refunds' => $paid_refunds
            ]);
        }
    }

    /**
     * Displays a single RefundPaylist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $refund_paylist_id=$id;
        $currentStageLevelRoleMaster=\backend\modules\repayment\models\RefundInternalOperationalSetting::loan_recovery_data_section;
        $account_section=\backend\modules\repayment\models\RefundInternalOperationalSetting::account_section;
        $user_id=Yii::$app->user->identity->user_id;
        $allRoles1=\backend\modules\repayment\models\RefundApplicationOperation::getUserRoleByUserID($user_id);
        $allRoles=$allRoles1->item_name;
        $PaylistOperationModel = new \backend\modules\repayment\models\RefundPaylistOperationSearch();
        $dataProviderPaylistOperation = $PaylistOperationModel->searchPaylistOperation(Yii::$app->request->queryParams,$refund_paylist_id);
        $paylist_details_model = new \backend\modules\repayment\models\RefundPaylistDetails;
        $paylist_details_model->refund_paylist_id = $id;
        $checkIfClosed = \backend\modules\repayment\models\RefundPaylistOperation::find()->where(['refund_paylist_id' => $refund_paylist_id,'general_status'=>2])->count();
        $isPaylistClosedCount=$checkIfClosed;

        $checkifExists = \backend\modules\repayment\models\RefundPaylistOperation::find()->where(['refund_paylist_id' => $refund_paylist_id])->count();
        $ispayListOperatExistCount=$checkifExists;
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
        $myCurrentStageActive = \backend\modules\repayment\models\RefundPaylistOperation::getPaylistOperationCurrentStage($refund_paylist_id,$finalValue);
        $isAcurrentStageOnProgress=$myCurrentStageActive->is_current_stage;
        $currentLevelID=$myCurrentStageActive->refund_internal_operational_id;
        $isCurremtStageRejection=$myCurrentStageActive->status;

        $myCurrentStageActivePaylist = \backend\modules\repayment\models\RefundPaylist::currentStageLevelPaylist($refund_paylist_id);
        $currentLevelID2=$myCurrentStageActivePaylist->current_level;
        if($currentLevelID ==''){
            $currentLevelID=$currentLevelID2;

        }

        //$currentStageCountLevel = \backend\modules\repayment\models\RefundInternalOperationalSetting::currentStageLevel($currentLevelID);
        //$access_role_master=$currentStageCountLevel->access_role_master;
        $foundAccountSection=strpos($finalValue,$account_section);

        $foundFirstLEVEL=strpos($finalValue,$currentStageLevelRoleMaster);
        if($foundFirstLEVEL > 0) {
            $currentStageCountLevel = 1;
            if (strcmp($isAcurrentStageOnProgress,0)==0 || strcmp($isAcurrentStageOnProgress,1)==0) {
                $isAcurrentStageOnProgress=$isAcurrentStageOnProgress;
        }else{

                $isAcurrentStageOnProgress = 1;
            }
        }else{
            $currentStageCountLevel=0;
            $isAcurrentStageOnProgress=$isAcurrentStageOnProgress;
        }

        if($foundAccountSection > 0){
            $accountSectionFound=1;
        }else{
            $accountSectionFound=0;
        }


        return $this->render('view', [
                    'model' => $model,
            'paylist_details_model' => $paylist_details_model,
            'dataProviderPaylistOperation'=>$dataProviderPaylistOperation,
            'isPaylistClosedCount'=>$isPaylistClosedCount,
            'currentStageStatus'=>$isAcurrentStageOnProgress,
            'ispayListOperatExistCount'=>$ispayListOperatExistCount,
            'isCurremtStageRejection'=>$isCurremtStageRejection,
            'currentStageCountLevel'=>$currentStageCountLevel,
            'accountSectionLevel'=>$accountSectionFound,
            //'currentRoleMaster'=>$finalValue,
        ]);
    }

    /**
     * Creates a new RefundPaylist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new RefundPaylist();
        $model->scenario = 'paylist-creation'; /// adding a scenario for conditional validation
        if ($model->load(Yii::$app->request->post())) {
            $model->paylist_number = trim(Date('Ymd') . '-' . mt_rand(1000, 9999)); ///creating a rondom paylist number between 1000 and 10000
            $model->created_by = Yii::$app->user->id;
            $model->status = RefundPaylist::STATUS_CREATED;
            $selected = $model->paylist_claimant;
//            echo'<pre/>';
////            var_dump($model->paylist_claimant);
////            exit;
            if ($model->save()) {
                $paylist_items = 0;
                foreach ($model->paylist_claimant as $key => $claimants) {
                    $application = \frontend\modules\repayment\models\RefundApplication::getRefundApplicationDetailsById($key);
//                    var_dump($application->attributes);
                    if ($application) {
                        $claimant_list = new \backend\modules\repayment\models\RefundPaylistDetails;
                        $claimant_list->refund_paylist_id = $model->refund_paylist_id;
                        $claimant_list->academic_year_id = $application->academic_year_id;
                        $claimant_list->financial_year_id = $application->finaccial_year_id;
                        $claimant_list->claimant_f4indexno = $application->refundClaimant->f4indexno;
                        $claimant_list->refund_application_reference_number = $application->application_number;
                        $claimant_list->refund_claimant_id = $application->refund_claimant_id;
                        $claimant_list->application_id = $key;
                        $claimant_list->claimant_name = $application->refundClaimant->firstname . ' ' . $application->refundClaimant->middlename . ' ' . $application->refundClaimant->surname;
                        $claimant_list->refund_claimant_amount = $application->refund_claimant_amount;
                        $claimant_list->phone_number = $application->refundClaimant->phone_number;
                        $claimant_list->email_address = $application->trustee_email;
                        $claimant_list->status = \backend\modules\repayment\models\RefundPaylistDetails::STATUS_CREATED;
                        ///savinf claimant list in the paylist
                        if ($claimant_list->save()) {
                            $paylist_items++;
                        }
                    }
                }
                if ($paylist_items <= 0) {
                    $sms = 'Error Occured while creating the Paylist items, Please add the Paylist Items one by one';
                    \Yii::$app->session->setFlash('error', $sms);
                }
                return $this->redirect(['view', 'id' => $model->refund_paylist_id]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing RefundPaylist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->refund_paylist_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RefundPaylist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RefundPaylist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefundPaylist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RefundPaylist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionConfirmPaylist($id) {
        $model = $this->findModel($id);
        if ($model->status == RefundPaylist::STATUS_CREATED && $model->hasPaylistItems()) {
            $model->status = RefundPaylist::STATUS_REVIEWED;
            $model->paylist_claimant = $model->hasPaylistItems();
            if ($model->save()) {
                ///run update claimant lists status
                RefundPaylistDetails::updateAll(['status' => RefundPaylistDetails::STATUS_VERIFIED], ['refund_paylist_id' => $model->refund_paylist_id]);
                Yii::$app->session->setFlash('success', 'Operation Done successful');
            } else {
                var_dump($model->errors);
//                exit;
                Yii::$app->session->setFlash('error', 'Operation Failed, Please try again');
            }
        }
        $this->redirect(['/repayment/refund-paylist/view', 'id' => $id]);
    }

    public function actionApprovePaylist($id) {
        $model = $this->findModel($id);
        if ($model->status == RefundPaylist::STATUS_REVIEWED && $model->hasPaylistItems()) {
            $model->status = RefundPaylist::STATUS_APPROVED;
            $model->paylist_claimant = $model->hasPaylistItems();
            if ($model->save()) {
                //updating records for individual refund paylist item
                RefundPaylistDetails::updateAll(['status' => RefundPaylistDetails::STATUS_APPROVED], ['refund_paylist_id' => $model->refund_paylist_id]);

                Yii::$app->session->setFlash('success', 'Operation Done successful');
            } else {
                Yii::$app->session->setFlash('error', 'Operation Failed, Please try again');
            }
        }
        $this->redirect(['/repayment/refund-paylist/view', 'id' => $id]);
    }

    public function actionPaylistapproval($id=null) {

        if($id !='') {
            $lastVerifiedBy = Yii::$app->user->identity->user_id;
            $dataVerified = date("Y-m-d H:i:s");
            $generalStatus = 1;
            $narration = 'Approved';
            $refund_paylist_id = $id;
            $resultsV = \backend\modules\repayment\models\RefundPaylist::findOne($id);
            $current_level = $resultsV->current_level;
            $currentFlow_id = $current_level;
            \backend\modules\repayment\models\RefundPaylistOperation::updatePaylist($refund_paylist_id);
            $internalOperatSettV=\backend\modules\repayment\models\RefundInternalOperationalSetting::findOne($current_level);
            $current_flow_order_list=$internalOperatSettV->flow_order_list;
            $previous_internal_operational_id=$currentFlow_id;
            $status=\backend\modules\repayment\models\RefundPaylistOperation::Approved;
            $flow_type=\backend\modules\repayment\models\RefundInternalOperationalSetting::FLOW_TYPE_PAY_LIST;
            $statusResponse='';
            $orderList_ASC_DESC=' ASC  ';
            $condition=' > ';
            $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
            $access_role_master=$resultsRefundInterOperSett->access_role_master;
            $access_role_child=$resultsRefundInterOperSett->access_role_child;
            $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;

            \backend\modules\repayment\models\RefundPaylistOperation::insertRefundPaylistOperation($refund_paylist_id, $refund_internal_operational_id, $previous_internal_operational_id, $access_role_master, $access_role_child, $status, $narration, $lastVerifiedBy, $dataVerified, $generalStatus);
        }else{
            if (Yii::$app->request->post()) {
                $request = Yii::$app->request->post();
                $narration = $request['rejection_narration'];
                $refund_paylist_id = $request['refund_paylist_id'];
                $id=$refund_paylist_id;
                $lastVerifiedBy=Yii::$app->user->identity->user_id;
                $dataVerified=date("Y-m-d H:i:s");
                $generalStatus=1;

                $resultsV = \backend\modules\repayment\models\RefundPaylist::findOne($refund_paylist_id);
                $current_level=$resultsV->current_level;
                $currentFlow_id=$current_level;
                \backend\modules\repayment\models\RefundPaylistOperation::updatePaylist($refund_paylist_id);
                $internalOperatSettV=\backend\modules\repayment\models\RefundInternalOperationalSetting::findOne($current_level);
                $current_flow_order_list=$internalOperatSettV->flow_order_list;
                $previous_internal_operational_id=$currentFlow_id;
                $status=\backend\modules\repayment\models\RefundPaylistOperation::Rejected;
                $flow_type=\backend\modules\repayment\models\RefundInternalOperationalSetting::FLOW_TYPE_PAY_LIST;
                $statusResponse='';
                $orderList_ASC_DESC=' DESC  ';
                $condition=' < ';
                $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
                $access_role_master=$resultsRefundInterOperSett->access_role_master;
                $access_role_child=$resultsRefundInterOperSett->access_role_child;
                $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;


                \backend\modules\repayment\models\RefundPaylistOperation::insertRefundPaylistOperation($refund_paylist_id, $refund_internal_operational_id, $previous_internal_operational_id, $access_role_master, $access_role_child, $status, $narration, $lastVerifiedBy, $dataVerified, $generalStatus);
            }
        }
        return $this->redirect(['view', 'id' => $id]);

    }
    public function actionConfirmSubmitapproval($id) {

        if($id !='') {
            $lastVerifiedBy = Yii::$app->user->identity->user_id;
            $dataVerified = date("Y-m-d H:i:s");
            $generalStatus = 1;
            $narration = 'Request for Approved';
            $refund_paylist_id = $id;
            $resultsV = \backend\modules\repayment\models\RefundPaylist::findOne($id);
            $current_level = $resultsV->current_level;
            $currentFlow_id = $current_level;
            \backend\modules\repayment\models\RefundPaylistOperation::updatePaylist($refund_paylist_id);
            $internalOperatSettV=\backend\modules\repayment\models\RefundInternalOperationalSetting::findOne($current_level);
            $current_flow_order_list=$internalOperatSettV->flow_order_list;
            $previous_internal_operational_id=$currentFlow_id;
            $status=\backend\modules\repayment\models\RefundPaylistOperation::Recommended_for_approval;
            $flow_type=\backend\modules\repayment\models\RefundInternalOperationalSetting::FLOW_TYPE_PAY_LIST;
            $statusResponse='';
            $orderList_ASC_DESC=' ASC  ';
            $condition=' > ';
            $resultsRefundInterOperSett=\backend\modules\repayment\models\RefundInternalOperationalSetting::getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition,$flow_type,$current_flow_order_list);
            $access_role_master=$resultsRefundInterOperSett->access_role_master;
            $access_role_child=$resultsRefundInterOperSett->access_role_child;
            $refund_internal_operational_id=$resultsRefundInterOperSett->refund_internal_operational_id;

            \backend\modules\repayment\models\RefundPaylistOperation::insertRefundPaylistOperation($refund_paylist_id, $refund_internal_operational_id, $previous_internal_operational_id, $access_role_master, $access_role_child, $status, $narration, $lastVerifiedBy, $dataVerified, $generalStatus);
        }
        return $this->redirect(['view', 'id' => $id]);

    }

    public function actionConfirmpayment() {
            if (Yii::$app->request->post()) {
                $request = Yii::$app->request->post();
                $cheque_number = $request['cheque_number'];
                $pay_description = $request['pay_description'];
                $refund_paylist_id = $request['refund_paylist_id'];
                $id=$refund_paylist_id;
                $updated_by=Yii::$app->user->identity->user_id;
                $updated_at=date("Y-m-d H:i:s");
                $resultsV = \backend\modules\repayment\models\RefundPaylist::findOne($refund_paylist_id);
                $resultsV->cheque_number=$cheque_number;
                $resultsV->pay_description=$pay_description;
                $resultsV->updated_by=$updated_by;
                $resultsV->updated_at=$updated_at;
                $resultsV->status=1;
                if($resultsV->save(false)){
    \backend\modules\repayment\models\RefundPaylist::updateAllPaidRefundApplication($refund_paylist_id);
                }
            }

        //return $this->redirect(['view', 'id' => $id]);
            return $this->redirect(['index']);

    }

}

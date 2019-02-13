<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\RefundApplicationOperation;
use backend\modules\repayment\models\RefundApplicationOperationSearch;
use yii\web\Controller;
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
                    $applicant_attachment->save();
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
                    $applicantAttachmentModel->save();
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
                    $vreificationFrameworkResults->save();
                    // here for logs
                    $new_data=\yii\helpers\Json::encode($vreificationFrameworkResults->attributes);
                    $model_logs=\common\models\base\Logs::CreateLogall($vreificationFrameworkResults->refund_application_id,$old_data,$new_data,"refund_application","UPDATE",1);
                    //end for logs
                }

                $vreificationFrameworkResultsAttemptedBy = \frontend\modules\repayment\models\RefundApplication::findOne(['refund_application_id'=>$id]);
                $userAttempted = Yii::$app->user->identity->user_id;
                $date_verified=$vreificationFrameworkResultsAttemptedBy->updated_at;
                $todate=date("Y-m-d");
                if(($vreificationFrameworkResultsAttemptedBy->updated_by != $userAttempted) && ($date_verified !=$todate)){
                    $userAttempted = Yii::$app->user->identity->user_id;
                    $vreificationFrameworkResultsAttemptedBy->updated_by=$userAttempted;
                    $vreificationFrameworkResultsAttemptedBy->updated_at=date("Y-m-d H:i:s");
                    // here for logs
                    $old_data=\yii\helpers\Json::encode($vreificationFrameworkResultsAttemptedBy->oldAttributes);
                    //end for logs
                    $vreificationFrameworkResultsAttemptedBy->save();
                    // here for logs
                    $new_data=\yii\helpers\Json::encode($vreificationFrameworkResultsAttemptedBy->attributes);
                    $model_logs=\common\models\base\Logs::CreateLogall($vreificationFrameworkResultsAttemptedBy->refund_application_id,$old_data,$new_data,"refund_application","UPDATE",1);
                    //end for logs
                }
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
        // return $this->redirect(['view','id' => $applicationId,'action' => 'view']);
        return $this->redirect(['view-refund','id' => $applicationId]);

    }
    public function actionCompleteref() {
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $current_status = 1;
        $dataProvider = $searchModel->searchVerification(Yii::$app->request->queryParams,$current_status);
        return $this->render('complete_refundapplications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}

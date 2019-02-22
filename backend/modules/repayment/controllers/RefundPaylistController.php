<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\RefundPaylist;
use backend\modules\repayment\models\RefundPaylistDetails;
use backend\modules\repayment\models\RefundPaylistSearch;
use yii\web\Controller;
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

        $searchModel = new RefundPaylistSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefundPaylist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $paylist_details_model = new \backend\modules\repayment\models\RefundPaylistDetails;
        $paylist_model->refund_paylist_id = $id;
        return $this->render('view', [
                    'model' => $model, 'paylist_details_model' => $paylist_details_model
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

}

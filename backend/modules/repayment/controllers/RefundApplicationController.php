<?php

namespace backend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\RefundApplication;
use frontend\modules\repayment\models\RefundApplicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RefundApplicationController implements the CRUD actions for RefundApplication model.
 */
class RefundApplicationController extends Controller
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
     * Lists all RefundApplication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefundApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefundApplication model.
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
     * Creates a new RefundApplication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RefundApplication();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->refund_application_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RefundApplication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->refund_application_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RefundApplication model.
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
     * Finds the RefundApplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefundApplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefundApplication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionWaitingLetter(){
        $loan_recovery_data_section_code=\backend\modules\repayment\models\RefundInternalOperationalSetting::loan_recovery_data_section_c;
        $currentResonse1=\backend\modules\repayment\models\RefundInternalOperationalSetting::findBySql("SELECT * FROM refund_internal_operational_setting WHERE code='$loan_recovery_data_section_code'")->one();
        $currentLevel=$currentResonse1->refund_internal_operational_id;
        //$searchModel = new \backend\modules\repayment\models\RefundApplicationOperationSearch();
$Temporary_stop_Deduction_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Temporary_stop_Deduction_letter;
$Permanent_stop_deduction_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Permanent_stop_deduction_letter;
$Issue_denial_letter=\backend\modules\repayment\models\RefundVerificationResponseSetting::Issue_denial_letter;
        $groupCode='"'.$Temporary_stop_Deduction_letter.'"'.",".'"'.$Permanent_stop_deduction_letter.'"'.",".'"'.$Issue_denial_letter.'"';
        $codeResponseID1=\backend\modules\repayment\models\RefundVerificationResponseSetting::getRefundVerificationResponseSettingByCodeConcat($groupCode);
        $codeResponseID=[$codeResponseID1];
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $dataProvider = $searchModel->searchVerifiedRefundWaitingLetter(Yii::$app->request->queryParams,$currentLevel,$codeResponseID);
        return $this->render('waitingLetter', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPayList(){
        $loan_recovery_data_section_code=\backend\modules\repayment\models\RefundInternalOperationalSetting::loan_recovery_data_section_c;
        $currentResonse1=\backend\modules\repayment\models\RefundInternalOperationalSetting::findBySql("SELECT * FROM refund_internal_operational_setting WHERE code='$loan_recovery_data_section_code'")->one();
        $currentLevel=$currentResonse1->refund_internal_operational_id;
        //$searchModel = new \backend\modules\repayment\models\RefundApplicationOperationSearch();
        $PAY_LIST_WAITING_QUEUE=\frontend\modules\repayment\models\RefundApplication::PAY_LIST_WAITING_QUEUE;
        $PayListStatus=$PAY_LIST_WAITING_QUEUE;
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $dataProvider = $searchModel->searchVerifiedRefundWaitingPayment(Yii::$app->request->queryParams,$currentLevel,$PayListStatus);
        return $this->render('payList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPaidApplication(){
        $loan_recovery_data_section_code=\backend\modules\repayment\models\RefundInternalOperationalSetting::loan_recovery_data_section_c;
        $currentResonse1=\backend\modules\repayment\models\RefundInternalOperationalSetting::findBySql("SELECT * FROM refund_internal_operational_setting WHERE code='$loan_recovery_data_section_code'")->one();
        $currentLevel=$currentResonse1->refund_internal_operational_id;
        //$searchModel = new \backend\modules\repayment\models\RefundApplicationOperationSearch();
        $PAID_APPLICATION=\frontend\modules\repayment\models\RefundApplication::PAID_APPLICATION;
        $PayListStatus=$PAID_APPLICATION;
        $searchModel = new \frontend\modules\repayment\models\RefundApplicationSearch();
        $dataProvider = $searchModel->searchVerifiedRefundPaid(Yii::$app->request->queryParams,$PayListStatus);
        return $this->render('paidApplication', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}

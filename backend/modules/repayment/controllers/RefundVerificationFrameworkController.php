<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\RefundVerificationFramework;
use backend\modules\repayment\models\RefundVerificationFrameworkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RefundVerificationFrameworkController implements the CRUD actions for RefundVerificationFramework model.
 */
class RefundVerificationFrameworkController extends Controller
{
    public function behaviors()
    {
        $this->layout="main_private";
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','confirm-framework','upload-support-document', 'view', 'create', 'update', 'delete', 'save-as-new', 'add-refund-application', 'add-refund-verification-framework-item'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all RefundVerificationFramework models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefundVerificationFrameworkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefundVerificationFramework model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerRefundApplication = new \yii\data\ArrayDataProvider([
            'allModels' => $model->refundApplications,
        ]);
        $providerRefundVerificationFrameworkItem = new \yii\data\ArrayDataProvider([
            'allModels' => $model->refundVerificationFrameworkItems,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerRefundApplication' => $providerRefundApplication,
            'providerRefundVerificationFrameworkItem' => $providerRefundVerificationFrameworkItem,
        ]);
    }

    /**
     * Creates a new RefundVerificationFramework model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RefundVerificationFramework();
        $model->scenario='frameworkRegister';
        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->refund_verification_framework_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RefundVerificationFramework model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->request->post('_asnew') == '1') {
            $model = new RefundVerificationFramework();
        }else{
            $model = $this->findModel($id);
        }
		$model->scenario='frameworkUpdate';

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->refund_verification_framework_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RefundVerificationFramework model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    /**
    * Creates a new RefundVerificationFramework model by another data,
    * so user don't need to input all field from scratch.
    * If creation is successful, the browser will be redirected to the 'view' page.
    *
    * @param mixed $id
    * @return mixed
    */
    public function actionSaveAsNew($id) {
        $model = new RefundVerificationFramework();

        if (Yii::$app->request->post('_asnew') != '1') {
            $model = $this->findModel($id);
        }
    
        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['update', 'id' => $model->refund_verification_framework_id]);
        } else {
            return $this->render('saveAsNew', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Finds the RefundVerificationFramework model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefundVerificationFramework the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefundVerificationFramework::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for RefundApplication
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddRefundApplication()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('RefundApplication');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formRefundApplication', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for RefundVerificationFrameworkItem
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddRefundVerificationFrameworkItem()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('RefundVerificationFrameworkItem');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formRefundVerificationFrameworkItem', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionUploadSupportDocument($id)
    {
        if (Yii::$app->request->post('_asnew') == '1') {
            $model = new RefundVerificationFramework();
        }else{
            $model = $this->findModel($id);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->support_document= UploadedFile::getInstance($model, 'support_document');
               if ($model->support_document != "") {
                unlink($model->OldAttributes['support_document']);
                $model->support_document->saveAs('../attachments/repayment/support_' . $model->refund_verification_framework_id . '_' . date("Y") . '.' . $model->support_document->extension);
                $model->support_document = 'attachments/repayment/support_' . $model->refund_verification_framework_id . '_' . date("Y") . '.' . $model->support_document->extension;
            }
          $model->save();
            return $this->redirect(['view', 'id' => $model->refund_verification_framework_id]);
        } else {
            return $this->render('upload_support_document', [
                'model' => $model,
            ]);
        }
    }
    public function actionConfirmFramework($id)
    {
        
            $model = $this->findModel($id);
                $model->confirmed_at=date("Y-m-d H:i:s");
                $model->confirmed_by=Yii::$app->user->identity->user_id;
            $model->save(false);
            
            return $this->redirect(['view', 'id' => $model->refund_verification_framework_id]);
        
    }
}

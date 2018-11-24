<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\VerificationFramework;
use backend\modules\application\models\VerificationFrameworkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VerificationFrameworkController implements the CRUD actions for VerificationFramework model.
 */
class VerificationFrameworkController extends Controller
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
     * Lists all VerificationFramework models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VerificationFrameworkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VerificationFramework model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $active = '';
        if (\Yii::$app->session['active_tab']) {
            $active = \Yii::$app->session['active_tab'];
        }
        if ($model) {
        $searchModelVerifItems = new VerificationFrameworkSearch();    
        $model_verification_items = \backend\modules\application\models\VerificationFrameworkItem::getVerificationItemById($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_verification_items'=>$model_verification_items,'searchModelVerifItems'=>$searchModelVerifItems
        ]);
    }
    }

    /**
     * Creates a new VerificationFramework model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VerificationFramework();
        $model->created_by=Yii::$app->user->identity->user_id;
        $model->created_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $sms="<p>Information successful added</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VerificationFramework model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //$model->created_by=Yii::$app->user->identity->user_id;
            //$model->created_at=date("Y-m-d H:i:s");
            $sms="<p>Information successful updated</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            $model->confirmed_by=Yii::$app->user->identity->user_id;
            $model->confirmed_at=date("Y-m-d H:i:s");
            if($model->verification_framework_stage==1){
                $model->is_active=1;
            if($model->save()) {
            $sms="<p>Information successful confirmed</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
            }
            }
        } else {
            return $this->render('confirm', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VerificationFramework model.
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
     * Finds the VerificationFramework model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VerificationFramework the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VerificationFramework::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionAddVerificationItems($id) {
        \Yii::$app->session['active_tab'] = 'atab1';
        $model = $this->findModel($id);
        $verification_item = New \backend\modules\application\models\VerificationFrameworkItem();
        $verification_item->verification_framework_id = $model->verification_framework_id;
        if (Yii::$app->request->post('VerificationFrameworkItem')) {
            $verification_item->attributes = Yii::$app->request->post('VerificationFrameworkItem');

            if ($verification_item->verification_framework_id == $id) {
                try {
                $attachment_item = \backend\modules\application\models\AttachmentDefinition::findOne(['attachment_definition_id'=>$verification_item->attachment_definition_id]);
        $verification_item->attachment_desc =$attachment_item->attachment_desc;
        $verification_item->created_at=date("Y-m-d H:i:s"); 
        $verification_item->created_by =Yii::$app->user->identity->user_id;
            
                    if ($verification_item->save()) {
                       
            $sms ="Information Successful Added";                       
            Yii::$app->getSession()->setFlash('success', $sms);
                        return $this->redirect(['view', 'id' => $id]);
                    }
                    /*
                    else{
                        var_dump($gender_item->errors);
                    }
                     * 
                     */
                } catch (yii\db\Exception $exception) {
                    if ($exception !== null) {
                        return $this->render('error', ['exception' => $exception]);
                    }
                }
            }
        }
        return $this->render('addVerificationItem', [
                    'model' => $model, 'verification_item' => $verification_item,'verification_framework_id'=>$id,
        ]);
    }
    public function actionDeleteVerificationItem($id)
    {
        $verification_item = \backend\modules\application\models\VerificationFrameworkItem::findOne(['verification_framework_item_id'=>$id]);
        $verification_framework_id=$verification_item->verification_framework_id;        
        $verification_item->delete();
        return $this->redirect(['view', 'id' => $verification_framework_id]);
    }
}

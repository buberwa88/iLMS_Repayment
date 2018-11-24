<?php

namespace frontend\modules\appeal\controllers;
use Yii;

use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use frontend\modules\appeal\models\Complaint;
use frontend\modules\appeal\models\ComplaintDepartmentMovement;
use frontend\modules\appeal\helpers\ComplaintHelper;

class ComplaintsController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $this->layout="main_public_beneficiary";
        
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
     * Creates a new Complaint model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Complaint();
        
        $authUserId = Yii::$app->user->identity->user_id;

        $status = ComplaintHelper::decodeStatusFromValue("submited");
        
        $complaint = Yii::$app->request->post();        
        $complaint['Complaint']['level'] = 1;
        $complaint['Complaint']['created_by'] = $authUserId;
        $complaint['Complaint']['applicant_id'] = $authUserId;
        $complaint['Complaint']['status'] = $status;
        $complaint['Complaint']['level'] = 0;
        $complaint['Complaint']['updated_by'] = $authUserId;

        if ($model->load($complaint) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->complaint_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionForwardHeslb($id){

        $complaint = Complaint::findOne($id);
   
        $complaint->level = 1;
        
        $complaint->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing Complaint model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if($model->level == 0){
            $model->delete();
            return $this->redirect(['index']);
        }

        return $this->redirect(['view', 'id'=>$model->complaint_id]);
    }

    /**
     * Updates an existing Complaint model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->level == 0){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->complaint_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        return $this->redirect(['view', 'id' => $model->complaint_id]);
    }


    public function actionIndex()
    {
        $cTable = Complaint::tableName();
        $authUserId = Yii::$app->user->identity->user_id;


        $complaints  = Complaint::find()->where(['created_by'=>$authUserId])->orderBy([
            $cTable.'.complaint_id' => SORT_DESC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $complaints
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

        /**
     * Displays a single Complaint model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $movement = ComplaintDepartmentMovement::find()->where('complaint_id=:id', [':id'=>$id]);
        

        //print_r($movement);
        //exit;

        $dataProvider = new ActiveDataProvider([
            'query' => $movement
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'movement' => $dataProvider
        ]);
    }

    /**
     * Finds the Complaint model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Complaint the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Complaint::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

<?php

namespace frontend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AdmissionBatch;
use backend\modules\allocation\models\AdmissionBatchSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;

/**
 * AdmissionBatchController implements the CRUD actions for AdmissionBatch model.
 */
class AdmissionBatchController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $this->layout = "main_tcu_public";
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'deleteTcu' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AdmissionBatch models.
     * @return mixed
     */
    public function actionIndexTcu() {
        $searchModel = new AdmissionBatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdmissionBatch model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewTcu($id) {
        return $this->render('profile', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdmissionBatch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateTcu() {
        $model = new AdmissionBatch();

        if ($model->load(Yii::$app->request->post())) {
              if ($model->file) {
                  $model->save();
                 }
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            //if($model->t!=""){
            $model->file->saveAs('upload/' . $model->file->name);
            $model->file = 'upload/' . $model->file->name;
            $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import',
                        'fileName' => $model->file,
                        'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                        'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                            //'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
            ]);
            if (count($data) > 0) {
                   foreach ($data as $data12=>$datas12){
                foreach ($datas12 as $label => $key) {
                    ///print_r($label);
                   if ($label == "F4 INDEX NUMBER") {
                        $check+=0;
                    } else if ($label == "LAST NAME") {
                        $check+=0;
                    } else if ($label == "FIRST NAME") {
                        $check+=0;
                    } else if ($label == "MIDDLE NAME") {
                        $check+=0;
                    } else if ($label == "GENDER") {
                        $check+=0;
                    } else if ($label == "F6 INDEX NUMBER") {
                        $check+=0;
                    } else if ($label == "POINTS") {
                        $check+=0;
                    } else if ($label == "COURSE CODE") {
                        $check+=0;
                    } else if ($label == "INST CODE") {
                        $check+=0;
                    } else if ($label == "COURSE STATUS") {
                        $check+=0;
                    } else if ($label == "ENTRY") {
                        $check+=0;
                    } else {
                        if ($label != "") {
                            $check+=1;
                        }
                    }
                }
                //insert data 
                $modelall=new \backend\modules\allocation\models\AdmittedStudent();
                $modelall->save();
                //end
              }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdmissionBatch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateTcu($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdmissionBatch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteTcu($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdmissionBatch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdmissionBatch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AdmissionBatch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

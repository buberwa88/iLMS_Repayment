<?php

namespace backend\modules\disbursement\controllers;

use Yii;
use backend\modules\disbursement\models\DisbursementBatch;
use backend\modules\disbursement\models\DisbursementBatchSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;

/**
 * DisbursementBatchController implements the CRUD actions for DisbursementBatch model.
 */
class DisbursementBatchController extends Controller {

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
     * Lists all DisbursementBatch models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new DisbursementBatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DisbursementBatch model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        return $this->render('profile', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DisbursementBatch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        ini_set('max_execution_time', 3000000);
        ini_set('memory_limit', '16000000000M');

        $model = new DisbursementBatch();

        if ($model->load(Yii::$app->request->post())) {
            //check the information
//              print_r($model->load(Yii::$app->request->post()));
//              $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
//              print_r($model);
//                echo "<br/> mickidadi";
//                       exit();
            $studentlist = new DisbursementBatch();
            //get loan Item dependant data
            $allloanItem = Yii::$app->db->createCommand("SELECT group_concat(`associated_loan_item_id`) as loan_item FROM `disbursement_setting2` WHERE loan_item_id='{$model->loan_item_id}' AND academic_year_id='{$model->academic_year_id}' group by `loan_item_id`")->queryAll();
            foreach ($allloanItem as $allloanItems)
                ;
            $allloan_Item = $model->loan_item_id . ',' . $allloanItems["loan_item"];
            //end 
            if ($model->disburse == 2) {
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
                foreach ($data as $rows) {

                    $selectivedata[] = $rows['INDEXNO'];
                }

                $selectivedata1 = join("', '", $selectivedata);

                $studentdata = $studentlist->getStudentselective($model->learning_institution_id, $model->level, $model->academic_year_id, $allloan_Item, $model->instalment_definition_id, $selectivedata1);
            } else {
                $studentdata = $studentlist->getStudents($model->learning_institution_id, $model->level, $model->academic_year_id, $allloan_Item, $model->instalment_definition_id);
                //print_r($studentdata);
            }
            if (count($studentdata)>0) {

                $totalfailed = $total = 0;
                foreach ($studentdata as $studentdatas) {

                    //create disbursement
                    //$testdata = \backend\modules\disbursement\models\Disbursement::findAll(["application_id" => $studentdatas["application_id"], "loan_item_id" => $model->loan_item_id, "version" => $model->version]);
                    $testdata = $studentlist->getDisbursementstatus($model->learning_institution_id, $model->academic_year_id, $studentdatas["loan_item_id"], $studentdatas["application_id"], $model->version, $model->instalment_definition_id);
                    if (count($testdata) == 0) {
                        if ($total == 0) {
                            $model->save();
                        }
                        /*
                         * check disbursement before disbursed amount for Item
                         */
                        $createdisbursement = new \backend\modules\disbursement\models\Disbursement();
                        $createdisbursement->disbursement_batch_id = $model->disbursement_batch_id;
                        $createdisbursement->application_id = $studentdatas["application_id"];
                        $createdisbursement->programme_id = $studentdatas["programme_id"];
                        $createdisbursement->loan_item_id = $studentdatas["loan_item_id"];
                        $createdisbursement->version = $model->version == "" ? 0 : $model->version;
                        $createdisbursement->disbursed_amount = $studentdatas["amount"];
                        $createdisbursement->disbursed_as = $model->disbursed_as;
                        $createdisbursement->status = 1;
                        $createdisbursement->created_at = date("Y-m-d h:i:s");
                        $createdisbursement->created_by = \yii::$app->user->identity->user_id;
                        $createdisbursement->save();
                        //end create

                        $total++;
                    } else {
                        $totalfailed++;
                    }
                }
                Yii::$app->getSession()->setFlash(
                        'success', 'Data Successfully Created! ' . $total . " Unsuccessfuly " . $totalfailed
                );
            } else {
                Yii::$app->getSession()->setFlash(
                        'info', 'Empty Disbursement!'
                );
            }
            //  exit();
            //end

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DisbursementBatch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->disbursement_batch_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DisbursementBatch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        \backend\modules\disbursement\models\Disbursement::deleteAll(['disbursement_batch_id' => $id]);
        $this->findModel($id)->delete();
        //delete all disbursement made on that batch /Header Id
        \backend\modules\disbursement\models\Disbursement::deleteAll(['disbursement_batch_id' => $id]);
        //end
        return $this->redirect(['index']);
    }

    /**
     * Finds the Disburs ementBatch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DisbursementBatch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = DisbursementBatch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionOfficersubmit($id) {

        $model = new \backend\modules\disbursement\models\PayoutlistMovement();

        if ($model->load(Yii::$app->request->post())) {
            //find data
            //find the title of user 
            //$modeltitle= \backend\modules\disbursement\models\base\DisbursementUserStructure::findOne(['user_id'=>$model->to_officer]);
            // $model->to_officer=$modeltitle->disbursement_user_structure_id;
            $model->save();
            $models = DisbursementBatch::findone($model->disbursements_batch_id);
            $models->is_approved = 1;
            $models->save();
            //end 
            return $this->redirect(['view', 'id' => $model->disbursements_batch_id]);
        } else {
            return $this->render('../payoutlist-movement/create', [
                        'model' => $model,
                        'disbursementId' => $id,
            ]);
        }
    }

    public function actionExecutiveDirector($id) {

        $model = new \backend\modules\disbursement\models\PayoutlistMovement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->disbursements_batch_id]);
        } else {
            return $this->render('../payoutlist-movement/create', [
                        'model' => $model,
                        'disbursementId' => $id,
            ]);
        }
    }

    public function actionReviewDisbursement() {

        $searchModel = new DisbursementBatchSearch();
        $dataProvider = $searchModel->searchreviewdisbursement(Yii::$app->request->queryParams);

        return $this->render('review_disbursement', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionManagerLoanDisbursement($id) {

        $model = new \backend\modules\disbursement\models\PayoutlistMovement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->disbursements_batch_id]);
        } else {
            return $this->render('../payoutlist-movement/create', [
                        'model' => $model,
                        'disbursementId' => $id,
            ]);
        }
    }

    public function actionDirectorDisbursement($id) {

        $model = new \backend\modules\disbursement\models\PayoutlistMovement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->disbursements_batch_id]);
        } else {
            return $this->render('../payoutlist-movement/create', [
                        'model' => $model,
                        'disbursementId' => $id,
            ]);
        }
    }

    public function actionAssistanceDisbursement($id) {

        $model = new \backend\modules\disbursement\models\PayoutlistMovement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->disbursements_batch_id]);
        } else {
            return $this->render('../payoutlist-movement/create', [
                        'model' => $model,
                        'disbursementId' => $id,
            ]);
        }
    }

    public function actionViewreviewb($id) {

        return $this->render('view-review-disbursement', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionReviewallDisbursement() {

        $searchModel = new DisbursementBatchSearch();
        $dataProvider = $searchModel->searchreviewdisbursement(Yii::$app->request->queryParams);

        return $this->render('reviewall_disbursement', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewreviewall($id) {

        return $this->render('view-reviewall-disbursement', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionDisbursementVerify($id, $status) {

        $model = new \backend\modules\disbursement\models\PayoutlistMovement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //find data
            $models = DisbursementBatch::findone($model->disbursements_batch_id);
            $models->is_approved = $status;
            $models->save();
            //end 
            return $this->redirect(['viewreviewb', 'id' => $model->disbursements_batch_id]);
        } else {
            if ($status == 0) {
                return $this->render('../payoutlist-movement/create1', [
                            'model' => $model,
                            'disbursementId' => $id,
                ]);
            } else {
                return $this->render('../payoutlist-movement/create', [
                            'model' => $model,
                            'disbursementId' => $id,
                ]);
            }
        }
    }

    public function actionReviewDecision($id, $level) {
        $model = new \backend\modules\disbursement\models\PayoutlistMovement();

        if ($model->load(Yii::$app->request->post())) {
            //find data
            //update movement status
            Yii::$app->db->createCommand("Update `disbursement_payoutlist_movement` set movement_status=1 WHERE   disbursements_batch_id='{$model->disbursements_batch_id}'")->execute();
            //end update movement
            //find the title of user 
            // $modeltitle= \backend\modules\disbursement\models\base\DisbursementUserStructure::findOne(['user_id'=>$model->to_officer]);
            //end 
              if($model->to_officer== $model->from_officer){
           $model->movement_status=1;       
              }
            $model->date_out = date("Y-m-d");
            $model->to_officer = $model->to_officer;
            $model->save();
            /* $models=  DisbursementBatch::findone($model->disbursements_batch_id);
              //$models
              //$models->is_approved=1;
              $models->save(); */
            //end 
            return $this->redirect(['reviewall-disbursement', 'id' => $model->disbursements_batch_id]);
        } else {
            return $this->render('../payoutlist-movement/createall', [
                        'model' => $model,
                        'disbursementId' => $id,
                        'level' => $level,
            ]);
        }
    }

}

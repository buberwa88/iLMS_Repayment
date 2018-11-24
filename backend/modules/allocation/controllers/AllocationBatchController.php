<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AllocationBatch;
use backend\modules\allocation\models\AllocationBatchSearch;
use backend\modules\allocation\models\Allocation;
use backend\modules\allocation\models\AllocationBatchHistory;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;

/**
 * AllocationBatchController implements the CRUD actions for AllocationBatch model.
 */
class AllocationBatchController extends Controller {

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
     * Lists all AllocationBatch models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new AllocationBatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationBatch model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        return $this->render('profile', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AllocationBatch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $max_data_processing = 1000;
        $start_record = 0;
        $model = new AllocationBatch();
        $modelh = new AllocationBatchHistory();
        if ($model->load(Yii::$app->request->post())&& $modelh->load(Yii::$app->request->post())) {
            ##############allocation batch generation ###################

            $model->save();
                //create batch number 
                $modelbatch=  AllocationBatch::find()->orderBy('batch_number DESC')->where("academic_year_id=$model->academic_year_id AND allocation_batch_id<=$model->allocation_batch_id")->one();
                 if(count($modelbatch)>0){
                       
                         $modelbatch_number=1+$modelbatch->batch_number;
                 }
                 else{
                     $modelbatch_number=1;
                 }
                $modelupdate=  AllocationBatch::findone($model->allocation_batch_id);
                  $modelupdate->batch_number=$modelbatch_number;
                  $modelupdate->batch_desc=$modelupdate->academicYear->academic_year.'-BATCH-'.$modelbatch_number;
                $modelupdate->save();
                //end create batch number
            if (count($modelh) > 0) {
                foreach ($modelh->allocation_history_id as $modelhs => $value) {
                    $modelh1 = new AllocationBatchHistory();
                    $modelh1->allocation_batch_id = $model->allocation_batch_id;
                    $modelh1->allocation_history_id = $value;
                    $modelh1->save();
                }
            }
            #####################put student in a allocation batch ###############
            $allocation_history_id = implode(',', $modelh->allocation_history_id);
            ##################count applicant data ######################################
            $model_student_batch_count = AllocationBatch::countAllocationStudentHistory($allocation_history_id, $model->academic_year_id);
            ####################end count ##########################
            if ($model_student_batch_count > $max_data_processing) {
                $index_max_limit = ceil(($model_student_batch_count / $max_data_processing));
                $start_record = 0;
                $end_record = $max_data_processing;
            } else {
                $index_max_limit = 1;
                $start_record = 0;
                $end_record = $model_count;
            }
            for ($i = 1; $i <= $index_max_limit; $i++) {
                $model_student_batch = AllocationBatch::putAllocationStudentHistoryBatch($allocation_history_id, $model->academic_year_id,$start_record,$end_record);
                 if(count($model_student_batch)>0){
                foreach ($model_student_batch as $model_student_batchs) {
                    $model_allocation = new Allocation();
                    $model_allocation->allocation_batch_id = $model->allocation_batch_id;
                    $model_allocation->application_id = $model_student_batchs["application_id"];
                    $model_allocation->loan_item_id = $model_student_batchs["loan_item_id"];
                    $model_allocation->allocated_amount = $model_student_batchs["total_amount_awarded"];
                    $model_allocation->save();
                }
              
              $start_record=$end_record+1;
              $end_record=$end_record+$max_data_processing;
               }
            ######################## End process @@@@############################
            }
            ##################### end ###################################
            return $this->redirect(['view', 'id' => $model->allocation_batch_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelh' => $modelh,
            ]);
        }
    }

//    public function actionCreate() {
//en
//        $model = new AllocationBatch();
//
//        if ($model->load(Yii::$app->request->post())) {
//            /* get list of student with status 0f 6 and neednes is
//             *  equal of greater than min loan amount
//             */
//            $loan_min = \backend\models\SystemSetting::findOne(["is_active" => 1, 'setting_code' => 'MLA']);
//            /*
//             * check if new application 
//             */
//            if ($model->contained_student == 1) {
//                if (count($loan_min) > 0) {
//                    $totalbudget = 0;
//                    $totalbudget = $model->available_budget;
//                    //find the allocation priority
////                $academic_year = 0;
////                $modelacademicyear = \common\models\AcademicYear::findOne(['is_current' => 1]);
////                if (count($modelacademicyear) > 0) {
////                    $academic_year = $modelacademicyear->academic_year;
////                }
////                $model_allocationpriority = \backend\modules\allocation\models\base\AllocationPriority::find()->joinWith("sourceTable")->where(['academic_year_id' =>$model->academic_year_id])->orderBy(['priority_order' => SORT_ASC])->all();
////              //  print_r($model_allocationpriority);
//                    $model_allocationpriority = Yii::$app->db->createCommand("SELECT * FROM `allocation_priority` ap join `source_table` st on `source_table`=`source_table_id` WHERE academic_year_id ='{$model->academic_year_id}'")->queryAll();
//                    foreach ($model_allocationpriority as $rows) {
//                        /*
//                         * source of data criteria question
//                         */
//                        $sql_sub = " " . $rows["source_table_id_field"] . "=" . $rows["field_value"];
//                        // echo "SELECT * FROM `application` a join `applicant_criteria_score` ac on a.`application_id`=ac.`application_id` join criteria_question cq on ac.`criteria_question_id`=cq.`criteria_question_id` join cluster_programme cp on cp.`programme_id`=a.`programme_id` WHERE  $sql_sub order by ability";
//                        $sqlall = Yii::$app->db->createCommand("SELECT * FROM `application` a join `applicant_criteria_score` ac on a.`application_id`=ac.`application_id` join criteria_question cq on ac.`criteria_question_id`=cq.`criteria_question_id` join cluster_programme cp on cp.`programme_id`=a.`programme_id` WHERE  $sql_sub order by ability")->queryAll();
//                        //end
//                        /*
//                         * end
//                         * source of data criteria field
//                         */
//                        echo "SELECT * FROM `application` a join `applicant_criteria_score` ac on a.`application_id`=ac.`application_id` join criteria_field cf on ac.`criteria_field_id`=cf.`criteria_field_id` join cluster_programme cp on cp.`programme_id`=a.`programme_id` WHERE $sql_sub order by ability";
//                        $sqlall2 = Yii::$app->db->createCommand("SELECT * FROM `application` a join `applicant_criteria_score` ac on a.`application_id`=ac.`application_id` join criteria_field cf on ac.`criteria_field_id`=cf.`criteria_field_id` join cluster_programme cp on cp.`programme_id`=a.`programme_id` WHERE $sql_sub order by ability")->queryAll();
//                        /*
//                         * end
//                         */
//                    }
//                    //exit();
//                    if (count($model_allocationpriority) > 0) {
//                        //get 
//                        $sql = " SELECT * FROM `application` a join  cluster_programme cp    on a.`programme_id`=cp.`programme_id` WHERE allocation_status=5 AND needness>='{$loan_min->setting_value}' order by ability ";
//                        $sqldata = Yii::$app->db->createCommand($sql)->queryAll();
//
//                        $modelall = \backend\modules\application\models\Application::find()->where("allocation_status=5 AND needness>='{$loan_min->setting_value}'")->orderBy(['ability' => SORT_DESC])->asArray()->all();
//                        // print_r($modelall);
//                    } else {
//                        /* allocation process normally
//                         * user neednesd to allocate loan
//                         */
//
//                        /*
//                         * end allocation process
//                         */
//                    }
//                    $loan_mins = $loan_min->setting_value;
//                    if (count($modelall) > 0) {
//                        foreach ($modelall as $rows) {
//                            $needness = $rows["needness"];
//                            if ($needness >= $loan_mins && $totalbudget >= $needness) {
//                                $status = 3;
//                            } else {
//                                $status = 4;
//                            }
//                        }
//                    }
//                }
//            } else {
//                ///award loan for Loanee student or continou student 
//                //
//
//                //end              
//            }
//            // return $this->redirect(['view', 'id' => $model->allocation_batch_id]);
//        } else {
//            return $this->render('create', [
//                        'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing AllocationBatch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->allocation_batch_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AllocationBatch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AllocationBatch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AllocationBatch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AllocationBatch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAwardLoan() {

        return $this->render('profileaward', [
                    'model' => \common\models\AcademicYear::findOne(['is_current' => 1]),
        ]);
    }

    public function actionAwardLoanfresher($status) {

        $model = new AllocationBatch();

        // if ($model->load(Yii::$app->request->post())) {
        /* get list of student with status 0f 6 and neednes is
         *  equal of greater than min loan amount
         */
        $loan_min = \backend\models\SystemSetting::findOne(["is_active" => 1, 'setting_code' => 'MLA']);
        /*
         * check if new application 
         */
        $totalbudget = 0;
        if ($status == 1) {
            if (count($loan_min) > 0) {

                $totalbudget = 60000000;
                //find the allocation priority
                $academic_year = 0;
                $modelacademicyear = \common\models\AcademicYear::findOne(['is_current' => 1]);
                if (count($modelacademicyear) > 0) {
                    $academic_year = $modelacademicyear->academic_year;
                }

                /*
                 * check allocation priority
                 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                 */
                $model_allocationpriority = Yii::$app->db->createCommand("SELECT * FROM `allocation_priority` ap "
                                . " join `source_table` st "
                                . " on `source_table`=`source_table_id` "
                                . " WHERE academic_year_id ='{$academic_year}'")->queryAll();
                if (count($model_allocationpriority) > 0) {
                    foreach ($model_allocationpriority as $rows) {
                        /*
                         * source of data criteria question
                         * Find application order by ability 
                         *  $arrayapplication=array();
                         * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                         */
                        $baseline = $rows['baseline'];
                        $sql_sub = " " . $rows["source_table_id_field"] . "=" . $rows["field_value"];

                        $sqlall = Yii::$app->db->createCommand("SELECT * FROM `application` a "
                                        . " join `applicant_criteria_score` ac "
                                        . " on a.`application_id`=ac.`application_id` "
                                        . " join criteria_question cq "
                                        . " on ac.`criteria_question_id`=cq.`criteria_question_id` "
                                        . " join cluster_programme cp "
                                        . "  on cp.`programme_id`=a.`programme_id` "
                                        . " WHERE  $sql_sub AND allocation_status=6 order by ability")->queryAll();
                        if (count($sqlall) > 0) {
                            foreach ($sqlall as $rowsdata) {
                                $applicationId = $rowsdata["application_id"];
                                $needness_amount = $rowsdata["needness"];
                                /* item needness
                                 * @@@@@@@@@@@ 
                                 * application_id  loan_item_id  allocated_amount
                                 * Find loan Item  associate with application programme and year of study
                                 * check loan item ordering
                                 */

                                if ($totalbudget >= $needness_amount) {
                                    $academic_year = 1;
                                    $yos = 2;
                                    $programme = 4;
                                    $totalbudget = $this->allocateLoan($applicationId, $needness_amount, $totalbudget, $academic_year, $yos, $programme);
                                } else {
                                    echo "Budget imeisha my friend";
                                }
                            }
                        }

                        //end
                        /*
                         * end
                         * source of data criteria field
                         */
                        // echo "SELECT * FROM `application` a join `applicant_criteria_score` ac on a.`application_id`=ac.`application_id` join criteria_field cf on ac.`criteria_field_id`=cf.`criteria_field_id` join cluster_programme cp on cp.`programme_id`=a.`programme_id` WHERE $sql_sub order by ability";

                        $sqlall2 = Yii::$app->db->createCommand("SELECT * FROM `application` a "
                                        . " join `applicant_criteria_score` ac "
                                        . " on a.`application_id`=ac.`application_id` "
                                        . " join criteria_field cf "
                                        . " on ac.`criteria_field_id`=cf.`criteria_field_id` "
                                        . " join cluster_programme cp "
                                        . " on cp.`programme_id`=a.`programme_id` "
                                        . " WHERE $sql_sub AND allocation_status=6 order by ability")->queryAll();
                        /*
                         * end
                         */
                        if (count($sqlall2) > 0) {
                            foreach ($sqlall2 as $rowsdata2) {
                                $applicationId2 = $rowsdata2["application_id"];
                                $needness_amount2 = $rowsdata2["needness"];
                                /* item needness
                                 * @@@@@@@@@@@ mickidadimsoka@gmail.com
                                 * application_id  loan_item_id  allocated_amount
                                 * Find loan Item  associate with application programme and year of study
                                 * check loan item ordering
                                 */

                                if ($totalbudget >= $needness_amount2) {
                                    $academic_year = 1;
                                    $yos = 2;
                                    $programme = 4;
                                    $totalbudget = $this->allocateLoan($applicationId2, $needness_amount2, $totalbudget, $academic_year, $yos, $programme);
                                } else {
                                    echo "Budget imeisha my friend";
                                }
                            }
                        }
                    }
                } else {
                    /*
                     * allocate normal base on ability of applicant
                     * mickidadimsoka@gmail.com
                     * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                     */
                }
            }
        }
        return $this->redirect(['award-loan']);
    }

    function allocateLoan($applicationId, $needness_amount, $totalbudget, $academic_year, $yos, $programme) {
        $sql_sub = Yii::$app->db->createCommand("SELECT * FROM `programme_fee` pf join loan_item li "
                        . "  on pf.`loan_item_id`=li.`loan_item_id` "
                        . "  join loan_item_priority lp on lp.`loan_item_id`=li.`loan_item_id` "
                        . "  WHERE pf.`academic_year_id`='{$academic_year}' "
                        . "  AND  `programme_id`='{$programme}' "
                        . "  AND `year_of_study`='{$yos}' order by priority_order")->queryAll();
        //  $arrayapplication[$rowsdata["application_id"]]=array();
        if (count($sql_sub) > 0) {
            /*
             * Award loan Item to application 
             * @@@@@@@@@@@@@@@@@@@@@@@@@@@@
             */
//            echo "SELECT * FROM `programme_fee` pf join loan_item li "
//                                                    . "  on pf.`loan_item_id`=li.`loan_item_id` "
//                                                    . "  join loan_item_priority lp on lp.`loan_item_id`=li.`loan_item_id` "
//                                                    . "  WHERE pf.`academic_year_id`='{$academic_year}' "
//                                                    . "  AND  `programme_id`='{$programme}' "
//                                                    . "  AND `year_of_study`='{$yos}' order by priority_order";

            $subtotal = 0;
            echo $needness_amount;
            echo "<br/>";
            foreach ($sql_sub as $subrow) {

                $fee_days = $subrow["days"] == NULL ? 1 : $subrow["days"];
                echo $amount = $subrow["amount"] * $fee_days;
                /*
                 * check loan item amount Vs needness amount
                 */
                if ($needness_amount > 0) {
                    //$balance = $needness_amount - $amount;
                    //echo  $amounttotal = $balance >= 0 ? $amount : $needness_amount;
                    if ($needness_amount >= $amount) {
                        $amounttotal = $amount;
                    } else if ($needness_amount < $amount && $needness_amount > 0) {
                        $amounttotal = $needness_amount;
                    }
                    $model_allocation = new \backend\modules\allocation\models\Allocation();
                    $model_allocation->application_id = $applicationId;
                    $model_allocation->loan_item_id = $subrow["loan_item_id"];
                    $model_allocation->allocated_amount = $amounttotal;
                    $model_allocation->save(FALSE);
                    $subtotal += $amounttotal;
                    echo $needness_amount -= $amounttotal;
                    echo "<br/>";
                } else {
                    echo "needleness imaisha";
                }
            }

            $totalbudget -= $subtotal;
            // exit();
            /*
             * End Award loan Item to application 
             * #############################
             */
        }
        return $totalbudget;
    }

    public function actionAllocationHistory() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $item_id = trim(isset($parents[0]) ? $parents[0] : NULL);

                $items = \backend\modules\allocation\models\AllocationBatchHistory::getAllocationHist($item_id);
                foreach ($items as $item) {
                    $data = ['id' => $item['loan_allocation_history_id'], 'name' => $item['allocation_name']];
                    array_push($out, $data);
                }
                echo \yii\helpers\Json::encode(['output' => $out]);
                return;
            }
        }
        echo \yii\helpers\Json::encode(['output' => '']);
    }
  public function actionReviewAllocationBatch($id) {
         $model=  AllocationBatch::findOne($id);
            $model->is_reviewed=1;
            $model->review_at=date("Y-m-d");
            $model->review_by=\Yii::$app->user->identity->user_id;
         $model->save();
           if($model){    
         Yii::$app->getSession()->setFlash('success', "Allocation Batch Review Successfully");
           }
           else{
           Yii::$app->getSession()->setFlash('error', "Allocation Batch Review Failed");     
           }
         return $this->redirect(['view','id'=>$id]);
    }
   public function actionApproveAllocationBatch($id) {
          $model=  AllocationBatch::findOne($id);
          if ($model->load(Yii::$app->request->post())) {
    
            $model->is_approved=1;
            $model->approved_at=date("Y-m-d");
            $model->approved_by=\Yii::$app->user->identity->user_id;
         $model->save();
         Yii::$app->getSession()->setFlash('success', "Allocation Batch Approved Successfully");
        return $this->redirect(['view','id'=>$id]);
        } else {
            return $this->render('approvecreate', [
                'model' => $model,
            ]);
        }
    }
    public function actionDisapproveAllocationBatch($id) {
         $model=  AllocationBatch::findOne($id);
        
            if ($model->load(Yii::$app->request->post())) {
    
            $model->is_approved=2;
            $model->approved_at=date("Y-m-d");
            $model->approved_by=\Yii::$app->user->identity->user_id;
         $model->save();
         Yii::$app->getSession()->setFlash('success', "Allocation Batch Disapproved Successfully");
        
         return $this->redirect(['view','id'=>$id]);
        } else {
            return $this->render('disapprovecreate', [
                'model' => $model,
            ]);
        }
    }
}

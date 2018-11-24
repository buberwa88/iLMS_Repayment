<?php

namespace backend\modules\allocation\controllers;

use Yii;
//use yii\web\Controller;
use backend\modules\application\models\Application;
use frontend\modules\repayment\models\LoanRepaymentBillDetail;
use backend\modules\allocation\models\Criteria;
use backend\modules\application\models\ApplicationSearch;
use common\components\Controller;

/**
 * Default controller for the `allocation` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = "main_private";

    public function actionIndex() {

        return $this->render('index');
    }

    public function actionIndexCompliance() {

        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchcompliance(Yii::$app->request->queryParams);

        return $this->render('application-compliance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCheckCompliance() {
        //max to process
        $max_data_processing = 1000;
        /*$model_count = Application::find()->joinWith('applicant')->where(['allocation_status' => NULL])->count();
        if ($model_count > $max_data_processing) {
            $index_max_limit = ceil(($model_count / $max_data_processing));
            $start_record = 0;
            $end_record = $max_data_processing;
        } else {
            $index_max_limit = 1;
            $start_record = 0;
            $end_record = $model_count;
        }*/
        $done=true;
        $start_record=0;
        $end_record=$max_data_processing;
       while ($done) {
        //select all application with status=0
        $modelapplication = Application::find()->joinWith('applicant')->where(['allocation_status' => NULL])->limit($max_data_processing)->offset($start_record)->all();
       // print_r($modelapplication);
       // exit();
        //check eligibility  eligibility
        $rate_loan = $require_topay = 0;
        if (count($modelapplication) > 0) {
            $finalstatus = 0;
            foreach ($modelapplication as $rows) {
                $applicationId = $rows["application_id"];
                $programme_id = $rows["programme_id"];

                 //$transfer_status = $rows["transfer_status"];
                 $f4indexno = $rows['applicant']["f4indexno"];
                 $applicant_category_id= $rows["applicant_category_id"];;
                 $academic_year_id= $rows["academic_year_id"];
                /**
                 * check admission status.
                 */
                if ($programme_id > 0) {
                    /**
                     * end check admission status
                     *
                     * Check loan History.
                     */
                    //getApplicantDetails($applcantF4IndexNo,$NIN);
                    $loan_rate =  \backend\models\SystemSetting::findOne(["is_active" => 1,'setting_code'=>'PLRFNL']);

                    $total_loan = \backend\modules\disbursement\models\Disbursement::getLoan($f4indexno);

                    if (count($loan_rate) > 0) {
                        $rate_loan = ($loan_rate->setting_value/100);
                    }
                    //   exit();
                    if ($total_loan > 0) {
                        $require_topay = $total_loan * $rate_loan;
                    }
                    $loan_paid = \backend\modules\disbursement\models\Disbursement::getLoanPayment($f4indexno);
                    //check transfer information
                    //If exit waiting to complite
                    if ($loan_paid >= $require_topay) {
                        //get pull of eligibility criteria question and answer or criteria field with answer
                        //criteria question with answer
                        /**
                         * Processing  Criteria question answer .
                         * @
                         */
                        $this->CheckCriteriaQuestion($applicationId);
                        /**
                         * End Processing  Criteria question answer .
                         *
                         *
                         * Start Processing  Criteria Field question answer .
                         * @
                         */
                        $this->CheckCriteriaField($applicationId,$applicant_category_id, $academic_year_id);
                        //print_r($question_criteria_field);
                        //    exit();
                    } else {
                        /*
                         * User or applicant have loan and not pay the rate or percent required
                         */
                        //update admission status
                        $comment = "Not pay the Previous Loan";
                        $status = 2;
                        $this->UpdateAdmission($applicationId, $comment, $status);
                        $finalstatus+=1;
                        //upate end
                    }
                } else {
                    //update admission status
                    $comment = "Missing Admission";
                    $status = 2;
                    $this->UpdateAdmission($applicationId, $comment, $status);
                    $finalstatus+=1;
                    //upate end
                }
                //update final  eligibility status
                if ($finalstatus == 0) {
                    $comment = "Eligible";
                    $status = 1;
                    $this->UpdateAdmission($applicationId, $comment, $status);
                }
                //end
              
            }
            $end_record=$end_record+$max_data_processing;
            $start_record=$end_record+1;
                unset($modelapplication);
                unset($loan_paid);
                unset($loan_rate);
        }
        else{
          $done=FALSE;
        }
     
    }
        //end
        return $this->redirect(['index-compliance']);
        /// return $this->render('');
    }
  public function actionRecheckCompliance() {
        //select all application with status=0
        $modelapplication = Application::find()->joinWith('applicant')->where(['allocation_status' =>2])->all();
       // print_r($modelapplication);
         // EXIT();
       /* print_r($modelapplication);
 foreach ($modelapplication as $rows) {
                $applicationId = $rows["application_id"];
                $programme_id = $rows["programme_id"];

                $transfer_status = $rows["transfer_status"];
                echo  $f4indexno = $rows['applicant']["f4indexno"];
                echo "<br/>";
                 
}*/
      //  exit();
        //check eligibility  eligibility
        $rate_loan = $require_topay = 0;
        if (count($modelapplication) > 0) {
            $finalstatus = 0;
            foreach ($modelapplication as $rows) {
                 $applicationId = $rows["application_id"];
                 $programme_id = $rows["programme_id"];
              
                // $transfer_status = $rows["transfer_status"];
                 $f4indexno = $rows['applicant']["f4indexno"];
                 $applicant_category_id= $rows["applicant_category_id"];;
                 $academic_year_id= $rows["academic_year_id"];
               
                /**
                 * check admission status.
                 */
                 $finalstatus=0;
                 $this->UpdateStatusempty($applicationId);
                if ($programme_id > 0) {
                    /**
                     * end check admission status
                     *
                     * Check loan History.
                     */
                    //getApplicantDetails($applcantF4IndexNo,$NIN);
                    $loan_rate =  \backend\models\SystemSetting::findOne(["is_active" => 1,'setting_code'=>'PLRFNL']);

                    $total_loan = \backend\modules\disbursement\models\Disbursement::getLoan($f4indexno);

                    if (count($loan_rate) > 0) {
                        $rate_loan = ($loan_rate->setting_value/100);
                    }
                    //   exit();
                    if ($total_loan > 0) {
                        $require_topay = $total_loan * $rate_loan;
                    }
                    $loan_paid = \backend\modules\disbursement\models\Disbursement::getLoanPayment($f4indexno);
                    //check transfer information
                    //If exit waiting to complite
                    if ($loan_paid >= $require_topay) {
                        //get pull of eligibility criteria question and answer or criteria field with answer
                        //criteria question with answer
                        /**
                         * Processing  Criteria question answer .
                         * @
                         */
                       // $this->CheckCriteriaQuestion($applicationId);
                        /**
                         * End Processing  Criteria question answer .
                         *
                         *
                         * Start Processing  Criteria Field question answer .
                         * @
                         */
                       
                        $this->CheckCriteriaField($applicationId,$applicant_category_id, $academic_year_id);
                        //print_r($question_criteria_field);
                        //    exit();
                    } else {
                        /*
                         * User or applicant have loan and not pay the rate or percent required
                         */
                        //update admission status
                       $comment = "Not pay the previous loan";
                        $status = 2;
                        $this->UpdateAdmission($applicationId, $comment, $status);
                        $finalstatus+=1;
                        //upate end
                    }
                } else {
                    //update admission status
                    $comment = "Missing Admission Data";
                    $status = 2;
                    $this->UpdateAdmission($applicationId, $comment, $status);
                    $finalstatus+=1;
                    //upate end
                }
                //update final  eligibility status
                if ($finalstatus == 0) {
                    $this->UpdateStatusempty($applicationId);
                    $comment = "You are Eligible";
                    $status = 1;
                    $this->UpdateAdmission($applicationId, $comment, $status);
                }
             /* else{
                   $comment = "Not Eligible ";
                    $status = 2;
                    $this->UpdateAdmission($applicationId, $comment, $status);
                    if($applicationId==18){
                        echo $programme_id;
                        echo '<br/>';
                        echo $finalstatus;
                       exit(); 
                    }
                }*/
               
            } 
        }
        //end
        return $this->redirect(['noteligible-applicant']);
        /// return $this->render('');
    }
    public function getApplicationQuestion($applicationId, $question_id, $answered) {

        return Yii::$app->db->createCommand("SELECT * FROM `applicant_question` aq
                                                  join `applicant_qn_response` ar
                                                  on ar.`applicant_question_id`=aq.`applicant_question_id`
                                                  join `application` a
                                                  on a.`application_id`=aq.`application_id`
                                                  join qresponse_source qs
                                                  on qs.`qresponse_source_id`=ar.`qresponse_source_id`
                                                  WHERE a.application_id='{$applicationId}' AND question_id='{$question_id}' AND $answered")->queryAll();
    }

    public function CheckCriteriaQuestion($applicationId) {
        $question_criteria = Criteria::getCriteriaQuestion(1);
        $commentcount = 0;
        if (count($question_criteria) > 0) {
            foreach ($question_criteria as $system_row) {
                $final_test = 0;
                //application question answer
                $qresponse_source_id = $system_row["qresponse_source_id"];
                $parentId = $system_row["parent_id"];
                $response_id = $system_row["response_id"];
                $question_id = $system_row["question_id"];
                $question_answer = $system_row["value"];
                if ($commentcount == 0) {
                    if ($qresponse_source_id != "" && $response_id != "") {
                        $answered = "qs.qresponse_source_id='{$qresponse_source_id}' AND ar.response_id='{$response_id}'";
                    } else {
                        $answered = "question_answer='{$question_answer}'";
                    }

                    //get system criteria answer
                    $answeredvalue = Criteria::getCriteriaPosibleQuestionAnswer($system_row['source_table'], $system_row['source_table_value_field'], $system_row['response_id'], $system_row['source_table_text_field']);

                    $application_question = $this->getApplicationQuestion($applicationId, $question_id, $answered);
                    
                    //print_r($application_question);
                    if (count($application_question) > 0) {
                        foreach ($application_question as $rowsq)
                            ;

                        $final_test = Criteria::getapplicantCriteriaQuestionAnswer($rowsq['source_table'], $rowsq['source_table_value_field'], $rowsq['response_id'], $rowsq['source_table_text_field'], $system_row["operator"], $answeredvalue);
                        //echo $answereddata;
                    }
                    //check child data
                    $criteria_field_child = Criteria::getCriteriaQuestionChild($parentId, 1);
                    if (count($criteria_field_child) > 0) {
                        foreach ($criteria_field_child as $rows_child) {
                            $join_operator_child = $rows_child["join_operator"];
                            //  $parentId=$rows_child["criteria_field_id"];
                            //$response_value_child = Criteria::TestApplicantCriteriaFieldAnswer($rows_child["source_table"], $rows_child["source_table_field"], $rows_child["value"], $rows_child["operator"]);
                            //get system criteria answer
                            $answeredvaluechild = Criteria::getCriteriaPosibleQuestionAnswer($rows_child['source_table'], $rows_child['source_table_value_field'], $rows_child['response_id'], $rows_child['source_table_text_field']);

                            $application_question_child = $this->getApplicationQuestion($applicationId, $question_id, $answered);
                            $final_testchild = 0;
                            //print_r($application_question);
                            if (count($application_question_child) > 0) {
                                foreach ($application_question_child as $rowsq_child)
                                    ;

                                $final_testchild = Criteria::getapplicantCriteriaQuestionAnswer($rowsq_child['source_table'], $rowsq_child['source_table_value_field'], $rowsq_child['response_id'], $rowsq_child['source_table_text_field'], $rowsq_child["operator"], $answeredvaluechild);
                                //echo $answereddata;
                            }
                            if ($join_operator_child != "") {
                                if ($join_operator_child == "AND") {
                                    $final_test = $final_test * $final_testchild;
                                } else if ($join_operator_child == "OR") {
                                    $final_test = $final_test + $final_testchild;
                                }
                            }
                        }
                    }
                    //update status
                    if ($final_test == 0) {
                        //update application status
                        // $commentcount+=1;
                        $comment = " You are  not eligible";
                        $status = 2;
                        $this->UpdateAdmission($applicationId, $comment, $status);
                        continue;
                        ///end
                    } else if ($final_test > 0) {
                        //update application status
                        // $commentcount+=1;
                        $comment = " You are Eligible";
                        $status = 1;
                        $this->UpdateAdmission($applicationId, $comment, $status);
                        continue;
                        ///end
                    }
                }
            }
        }
    }

    public function CheckCriteriaField($applicationId,$applicant_category_id, $academic_year_id) {
        $final_test = 0;
        $question_criteria_field = Criteria::getCriteriaFieldQuestion(1,$applicant_category_id, $academic_year_id);
        if (count($question_criteria_field) > 0) {
            foreach ($question_criteria_field as $rows_qs) {
                $criteria_comment=$rows_qs["criteria_description"]; 
                $parentId = $rows_qs["criteria_field_id"];
                //$final_test=-1;
                $response_value = Criteria::TestApplicantCriteriaFieldAnswer($rows_qs["source_table"], $rows_qs["source_table_field"], $rows_qs["value"], $rows_qs["operator"],$applicationId);
                $final_test = $response_value;

                $criteria_field_child = Criteria::getCriteriaFieldChild($parentId, 1);
                if (count($criteria_field_child) > 0) {
                    foreach ($criteria_field_child as $rows_child) {
                        $join_operator_child = $rows_child["join_operator"];
                        //  $parentId=$rows_child["criteria_field_id"];
      $response_value_child = Criteria::TestApplicantCriteriaFieldAnswer($rows_child["source_table"], $rows_child["source_table_field"], $rows_child["value"], $rows_child["operator"],$applicationId);
                        if ($join_operator_child != "") {
                            if ($join_operator_child == "AND") {
                                $final_test = $final_test * $response_value_child;
                            } else if ($join_operator_child == "OR") {
                                $final_test = $final_test + $response_value_child;
                            }
                        }
                    }
                }
                //update status
                if ($final_test == 0) {
                    //update application status
                    // $commentcount+=1;
                    $comment = " You are not eligible due to ".$criteria_comment;
                    $status = 2;
                    $this->UpdateAdmission($applicationId, $comment, $status);
                    continue;
                    ///end
                } else if ($final_test > 0) {
                    //update application status
                    // $commentcount+=1;
                    $comment = " You are Eligible";
                    $status = 1;
                    $this->UpdateAdmission($applicationId, $comment, $status);
                    continue;
                    ///end
                }
                //end
            }
        }
    }

    /**
     * Update Application  table.
     * @param integer $applicationId
     * @return mixed
     */
    public function UpdateAdmission($applicationId, $comment, $status) {
        $model_update = Application::findone($applicationId);
        $model_update->allocation_status = $status;
        $model_update->allocation_comment = $comment . " ; " . $model_update->allocation_comment;
        $model_update->save(false);
      //   print_r($model_update); 
       // exit();
        return $model_update;
    }
 public function UpdateStatusempty($applicationId) {
        $model_update = Application::findone($applicationId);
        //$model_update->allocation_status = $status;
        $model_update->allocation_comment = "";
        $model_update->save(false);
      //   print_r($model_update); 
       // exit();
        return $model_update;
    }

    public function actionIndexMeanTest() {

        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchMeanTest(Yii::$app->request->queryParams);

        return $this->render('application-mean-test', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
   public function actionMeansTestedApplicant() {
          $this->layout="default_main";
        $searchModel = new ApplicationSearch();
        $value=[6];
        $dataProvider = $searchModel->searchMeansTested(Yii::$app->request->queryParams,$value);

        return $this->render('means_tested_applicant', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
   public function actionMeansTestedProblem() {
          $this->layout="default_main";
        $searchModel = new ApplicationSearch();
          $value=[7];
        $dataProvider = $searchModel->searchMeansTested(Yii::$app->request->queryParams,$value);

        return $this->render('means_tested_problem', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionComputeNeedness() {
        //select all application with status=0
        $modelapplication = Application::find()->where(['submitted' => 0])->limit(20)->asArray()->all();
        //print_r($modelapplication);
        //check eligibility  eligibility
        if (count($modelapplication)) {
            foreach ($modelapplication as $rows) {
                $applicationId = $rows["applicant_id"];
                //get pull of eligibility criteria question and answer or criteria field with answer
                //criteria question with answer
                $sql_system_question_criteria = Yii::$app->db->createCommand("SELECT * from `criteria_question` cq,`criteria_question_answer` ca WHERE
                                                                                     ca.`criteria_question_id`=cq.`criteria_question_id` AND `type`=2")->queryAll();
                //end
                foreach ($sql_system_question_criteria as $system_row) {
                    //application question answer
                    $qresponse_source_id = $system_row["qresponse_source_id"];
                    $response_id = $system_row["response_id"];
                    $question_id = $system_row["question_id"];
                    $question_answer = $system_row["value"];
                    if ($qresponse_source_id != "" && $response_id != "") {
                        $answered = "qresponse_source_id='{$qresponse_source_id}' AND response_id='{$response_id}'";
                    } else {
                        $answered = "question_answer='{$question_answer}'";
                    }
                    $sql_application = Yii::$app->db->createCommand("SELECT * FROM `applicant_question` aq join `applicant_qn_response` ar
                                                                                          on ar.`applicant_question_id`=aq.`applicant_question_id`
                                                                                          join `application` a on a.`application_id`=aq.`application_id` WHERE a.application_id='{$applicationId}' AND question_id='{$question_id}' AND $answered ")->queryAll();
                }
            }
        }
        //end
        // return $this->render('index');
    }
    public function actionEligibleApplicant() {
          $this->layout="default_main";
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searcheligible(Yii::$app->request->queryParams);

        return $this->render('_eligible_applicant', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
  public function actionNoteligibleApplicant() {
          $this->layout="default_main";
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchnoteligible(Yii::$app->request->queryParams);

        return $this->render('_noteligible_applicant', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function AdmissionStatus() {
        
    }

    public function LoanHistory() {
        
    }

    public function RepaymentStatus() {
        
    }

}

<?php

namespace backend\modules\allocation\controllers;

use Yii;
//use yii\web\Controller;
use backend\modules\application\models\Application;
use backend\modules\allocation\models\Criteria;
use backend\modules\application\models\ApplicationSearch;
use common\components\Controller;

/**
 * Default controller for the `allocation` module
 */
class AllocationProcessController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = "main_private";

    public function actionIndex() {

        return $this->render('index');
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
        $question_criteria = Criteria::getCriteriaQuestion(2);
        $myfactor = 0;
        //      $applicationId=12;
        if (count($question_criteria) > 0) {
            foreach ($question_criteria as $system_row) {
                $final_test = 0;
                //application question answer
                $qresponse_source_id = $system_row["qresponse_source_id"];
                $parentId = $system_row["criteria_question_id"];
                $response_id = $system_row["response_id"];
                $weight_score = $system_row["weight_points"];
                $priority_score = $system_row["priority_points"];
                $question_id = $system_row["question_id"];
                $criteria_question_id = $system_row["criteria_question_id"];
                $question_answer = $system_row["value"];
                //$applicationId=12;
                if ($qresponse_source_id != "" && $response_id != "") {
                    $answered = "qs.qresponse_source_id='{$qresponse_source_id}' AND ar.response_id='{$response_id}'";
                } else {
                    $answered = "question_answer='{$question_answer}'";
                }

                //get system criteria answer
                $answeredvalue = Criteria::getCriteriaPosibleQuestionAnswer($system_row['source_table'], $system_row['source_table_value_field'], $system_row['response_id'], $system_row['source_table_text_field']);

                $application_question = $this->getApplicationQuestion($applicationId, $question_id, $answered);


                if (count($application_question) > 0) {
                    foreach ($application_question as $rowsq)
                        ;

                    $final_test = Criteria::getapplicantCriteriaQuestionAnswer($rowsq['source_table'], $rowsq['source_table_value_field'], $rowsq['response_id'], $rowsq['source_table_text_field'], $system_row["operator"], $answeredvalue);
                    //echo $answereddata;
                }

                //check child data
                $criteria_field_child = Criteria::getCriteriaQuestionChild($parentId, 2);

                if (count($criteria_field_child) > 0) {

                    foreach ($criteria_field_child as $rows_child) {

                        $join_operator_child = $rows_child["join_operator"];
                        $weight_score_child = $rows_child["weight_points"];
                        $question_id_child = $rows_child["question_id"];
                        $criteria_question_id_child = $rows_child["criteria_question_id"];
                        $qresponse_source_id_child = $rows_child["qresponse_source_id"];
                        $response_id_child = $rows_child["response_id"];
                        $question_answer_child = $rows_child["value"];

                        if ($qresponse_source_id_child != "" && $response_id_child != "") {
                            $answered_child = "qs.qresponse_source_id='{$qresponse_source_id_child}' AND ar.response_id='{$response_id_child}'";
                        } else {
                            $answered_child = "question_answer='{$question_answer_child}'";
                        }

                        $answeredvaluechild = Criteria::getCriteriaPosibleQuestionAnswer($rows_child['source_table'], $rows_child['source_table_value_field'], $rows_child['response_id'], $rows_child['source_table_text_field']);

                        $application_question_child = $this->getApplicationQuestion($applicationId, $question_id_child, $answered);
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
                            if ($final_test > 0) {
                                //insert the score  
                                //applicant_criteria_score
                                $this->InsertApplicantCriteriaScore($applicationId, $criteria_question_id_child, $weight_score_child, $priority_score, 1);

                                $myfactor+=$weight_score_child;
                            }
                        }
                    }
                } else {
                    if ($final_test > 0) {
                        //insert the score  
                        //applicant_criteria_score
                        $this->InsertApplicantCriteriaScore($applicationId, $criteria_question_id, $weight_score, $priority_score, 1);
                        //end 

                        $myfactor+=$weight_score;
                    }
                }
//                   
            }
        }

        return $myfactor;
    }

    public function CheckCriteriaField($applicationId, $applicant_category_id, $academic_year_id) {
        $myfactor = 0;
        $question_criteria_field = Criteria::getCriteriaFieldQuestion(2, $applicant_category_id, $academic_year_id);
        if (count($question_criteria_field) > 0) {
            foreach ($question_criteria_field as $rows_qs) {
                //$join_operator=$rows_qs["join_operator"];
                $weight_score = $rows_qs["weight_points"];
                $priority_score = $rows_qs["priority_points"];
                //$parentId = $rows_qs["parent_id"];
                $parentId = $criteria_field_id = $rows_qs["criteria_field_id"];
                //$final_test=-1;
                $response_value = Criteria::TestApplicantCriteriaFieldAnswer($rows_qs["source_table"], $rows_qs["source_table_field"], $rows_qs["value"], $rows_qs["operator"], $applicationId);
                $final_test = $response_value;

                $criteria_field_child = Criteria::getCriteriaFieldChild($parentId, 2);
                if (count($criteria_field_child) > 0) {
                    foreach ($criteria_field_child as $rows_child) {
                        $join_operator_child = $rows_child["join_operator"];
                        //  $parentId=$rows_child["criteria_field_id"];
                        $response_value_child = Criteria::TestApplicantCriteriaFieldAnswer($rows_child["source_table"], $rows_child["source_table_field"], $rows_child["value"], $rows_child["operator"], $applicationId);
                        if ($join_operator_child != "") {
                            if ($join_operator_child == "AND") {
                                $final_test = $final_test * $response_value_child;
                            } else if ($join_operator_child == "OR") {
                                $final_test = $final_test + $response_value_child;
                            }
                        }
                        if ($final_test > 0) {
                            //applicant_criteria_score
                            $this->InsertApplicantCriteriaScore($applicationId, $criteria_field_id, $weight_score, $priority_score, 2);
                            //end 
                            $myfactor+=$weight_score;
                        }
                    }
                } else {
                    //update status of application
                    if ($final_test > 0) {
                        //applicant_criteria_score
                        $this->InsertApplicantCriteriaScore($applicationId, $criteria_field_id, $weight_score, $priority_score, 2);
                        //end 
                        $myfactor+=$weight_score;
                    }
                }
            }
        }
        return $myfactor;
    }

    public function InsertApplicantCriteriaScore($applicationId, $criteria_question_id, $weight_score, $priority_score, $sourceType) {
        //check if exits
        $modelall = \backend\modules\allocation\models\ApplicantCriteriaScore::find()->where(["application_id" => $applicationId, 'criteria_question_id' => $criteria_question_id])->all();
        //end  
        if (count($modelall) == 0) {
            $model = new \backend\modules\allocation\models\ApplicantCriteriaScore();
            $model->application_id = $applicationId;
            if ($sourceType == 2) {
                $model->criteria_field_id = $criteria_question_id;
            } else if ($sourceType == 1) {
                $model->criteria_question_id = $criteria_question_id;
            }
            $model->save();
        }
        return;
    }

    public function actionIndexComputeNeedness() {

        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchComputeNeedness(Yii::$app->request->queryParams);

        return $this->render('../default/application-compute-needness', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMeanTest($allocation_status) {
        //select all application with status=0
        //select all application with status=0
         ###################find the current academic year ###############
                $academic_year_id = -1;
                $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
                if (count($model_year) > 0) {
                    $academic_year_id = $model_year->academic_year_id;
                }
         $modelapplicationcount = Application::find()->joinWith('applicant')->where(['progress_status'=>1,'allocation_status' =>$allocation_status,'academic_year_id'=>$academic_year_id])->count();
         $maximum_data_to_process = Yii::$app->module->params['allocation_maximum_data_to_process']; ///the maximum No of students that can be processed a one time in the allocation process
            //print_r($modelapplicationcount);
             //      exit();
          ////loop among the sudent list to allocate the loan zmount based on needness until when it is over   
               $maximum_data_to_process=100;
          $index = $modelapplicationcount/ $maximum_data_to_process;
                    if (!is_integer($index)) {
                        $index = floor($index + 1);
                    }
             $start_index = 0;
             $end_index = $maximum_data_to_process;
         for ($i = 1; $i <= $index; $i++) {
              //$start_index, $end_index
        $modelapplication = Application::find()->joinWith('applicant')->where(['progress_status'=>1,'allocation_status' =>$allocation_status,'academic_year_id'=>$academic_year_id])->limit($maximum_data_to_process)->offset($start_index)->all();
        /// print_r($modelapplication);
        //check eligibility  eligibility
       
        $rate_loan = $require_topay = 0;
        if (count($modelapplication) > 0) {
            $finalstatus = 0;
          
            foreach ($modelapplication as $rows) {
                $applicationId = $rows["application_id"];
                $applicant_category_id = $rows["applicant_category_id"];
                //get pull of eligibility criteria question and answer or criteria field with answer
                //criteria question with answer
                /**
                 * Processing  Criteria question answer .
                 * @
                 */
                // $myfactor_cq = $this->CheckCriteriaQuestion($applicationId);

                /**
                 * End Processing  Criteria question answer .
                 *
                 *
                 * Start Processing  Criteria Field question answer .
                 * @
                 */
                // $myfactor_cf = $this->CheckCriteriaField($applicationId);
               
                ############################ end ################################
                ####################### check criteria and compute my factor #########################
                $myfactor_cf = $this->CheckCriteriaField($applicationId, $applicant_category_id, $academic_year_id);
              
                $myfactor = $myfactor_cf;
                if ($myfactor >= 0) {
                    $modelupdate = Application::findOne($applicationId);
                    $modelupdate->allocation_status =5;
                    $modelupdate->myfactor = $myfactor;
                    $modelupdate->save();
                     
                  ############## end compute my factor and update #################
                  ################### Compute Needness #################
                   $this->ComputeNeednessAll($applicationId, $modelupdate->programme_id,$academic_year_id,$modelupdate->current_study_year,$myfactor);
                  ################### End compute Needness ############
                    
                }
            }
        }
        $start_index = ($i * $maximum_data_to_process) + 1;
        $end_index = ($start_index + $maximum_data_to_process) - 1;
        }
          if($allocation_status==1){
        return $this->redirect(['default/index-mean-test']);
          }else{
        return $this->redirect(['default/means-tested-problem']);      
          }
    }
 public function actionComputeNeedness() {
                $academic_year_id = -1;
                $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
                if (count($model_year) > 0) {
                    $academic_year_id = $model_year->academic_year_id;
                }
         $modelapplicationcount = Application::find()->joinWith('applicant')->where(['progress_status'=>2,'allocation_status' => 1,'current_academic_year_id'=>$academic_year_id])->count();
               $maximum_data_to_process = Yii::$app->module->params['allocation_maximum_data_to_process']; ///the maximum No of students that can be processed a one time in the allocation process
                    ////loop among the sudent list to allocate the loan zmount based on needness until when it is over   
               $maximum_data_to_process=100;
          $index = $modelapplicationcount/ $maximum_data_to_process;
                    if (!is_integer($index)) {
                        $index = floor($index + 1);
                    }
             $start_index = 0;
             $end_index = $maximum_data_to_process;
         for ($i = 1; $i <= $index; $i++) {
              //$start_index, $end_index
        $modelapplication = Application::find()->joinWith('applicant')->where(['progress_status'=>2,'allocation_status' => 1,'current_academic_year_id'=>$academic_year_id])->limit($maximum_data_to_process)->offset($start_index)->all();
        /// print_r($modelapplication);
        //check eligibility  eligibility
       
        $rate_loan = $require_topay = 0;
        if (count($modelapplication) > 0) {
            $finalstatus = 0;
          
            foreach ($modelapplication as $rows) {
                $applicationId = $rows["application_id"];
                $applicant_category_id = $rows["applicant_category_id"];
                $ability=$rows["ability"];
                $programme_id=$rows["programme_id"];
                $current_study_year=$rows["current_study_year"];
               
                ############################ end ################################
               
                  ############## end compute my factor and update #################
                  ################### Compute Needness #################
                   $this->ComputeNeednessCont($applicationId, $programme_id,$academic_year_id,$current_study_year,$ability);
                  ################### End compute Needness ############
               
            }
        }
        $start_index = ($i * $maximum_data_to_process) + 1;
        $end_index = ($start_index + $maximum_data_to_process) - 1;
        }
        return $this->redirect(['allocation-process/index-compute-needness']);
    }
  
 public function ComputeNeednessCont($applicationId, $programme_id, $academic_year, $year_of_study,$ability) {
              ########################check if has a programme @@@@@@@@@@@@@@@@@@@@@#######################
     
        if ($programme_id != "" && $programme_id > 0) {
               ########################find the applicant programme cost per academic year ################################
               ########################  ,year of staudy and programme name           ##########################################
               $programme_cost = $this->getprogrammeCost($programme_id, $academic_year, $year_of_study);
               ################check if return any amount ####################
          if($programme_cost>0){
             /*
             * end get Program cost of the programme selected 
             * ####################
             */
            /*#############################################################
           
            /**
             * compute needness for applicant .
             * @@@@@@@@@@@@@@@@@@@@
             */
           $needness = $programme_cost - $ability;
           $model_update = Application::findone($applicationId);
              $model_update->allocation_status =5;
              $model_update->programme_cost=$programme_cost;
              $model_update->needness = $needness;
           $model_update->save();
             }
      else{
         ######################### No programme cost configered for this programme ###############
                     $comment="Programme cost  not set";
                  $this->UpdateNeednessComments($applicationId, $comment);
         ######################### End update programme cost status ##############################
          
      }
      } else {
     
            ################ update status and comment has no programme#############
                     $comment="No admission information";
              $this->UpdateNeednessComments($applicationId, $comment);
            ################ end update #######################
        }
        return;
    }
 public function ComputeNeednessAll($applicationId, $programme_id, $academic_year, $year_of_study,$myfactor) {
              ########################check if has a programme @@@@@@@@@@@@@@@@@@@@@#######################
     
        if ($programme_id != "" && $programme_id > 0) {
               ########################find the applicant programme cost per academic year ################################
               ########################  ,year of staudy and programme name           ##########################################
               $programme_cost = $this->getprogrammeCost($programme_id, $academic_year, $year_of_study);
               ################check if return any amount ####################
                if($programme_cost>0){
             /*
             * end get Program cost of the programme selected 
             * ####################
             */
            /*#############################################################
             * get resource based on the previous education fee and fee factor[ PREVIOUS_EDUCATION_FEE * FEE_FACTOR] 
             */

            $studentfee = $this->getStudentFee($applicationId,$academic_year);
            #############check student or applicant fee if exit #############
            
             if($studentfee>0){
            /**
             * compute needness for applicant .
             * @@@@@@@@@@@@@@@@@@@@
             */
           // $myfactor = $rows["myfactor"];
            if ($myfactor > 1) {
                $myfactor = 1;
            }
            /*
             * Find the fee factor of the student
             * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
             */
            $fee_factor = \backend\modules\allocation\models\base\AllocationFeeFactor::getFeeFactor($studentfee,$academic_year);
            /*
             * end find the fee factor
             * #######################
             */

            if ($fee_factor != "M") {
                $needness = $programme_cost - $studentfee * $fee_factor * (1 - $myfactor);
                /**
                 * Update  needness of applicant .
                 * @@@@@@@@@@@@@
                 */
                $ability = $studentfee * $fee_factor * (1 - $myfactor);
                $this->UpdateNeedness($applicationId, $needness, $ability, $fee_factor, $studentfee,$programme_cost);
            }
            else{
              #################### Fee factor is not configured #################
                      $comment="Fee Factor is not set";
              $this->UpdateNeednessComments($applicationId, $comment);
              ####################  End update status fee factor ################
            }
        }
        else{
            ############################## No previous study applicant fee history ##########
                     $comment="School Fee not set";
              $this->UpdateNeednessComments($applicationId, $comment);  
            ############################# End update #######################################
        }
        }
      else{
         ######################### No programme cost configered for this programme ###############
                     $comment="Programme cost  not set";
                  $this->UpdateNeednessComments($applicationId, $comment);
         ######################### End update programme cost status ##############################
          
      }
 } else {
     
            ################ update status and comment has no programme#############
                     $comment="No admission information";
              $this->UpdateNeednessComments($applicationId, $comment);
            ################ end update #######################
        }
        return;
    }
 public function getprogrammeCost($programme_id, $academic_year, $year_of_study) {
        $amount = 0;
       $sqlprogramme_cost = Yii::$app->db->createCommand("SELECT sum(`unit_amount`) as programme_cost1 
                                      FROM programme_cost 
                                      WHERE `academic_year_id`='{$academic_year}' "
                        . " AND programme_id='{$programme_id}' "
                        . " AND year_of_study='{$year_of_study}' group by programme_id ,`academic_year_id`,`year_of_study`")->queryAll();

        if (count($sqlprogramme_cost) > 0) {
            foreach ($sqlprogramme_cost as $rows)
                ;

            $amount = $rows["programme_cost1"];
        }
        //end  

        return $amount;
    }
public function getStudentFee($applicationId, $academic_year) {
        $amount = 0;
        //find the resource of applicant
        $resource_cost = Yii::$app->db->createCommand("SELECT MAX(`fee_amount`) as amount  FROM `education` e 
                                                           join learning_institution_fee lf 
                                                           on e.`learning_institution_id`=lf.`learning_institution_id`
                                                           where `application_id`='{$applicationId}' 
                                                           AND `academic_year_id`='{$academic_year}'")->queryAll();
        if (count($resource_cost) > 0) {
            foreach ($resource_cost as $rows)
                ;
            $amount = $rows["amount"];
        }
        //end 
        return $amount;
    }
public function UpdateNeedness($applicationId, $needness, $ability, $fee_factor, $studentfee,$programme_cost) {

        $model_update = Application::findone($applicationId);
            $model_update->allocation_status = 6;
            $model_update->needness = $needness;
            $model_update->fee_factor =$fee_factor;
            $model_update->student_fee =$studentfee;
            $model_update->programme_cost=$programme_cost;
            $model_update->ability = $ability;
        $model_update->save();
        return 1;
    }
  public function actionAwardLoan() {

        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchawardloan(Yii::$app->request->queryParams);

        return $this->render('../default/application-award-loan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
 public function getFeeFactor($max_fee) {
        $myfactor = "M";
        // echo $max_fee;
        $question_criteria_field = Criteria::getCriteriaFieldQuestion(3);

        // print_r($question_criteria_field);

        if (count($question_criteria_field) > 0) {
            foreach ($question_criteria_field as $rows_qs) {
                //$join_operator=$rows_qs["join_operator"];
                $weight_score = $rows_qs["weight_points"];
                $priority_score = $rows_qs["priority_points"];
                $operator = $rows_qs["operator"];
                $value = $rows_qs["value"];
                //$parentId = $rows_qs["parent_id"];
                $parentId = $criteria_field_id = $rows_qs["criteria_field_id"];
                //$final_test=-1; 
                //test the value of the parent 
                $final_test = $this->is($max_fee, $value, $operator);
//                   echo $final_test."=>halima";
//                 exit();
                $criteria_field_child = Criteria::getCriteriaFieldChild($parentId, 3);
                if (count($criteria_field_child) > 0) {
                    foreach ($criteria_field_child as $rows_child) {
                        $join_operator_child = $rows_child["join_operator"];
                        $operator_child = $rows_child["operator"];
                        $value_child = $rows_child["value"];
                        $final_test_child = $this->is($max_fee, $value_child, $operator_child);
                        if ($join_operator_child != "") {
                            if ($join_operator_child == "AND") {
                                $final_test = $final_test * $final_test_child;
                            } else if ($join_operator_child == "OR") {
                                $final_test = $final_test + $final_test_child;
                            }
                        }
                        if ($final_test > 0) {
                            $myfactor = $weight_score;
                        }
                    }
                } else {
                    //update status of application
                    //echo "mickidadi=>";
                    if ($final_test > 0) {
                        $myfactor = $weight_score;
                    }
                }
            }
        }

        return $myfactor;
    }

    function is($op1, $op2, $c) {
        $meth = array('=' => 'equal', '>' => 'lessThan', '>=' => 'lessThanOrEqual', '<' => 'greaterThan', '<=' => 'greaterThanOrEqual');
        if ($method =$meth[$c]) {
            return $this->$method($op1, $op2);
        }
        return null; // or throw excp.
    }

    /*
     * Where $value_a=>dynamic value
     *       $value_b=>configured by system admin or user /baseline 
     */

    private function equal($value_a, $value_b) {
        return $value_a == $value_b ? 1 : 0;
    }

    private function greaterThan($value_a, $value_b) {
        return $value_a > $value_b ? 1 : 0;
    }

    private function lessThan($value_a, $value_b) {
        return $value_a < $value_b ? 1 : 0;
    }

    private function greaterThanOrEqual($value_a, $value_b) {
        return $value_a >= $value_b ? 1 : 0;
    }

    private function lessThanOrEqual($value_a, $value_b) {
        return $value_a <= $value_b ? 1 : 0;
    }
public function UpdateNeednessComments($applicationId, $comment) {
     $model_update = Application::findone($applicationId);
        $model_update->allocation_status =7;
        $model_update->allocation_comment =$comment;
     $model_update->save();
    
    }
  public function actionNeednessContinousApplicant() {
               $this->layout="default_main";
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchComputeNeedness(Yii::$app->request->queryParams);

        return $this->render('../default/needness_continous_applicant', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
   public function actionNeednessContinousProblem() {
              $this->layout="default_main";
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchComputeNeedness(Yii::$app->request->queryParams);

        return $this->render('../default/needness_continous_problem', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
}

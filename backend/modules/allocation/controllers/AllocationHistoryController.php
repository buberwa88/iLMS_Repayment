<?php
namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AllocationHistory;
use backend\modules\allocation\models\AllocationHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\allocation\models\AllocationBudget;
use backend\modules\allocation\models\AllocationPlanScenario;
use backend\modules\allocation\models\AllocationPlanLoanItem;
use backend\modules\allocation\models\AllocationPlanSpecialGroup;
use backend\modules\allocation\models\AllocationPlanClusterSetting;
use backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting;
use backend\modules\allocation\models\AllocationPlanGenderSetting;
use backend\modules\allocation\models\Application;
use backend\modules\allocation\models\AllocationPlanStudent;
use backend\modules\allocation\models\AllocationPlanStudentLoanItem;
use backend\modules\allocation\models\ApplicantCategory;

/**
 * AllocationHistoryController implements the CRUD actions for AllocationHistory model.
 */
class AllocationHistoryController extends Controller
{

    /**
     *
     * @inheritdoc
     */
    public function behaviors()
    {
        $this->layout = "main_private";
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [
                        'POST'
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all AllocationHistory models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AllocationHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionAllocate()
    {
        $model = new AllocationHistory();
        $model->academic_year_id = \backend\modules\allocation\models\AcademicYear::getCurrentYearID();
        return $this->render('allocate', [
            'model' => $model
        ]);
    }
    public function actionAllocateLocalFreshers() {
        $model = new AllocationHistory;
        $model->scenario = 'local-freshers'; //setting th scenario for validation of the allocation framework
        $model->student_type = AllocationHistory::STUDENT_TYPE_NORMAL; //setting defaultstudent type to normal
        $model->place_of_study = AllocationHistory::PLACE_TZ; ////setting detault place/country of study to be TZ for local normal student
        $model->academic_year_id = \backend\modules\allocation\models\AcademicYear::getCurrentYearID();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            ///checking id thereis a loan amount allocated for the given academic year
            $loan_budget = AllocationBudget::getAllocationBudgetByAcademicYearApplicantCategoryStudyLevelPlaceOfStudy($model->academic_year_id, AllocationBudget::APPLICANT_CATEGORY_NORMAL, $model->study_level, AllocationBudget::PLACE_OF_STUDY_TZ);
            
            if ($loan_budget) {
                
                ////when budget available continue with other steps
                ///GET ALLOCATION FRAMEWORK==check it fromallocation plan scenatios table
                $allocation_execution_order = AllocationPlanScenario::getFrameworkExecutionOrderByFrameworkId($model->allocation_framework_id);
                ///fetch here the loan Item Priority setting based in the allocation framework
                $allocation_loan_items_priority = AllocationPlanLoanItem::getLoanItemsByAllocationFrameworkid($model->allocation_framework_id);
                ///validate if framwork exists
                if ($allocation_execution_order && $allocation_loan_items_priority) {
                    ///verify allocation execution order required items
                    $count_execution_order_items = count($allocation_execution_order);
                    $count_verified_execution_order_items = 0;
                    $special_groups = $clusters = $gender_setting = $student_ratio_in_institution = NULL;
                    ////setting current available budget
                    $available_budget_amount = $loan_budget->budget_amount;
                    ///total number of students eligible for loan in a given acadmic year
                    $total_no_students_eligible = Application::countEligibleFirstTimeApplicantsByAcademicYear($model->academic_year_id);
                    
                    foreach ($allocation_execution_order as $execution_order_item) {
                        
                        switch ($execution_order_item->allocation_scenario) {
                            //for allocating special groups
                            case AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP:  ///allocate based on the special group configurations
                                $special_groups = AllocationPlanSpecialGroup::getSpecialGroupeByAllocationPlanID($model->allocation_framework_id);
                                if ($special_groups) {
                                    $count_verified_execution_order_items++;
                                }
                                
                                break;
                                
                            case AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION:///allocated based on student distribution matrix configurations
                                
                                $clusters = AllocationPlanClusterSetting::getClusterSettingsByAlloationPlanID($model->allocation_framework_id); //Query here fromtable allocation_clusters order by clusters priority
                                
                                $gender_setting = AllocationPlanGenderSetting::getGenderSettingsByAllocationPlanId($model->allocation_framework_id); // write function here to get data table allocation gender setting
                                $student_ratio_in_institution = AllocationPlanInstitutionTypeSetting::getInstitutionTypeSettingsByAllocationPlanId($model->allocation_framework_id); /// get the data for student ration based on the(pprivate/pubic institution)
                                if ($clusters OR $gender_setting OR $student_ratio_in_institution) {
                                    $count_verified_execution_order_items++;
                                }
                                
                                break;
                        }
                    }
                    
                    if ($count_execution_order_items > 0 && ($count_execution_order_items == $count_verified_execution_order_items)) {
                        //getting current academic year
                        $current_cademic_year_id = \backend\modules\allocation\models\AcademicYear::getCurrentYearID();
                        $maximum_data_to_process = Yii::$app->params['allocation_maximum_data_to_process']; ///the maximum No of students that can be processed a one time in the allocation process
                        ////STATING A TRANSACTION AND CREAITING THE ALLOCATION PLAN HISTORY IN THE TABLE
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {
                            //saving the alocation history model
                            $model->save();
                            
                            ///LOOP WITHIN THE FRAMEWORK EXECUTION ORDER BASED ON
                            $success = 0; //count success allocationcases;
                            $error_sms = '';
                            $success_sms = '';
                            foreach ($allocation_execution_order as $execution_order) {
                                //checkingth type of execution ordercurrently executed
                                switch ($execution_order->allocation_scenario) {
                                    //for allocating special groups
                                    case AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP:
                                        //echo '########### SPECIAL GROUP ALLOCATION SCENARIO########<br/>';
                                        /////get student special groups defined inthe allocation framework( table: allocation_plan_special_groups
                                        if ($special_groups) {
                                            //                                            var_dump($special_groups);
                                            ///looping among the special groups
                                            foreach ($special_groups as $special_group) {
                                                // echo 'Group Criteria ID: ' . $special_group->allocation_group_criteria_id . '=' . $model->academic_year_id . '<br/>';
                                                $criteria = \backend\modules\allocation\models\Criteria::findOne($special_group->allocation_group_criteria_id);
                                                $criteria_fields = \backend\modules\allocation\models\CriteriaField::find()
                                                ->select('criteria_field.criteria_id,source_table,source_table_field,operator,value,join_operator,')
                                                ->join('INNER JOIN', 'criteria', 'criteria.criteria_id=criteria_field.criteria_id')
                                                ->where(
                                                    ['criteria_field.criteria_id' => $special_group->allocation_group_criteria_id,
                                                        'type' => 3, 'academic_year_id' => $model->academic_year_id,
                                                        'applicant_category_id' => $model->study_level
                                                    ])
                                                    ->all();
                                                    // var_dump($criteria_fields);
                                                    if (is_object($criteria_fields)) {
                                                        $count = 1;
                                                        $count_objects = count($criteria_fields);
                                                        foreach ($criteria_fields as $field) {
                                                            $sql . $count = "(SELCT * FROM " . $field->source_table . " WHERE " . $field->source_table_field . " " . $field->operator . " '" . $field->value . "')";
                                                            if ($count_objects > 1 && ($count + 1 < $count_objects)) {
                                                                $sql . $count .= " " . $field->join_operator;
                                                            }
                                                            $count++;
                                                        }
                                                    }
                                                    //COUNTING THE NUMBER OF STUDENTS QUALIFYING FOR THE ALLOCATION
                                                    $count_students = Application::countLocalFreshersStudentForAllocationBySpecialGroupIdInCurrentAcademicYear($special_group->allocation_group_criteria_id, $model);
                                                    
                                                    /*
                                                     if ($count_students) {
                                                     ////loop among the sudent list to allocate the loan zmount based on needness until when it is over
                                                     $index = $count_students / $maximum_data_to_process;
                                                     if (!is_integer($index)) {
                                                     $index = floor($index + 1);
                                                     }
                                                     $start_index = 0;
                                                     $end_index = $maximum_data_to_process;
                                                     
                                                     for ($i = 1; $i <= $index; $i++) {
                                                     /////get student per each special group and allocate loan
                                                     /// Query here from application with commination on Admission student to get a clean data
                                                     ///HERE Also check for contions to apply when getting the list of student.
                                                     //check for admission(confirmed/vs non confirmed, transfer info( completed/not completed,
                                                     //means testing information ( neednines, myfactor. ALWAYS ORDER STUDENT BASED ON NEEDINESS
                                                     echo '######START INDEX QUERY=' . $start_index . '= END =' . $end_index;
                                                     $students_for_allocation = Application::getLocalFreshersStudentForAllocationBySpecialGroupIdInCurrentAcademicYear($special_group->allocation_group_criteria_id, $model, $start_index, $end_index);
                                                     /////loooping among thre sstudents received
                                                     if ($this->processLocalFreshersLoan($model, $students_for_allocation, $allocation_loan_items_priority, $available_budget_amount, AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP)) {
                                                     $transaction->commit();
                                                     $start_index = ($i * $maximum_data_to_process) + 1;
                                                     $end_index = ($start_index + $maximum_data_to_process) - 1;
                                                     $success++;
                                                     } else {
                                                     $error_sms .= ' , Special Group Award/Allocation failed, Please check student data to be allocated';
                                                     Yii::$app->session->setFlash('failure', $error_sms);
                                                     $transaction->rollBack();
                                                     }
                                                     }
                                                     } else {
                                                     //return sms to the user that there are no student based on the criteria
                                                     $error_sms .= " , No " . strtoupper(ApplicantCategory::getNameByID($model->study_level)) . " students found who match your Allocation Framework Special Group";
                                                     Yii::$app->session->setFlash('failure', $error_sms);
                                                     } */
                                            }
                                        } else {
                                            $error_sms .='No Special groups list configured in the Framework';
                                            Yii::$app->session->setFlash('failure', $error_sms);
                                        }
                                        exit;
                                        break;
                                        
                                        ////for allocating loan based on stident distribution matrix
                                    case AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION:
                                        // echo '############## STD DISTR MATRIX ALLOCATION SCENARIO #####--';
                                        $student_ratio = array();
                                        ///MOVING AROUNG THE SETTINGS FOR STUDENT DISTRIBUTION MATRIS
                                        //COLLECTING INFORMATION FROM THE EISTING ALLOCATION FRAMEWORK if clusters setting exists
                                        if ($gender_setting) {
                                            $max_number_of_females_to_award = $total_no_students_eligible * ($gender_setting->female_percentage / 100);
                                            $max_number_of_males_to_award = $total_no_students_eligible * ($gender_setting->male_percentage / 100);
                                            if (!is_integer($max_number_of_males_to_award)) {
                                                $max_number_of_males_to_award = floor($max_number_of_males_to_award);
                                            }
                                            if (!is_integer($max_number_of_females_to_award)) {
                                                $max_number_of_females_to_award = floor($max_number_of_females_to_award + 1);
                                            }
                                            $student_ratio['students_female'] = $max_number_of_females_to_award;
                                            $student_ratio['students_male'] = $max_number_of_males_to_award;
                                        }
                                        ///collecting student ration in PUBLIC vs PRIVATE institutions
                                        if ($student_ratio_in_institution) {
                                            foreach ($student_ratio_in_institution as $institution_ration) {
                                                switch ($institution_ration->institution_type) {
                                                    case \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_GOVT:
                                                        $max_no_student_in_public_institution = $total_no_students_eligible * ($institution_ration->student_distribution_percentage / 100);
                                                        if (!is_integer($max_no_student_in_public_institution)) {
                                                            $max_no_student_in_public_institution = floor($max_no_student_in_public_institution + 1);
                                                        }
                                                        $student_ratio['students_public_institution'] = $max_no_student_in_public_institution;
                                                        break;
                                                        
                                                    case \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_PRIVATE:
                                                        $max_no_student_in_provate_institution = $total_no_students_eligible * ($institution_ration->student_distribution_percentage / 100);
                                                        if (!is_integer($max_no_student_in_provate_institution)) {
                                                            $max_no_student_in_provate_institution = floor($max_no_student_in_provate_institution);
                                                        }
                                                        $student_ratio['students_private_institution'] = $max_no_student_in_provate_institution;
                                                        break;
                                                }
                                            }
                                        }
                                        ///WHEN CLUSTER SETTING EXIST, PROCESS STUDENT PER CLUSTER AND WITHIN CLUSTER CHECK STUDENT RATION SETTINGS
                                        //$clusters = AllocationPlanClusterSetting::getClusterSettingsByAlloationPlanID($model->allocation_framework_id); //Query here fromtable allocation_clusters order by clusters priority
                                        if ($clusters) {
                                            ////get students based on the cluster // loop clusters and get students nased on the available budget
                                            foreach ($clusters as $cluster) {
                                                //COUNTING THE NUMBER OF STUDENTS QUALIFYING FOR THE ALLOCATION PER CLUSTER
                                                $count_students = Application::countLocalFreshersStudentForAllocationByClusterIDAndCurrentAcademicYear($cluster->cluster_definition_id, $model);
                                                if ($count_students) {
                                                    ///echo '-----ALLOCATE BY CLUSTERS ---<br/>';
                                                    ////loop among the sudent list to allocate the loan zmount based on needness until when it is over
                                                    $index = $count_students / $maximum_data_to_process;
                                                    if (!is_integer($index)) {
                                                        $index = floor($index + 1);
                                                    }
                                                    $start_index = 0;
                                                    $end_index = $maximum_data_to_process;
                                                    ////setting up studenration per aech group starting from the clusters
                                                    //CHECKING STUDENT RATION CONFIGURATIONS BASED ON CLUSTER, GENDER AND INSTITUTION TYPE
                                                    $total_no_students_in_cluster = ($cluster->student_percentage_distribution / 100) * $total_no_students_eligible;
                                                    if (!is_integer($total_no_students_in_cluster)) {
                                                        $total_no_students_in_cluster = floor($total_no_students_in_cluster + 1);
                                                    }
                                                    $student_ratio['no_student_in_cluster'] = $total_no_students_in_cluster; // total no of student in a cluster
                                                    for ($i = 1; $i <= $index; $i++) {
                                                        /////get student per each special group and allocate loan
                                                        /// Query here from application with commination on Admission student to get a clean data
                                                        ///HERE Also check for contions to apply when getting the list of student.
                                                        //check for admission(confirmed/vs non confirmed, transfer info( completed/not completed,
                                                        //means testing information ( neednines, myfactor. ALWAYS ORDER STUDENT BASED ON NEEDINESS
                                                        // echo '######START INDEX QUERY=' . $start_index . '= END =' . $end_index . '<br/>---';
                                                        $students_for_allocation = Application::getLocalFreshersStudentForAllocationByClusterIDAndCurrentAcademicYear($cluster->cluster_definition_id, $model, $start_index, $end_index);
                                                        ///loooping among thre sstudents received
                                                        if ($this->processLocalFreshersLoan($model, $students_for_allocation, $allocation_loan_items_priority, $available_budget_amount, AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION, $student_ratio)) {
                                                            //$transaction->commit();
                                                            $start_index = ($i * $maximum_data_to_process) + 1;
                                                            $end_index = ($start_index + $maximum_data_to_process) - 1;
                                                            $success_sms .= 'Allocation based on Clusters Successful';
                                                            Yii::$app->session->setFlash('success', $success_sms);
                                                            $success++;
                                                            $this->redirect(['view', 'id' => $model->loan_allocation_history_id]);
                                                        } else {
                                                            $error_sms .= 'Allocation Based on Clusters failed, Please check';
                                                            Yii::$app->session->setFlash('failure', $error_sms);
                                                            //$transaction->rollBack();
                                                        }
                                                    }
                                                } else {
                                                    //return sms to the user that there are no student based on the criteria
                                                    $error_sms .="No students found Matching Allocation Framework Cluster " . $cluster->clusterDefinition->cluster_name;
                                                    Yii::$app->session->setFlash('failure', $error_sms);
                                                }
                                            }
                                        } else {
                                            
                                            ///DEFAULT WHEN CLUSTERS SETTING DOESNOT EXIST, PROCESS STUDENT BASED ON INSTITUTION TYPE FOLLOWD BY GENDER SETTING
                                            if ($student_ratio_in_institution && !$clusters) {
                                                //echo '---ALLOCATE BY INSTITUTION TYPE---';
                                                ///WHEN STUDENT RATION BY INSTITUTION TYPE IS SET WHILE CLUSTER SETTING DOESNOT EXIST
                                                //COLLECTING STUDENT RATIONS INFORMATION BASED ON INSTITUTION TYPE AND GENDER SETTING
                                                $student_ratio['no_student_in_cluster'] = NULL; //NO CLUSTER SETTING HENCE,TOTAL of student ALLOWED FOR ALLOCATION in a cluster IS NULL
                                            } else if ($gender_setting && !$clusters && !$student_ratio_in_institution) {
                                                //echo 'ALLOCATE BY STUDENT GENDER';
                                                ///WHEN NO CLUSTERS SETTING & NO STUDENT RATION PER INSTITUTION TYPE, PROCESS STUDENT BASED ON GENDER RATION ONLY
                                                $male_percentage = $gender_setting->male_percentage;
                                                $female_percentage = $gender_setting->female_percentage;
                                                $max_number_of_males_to_award = $total_no_students_eligible * ($male_percentage / 100);
                                                if (!is_integer($max_number_of_males_to_award)) {
                                                    $max_number_of_males_to_award = floor($max_number_of_males_to_award + 1);
                                                }
                                                $max_number_of_females_to_award = $total_no_students_eligible * ($female_percentage / 100);
                                                if (!is_integer($max_number_of_females_to_award)) {
                                                    $max_number_of_females_to_award = floor($max_number_of_females_to_award + 1);
                                                }
                                                $student_ratio = [
                                                    'students_female' => $max_number_of_females_to_award,
                                                    'students_male' => $max_number_of_males_to_award,
                                                    'no_student_in_cluster' => NULL, // total number of students that should be in the luster
                                                    'students_private_institution' => NULL, //total maximumnumber of student in public institution
                                                    'students_public_institution' => NULL, ///total maximum no of studnt in private institutions
                                                ];
                                            }
                                            ///PROCESSING STUDENTS BASED INSTITUTION TYPE AND GEMDER SETTING
                                            if ($total_no_students_eligible) {
                                                ////loop among the sudent list to allocate the loan zmount based on needness until when it is over
                                                $index = $total_no_students_eligible / $maximum_data_to_process;
                                                if (!is_integer($index)) {
                                                    $index = floor($index + 1);
                                                }
                                                $start_index = 0;
                                                $end_index = $maximum_data_to_process;
                                                //echo 'TOTAL STRUDENTS -ELIGIBLE=' . $total_no_students_eligible . '----<br/>';
                                                for ($i = 1; $i <= $index; $i++) {
                                                    //echo '######START INDEX QUERY=' . $start_index . '= END =' . $end_index . '<br/>---';
                                                    
                                                    $students_for_allocation = Application::getLocalFreshersStudentForAllocationByCurrentAcademicYear(NULL, $model, $start_index, $end_index);
                                                    ////PROCESSING THE ALLOCATION STUDENTS AVAILABLE QUALIFYING FOR THE AWARD
                                                    if ($this->processLocalFreshersLoan($model, $students_for_allocation, $allocation_loan_items_priority, $available_budget_amount, AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION, $student_ratio)) {
                                                        //$transaction->commit();
                                                        $start_index = ($i * $maximum_data_to_process) + 1;
                                                        $end_index = ($start_index + $maximum_data_to_process) - 1;
                                                        $success_sms .= 'Allocation By  Gender or Institution Type Successful';
                                                        $success++;
                                                        //$this->redirect(['view', 'id' => $model->loan_allocation_history_id]);
                                                    } else {
                                                        // echo '--FAILED CASE==<br/>';
                                                        $error_sms .= 'Allocation failed, Please check student data based on Gender or Institution type';
                                                        // Yii::$app->session->setFlash('failure', $sms);
                                                        //$transaction->rollBack();
                                                    }
                                                }
                                            } else {
                                                $error_sms .='No Students Eligible for Allocation';
                                            }
                                            ///END PROCESSINF STUDENTD
                                        }
                                        break;
                                }
                            }
                            if ($success) {
                                $transaction->commit();
                                
                                $sms = 'Allocation Successful Please check the Allocation framework to see the list of student allocated';
                                Yii::$app->session->setFlash('success', $sms);
                                return $this->redirect(['view', 'id' => $model->loan_allocation_history_id]);
                            } else {
                                //
                                //return $this->redirect(['view', 'id' => $model->loan_allocation_history_id]);
                                
                                $transaction->rollBack();
                                $sms = 'Allocation Process failed Please check your data';
                                $sms .= '; ' . $error_sms;
                                Yii::$app->session->setFlash('failure', $sms);
                            }
                        } catch (\yii\base\Exception $e) {
                            //roll back the transaction in case there s somethign wrong
                            $error_sms = "System Error: " . $e . "occured";
                            Yii::$app->session->setFlash('failure', $error_sms);
                            $transaction->rollBack();
                            //                            throw $e;
                        }
                    } else {
                        //setting error sms for the case when there no  budget allocate
                        $smms = "Please make sure all the required Items for the allocation plan has been set/configured correctly";
                        Yii::$app->session->setFlash('failure', $smms);
                    }
                } else {
                    //setting error sms for the case when there no  budget allocated
                    Yii::$app->session->setFlash('failure', "No Execution plan/order or Loan Item Priotity settings for the selected allocation plan/framework");
                }
            } else {
                //setting error sms for the case when there no  budget allocated
                $error_sms = "No Budget allocated for " . strtoupper(ApplicantCategory::getNameByID($model->study_level) . ' Freshers') . " Student for this Academic year";
                Yii::$app->session->setFlash('failure', $error_sms);
            }
        }
        
        return $this->render('allocate', ['model' => $model, 'tab' => 'tab1'
        ]);
    }
    
    /*
     * function to process local students Loan
     * $students_for_allocation = $stident models that need to be allocated loan
     * $allocationScenarion :type of allocation execution scenario (spceial groups or student distribution matrix)
     */
    
    function processLocalFreshersLoan($model, $students_for_allocation, $allocation_loan_items_priority, $available_budget_amount, $allocationScenario, $student_ratio = NULL) {
        $count_loan_items_awarded = 0; ///keep the counts of the itemd alocated for a student
        $minimum_allowed_loan = 5001; ///seting the minimum allowed loan amount for a student
        $minimum_allowed_TU = 2000; ///the minimum allowed loan for Tuition fee for a studen
        $minimum_allowed_BS = 1000;
       
        $minimum_allowed_loan = \backend\modules\allocation\models\SystemSetting::getItemSettingsValueByCodeemSettingByCode('LA'); /// the minimum allowed loan for Books and Stationary
        $minimum_allowed_TU = \backend\modules\allocation\models\SystemSetting::getItemSettingsValueByCodeemSettingByCode('TU');
        $minimum_allowed_BS = \backend\modules\allocation\models\SystemSetting::getItemSettingsValueByCodeemSettingByCode('BS');
        
        $minimum_allowed_BS . '=' . $minimum_allowed_TU;
        //exit;
        /////
        $number_of_females_awarded = $number_of_males_awarded = 0;  ///varibale will count students that are allocated loan in the alogorth
        $number_student_in_awarded_cluster = $numner_students_awarded_in_public_institution = $number_of_students_warded_in_private_institution = 0;
        $st = 1;
        foreach ($students_for_allocation as $allocation_student) {
            
            //echo '<br/>======STUDENT-' . $st . ' =' . $allocation_student->application_id . '<br/>';
            //             echo '<pre/>';
            //            var_dump($allocation_student->attributes);
            if($allocation_student->application_id==6){
              //  print_r($available_budget_amount);  
               // exit();
            }
            $st++;
            ///INITILIZING THE ALLOCATION PLAN STUDENT MODEL
            $allocation_plan_student_model = new AllocationPlanStudent;
            $allocation_plan_student_model->allocation_plan_id = $model->allocation_framework_id;
            $allocation_plan_student_model->allocation_history_id = $model->loan_allocation_history_id;
            $allocation_plan_student_model->application_id = $allocation_student->application_id;
            $allocation_plan_student_model->academic_year_id = $model->academic_year_id;
            $allocation_plan_student_model->study_year = $allocation_student->current_study_year;
            $allocation_plan_student_model->student_fee = $allocation_student->student_fee;
            $allocation_plan_student_model->student_fee_factor = $allocation_student->fee_factor;
            $allocation_plan_student_model->student_myfactor = $allocation_student->myfactor;
            $allocation_plan_student_model->programme_cost = $allocation_student->programme_cost;
            $allocation_plan_student_model->student_ability = $allocation_student->ability;
            $allocation_plan_student_model->needness_amount = $allocation_student->needness;
            $allocation_plan_student_model->programme_id = $allocation_student->programme_id;
            $allocation_plan_student_model->allocation_type = AllocationPlanStudent::ALLOCATION_TYPE_FIRST_TIME;
            $allocation_plan_student_model->total_allocated_amount = 0;
            $allocation_plan_student_model->student_fee = $allocation_student->student_fee;
           
            ///////////////////////
            /////////////////////////
            if ($allocation_plan_student_model->save()) {
                
                ////setting student needness
                switch ($allocationScenario) {
                    case AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP:
                        $student_needness = $allocation_student->programme_cost;
                        $reached_maximum_students_for_allocation = FALSE;
                        //echo'SPECIAL';
                        break;
                        
                    case AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION:
                        $student_needness = $allocation_student->needness;
                        /////CHECKING STUDENT RATIO BASED ON THE SETTING OF THE USED ALLOCATION PLAN
                        ///setting values based onthe cluster and institution type
                        ///VALIDATING IS MAX NUMBER OF STUDENT IN CLUSTER HAS NOT REACHED
                        $reached_maximum_students_for_allocation = FALSE;
                        if (isset($student_ratio['no_student_in_cluster']) && $student_ratio['no_student_in_cluster'] > 0) {
                            if (($number_student_in_awarded_cluster + 1) > $student_ratio['no_student_in_cluster']) {
                                $reached_maximum_students_for_allocation = TRUE;
                                $allocation_plan_student_model->comment .=' ; Reached Maximum number of student allowed in cluster';
                                //                                    $allocation_plan_student_loan_items_model->total_amount_awarded = 0; // allocate zero forstuden
                            }
                        } else if (isset($student_ratio['students_public_institution']) && $student_ratio['students_public_institution'] > 0 && isset($student_ratio['students_private_institution']) && $student_ratio['students_private_institution'] > 0) {
                            if ($student_ratio['students_public_institution'] > 0 && $allocation_student->programme->learningInstitution->ownership = \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_GOVT) {
                                if (($number_students_awarded_in_public_institution + 1) > $student_ratio['students_public_institution']) {
                                    //                      $allocation_plan_student_loan_items_model->total_amount_awarded = 0; // allocate zero forstuden
                                    $reached_maximum_students_for_allocation = TRUE;
                                    $allocation_plan_student_model->comment .=' ; Number of student exceed required ratio';
                                }
                            } else if ($student_ratio['students_private_institution'] > 0 && $allocation_student->programme->learningInstitution->ownership = \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_PRIVATE) {
                                if (($number_of_students_warded_in_private_institution + 1) > $student_ratio['students_private_institution']) {
                                    //                      $allocation_plan_student_loan_items_model->total_amount_awarded = 0; // allocate zero forstuden
                                    $reached_maximum_students_for_allocation = TRUE;
                                    $allocation_plan_student_model->comment .=' ; Number of student exceed required ratio';
                                }
                            }
                        } else if (isset($student_ratio['students_male']) && $student_ratio['students_male'] > 0 && isset($student_ratio['students_female']) && $student_ratio['students_male'] > 0) {
                            ///checking if the student male and female ration ration has been set
                            switch ($allocation_student->sex) {
                                case F:
                                    $number_of_females_awarded++;
                                    if (($number_of_females_awarded + 1) > $student_ratio['students_female']) {
                                        //                                            $allocation_plan_student_loan_items_model->total_amount_awarded = 0;
                                        $allocation_plan_student_model->comment .=' ; Maximum Number of student allowed in gender exceded';
                                        $reached_maximum_students_for_allocation = TRUE;
                                    }
                                    break;
                                    
                                case M:
                                    if (($number_of_males_awarded + 1) > $student_ratio['students_male']) {
                                        //                                            $allocation_plan_student_loan_items_model->total_amount_awarded = 0; // allocate zero forstuden
                                        $reached_maximum_students_for_allocation = TRUE;
                                        $allocation_plan_student_model->comment .=' ; Maximum Number of student allowed in gender exceded';
                                    }
                                    break;
                            }
                        }
                        break;
                        
                    default :
                        $student_needness = $allocation_student->needness;
                        $reached_maximum_students_for_allocation = FALSE;
                        break;
                }
                
                //                if ($reached_maximum_students_for_allocation) {
                //                    var_dump($allocation_plan_student_model->attributes);
                //                }
                //                echo '<br/>####BUDGET = Neediness=' . $student_needness . '= AVAILABLE BUDGET=' . $available_budget_amount . '<br/>';
                /////looping among the loan items to be allocated to student
                if (!$reached_maximum_students_for_allocation && $student_needness <= $available_budget_amount) {
                    // echo '--NDANI ---- <br/>';
                    
                    foreach ($allocation_loan_items_priority as $loan_item) {
                        // echo '##################LOOPING Loan Items Priority---<br/>';
                        //                        exit;
                        //getting student LoanItem Costs based on the student programme cost
                        $ProgrammeCost = \backend\modules\allocation\models\ProgrammeCost::getProgrammeLoanItemCostByAcademicYearProgrammeLoanItem($allocation_plan_student_model->academic_year_id, $allocation_student->programme_id, $loan_item->loan_item_id);
                      
                        if ($ProgrammeCost) {
                            ///INITIALIZING THE ALLOCATION PLAN STUDENT LOAN ITEM MODEL
                            //initiating the allocation plan student loan items alocation distribution model
                            $allocation_plan_student_loan_items_model = new AllocationPlanStudentLoanItem;
                            $allocation_plan_student_loan_items_model->allocation_plan_student_id = $allocation_plan_student_model->allocation_plan_student_id;
                            $allocation_plan_student_loan_items_model->loan_item_id = $loan_item->loan_item_id;
                            $allocation_plan_student_loan_items_model->priority_order = $loan_item->priority_order;
                            $allocation_plan_student_loan_items_model->loan_award_percentage = $loan_item->loan_award_percentage;
                            $allocation_plan_student_loan_items_model->rate_type = $ProgrammeCost->rate_type;
                            $allocation_plan_student_loan_items_model->unit_amount = $ProgrammeCost->unit_amount;
                            $allocation_plan_student_loan_items_model->duration = $ProgrammeCost->duration;
                            ///THE TOTAL AMOUNT REQIURED TO ALLOCATE PER STUDENT
                            $total_amount_to_allocate = ($ProgrammeCost->unit_amount * $ProgrammeCost->duration); //($loan_item->unit_amount * $loan_item->duration);
                            // echo '----<PROGRAMME LOAN ITEM COST ---><br/>';
                            if ($student_needness >= $minimum_allowed_loan && $available_budget_amount >= $total_amount_to_allocate) {
                                ///check Loan Items Specific Conditions for awarding
                                ///for special groups students their need ness is 100% the programme cost
                                
                                if ($student_needness == $allocation_student->programme_cost) {
                                    //give the student each and everythign as required.
                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                } else if ($allocation_plan_student_model->total_allocated_amount < $student_needness && $available_budget_amount >= $total_amount_to_allocate) {
                                    //if($allocation_student->needness>$total_amount_to_allocate){
                                    $remaining_needness = ($student_needness - $allocation_plan_student_model->total_allocated_amount);
                                    switch ($loan_item->item_code) {
                                        case 'MA' : ///meals and accomodation
                                            
                                            $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                            //   echo '==MA==' . $total_amount_to_allocate . '<br/>';
                                            break;
                                            
                                        case 'TU' : //Tution Fee
                                            
                                            if ($remaining_needness >= $minimum_allowed_TU) {
                                                if ($remaining_needness >= $total_amount_to_allocate) {
                                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                                } else {
                                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $remaining_needness;
                                                }
                                            } else {
                                                ///allocate zero if the minimum allowed TU is not reached
                                                $allocation_plan_student_loan_items_model->total_amount_awarded = 0;
                                                $allocation_plan_student_model->comment .= '; Needness is below Minimum allowed TU';
                                            }
                                            //   echo '== TU=' . $allocation_plan_student_loan_items_model->total_amount_awarded . '<br/>';
                                            break;
                                            
                                        case 'BS' : //Books & Stationary
                                            if ($remaining_needness >= $minimum_allowed_BS) {
                                                if ($remaining_needness >= $total_amount_to_allocate) {
                                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                                } else {
                                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $remaining_needness;
                                                }
                                            } else {
                                                ///allocate zero if the minimum allowed TU is not reached
                                                $allocation_plan_student_loan_items_model->total_amount_awarded = 0;
                                                $allocation_plan_student_model->comment .= '; Needness is below Minimum allowed BS';
                                            }
                                            // echo '== BS=' . $allocation_plan_student_loan_items_model->total_amount_awarded . '<br/>';
                                            break;
                                            
                                        default :
                                            
                                            if ($remaining_needness >= $total_amount_to_allocate) {
                                                $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                            } else {
                                                $allocation_plan_student_loan_items_model->total_amount_awarded = $remaining_needness;
                                            }
                                            //  echo '==DEFAULT=' . $allocation_plan_student_loan_items_model->total_amount_awarded . '<br/>';
                                            break;
                                    }
                                }
                            } else {
                                //allocate only means and accomodation
                                if ($loan_item->item_code == 'MA' && $available_budget_amount >= $total_amount_to_allocate) {
                                    //do not alocate loan to students withNeedness less that or eaqual to 500,000/=
                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                    $allocation_plan_student_model->comment .= '; Needness is below the minimum Loan';
                                    
                                    // echo '==MA=' . $allocation_plan_student_loan_items_model->total_amount_awarded . ' - Need Below allowed, budget exist<br/>';
                                } else {
                                    //do not alocate loan to students if budgete remaing is less that total amount to allocate
                                    $allocation_plan_student_loan_items_model->total_amount_awarded = 0;
                                    $allocation_plan_student_model->comment .= '; Needness is below the minimum loan';
                                    
                                    //echo '==MA=' . $allocation_plan_student_loan_items_model->total_amount_awarded . ' - Need Below allowed loan<br/>';
                                }
                            }
                            if ($allocation_plan_student_loan_items_model->total_amount_awarded > 0) {
                                //                                var_dump($allocation_plan_student_loan_items_model->attributes) . '<br/>';
                                if ($allocation_plan_student_loan_items_model->save()) {
                                    ///reducing the available budget
                                    $allocation_plan_student_model->total_allocated_amount +=$allocation_plan_student_loan_items_model->total_amount_awarded; ///updting the total allocated amount for student
                                    if ($allocation_plan_student_model->save()) { ///updating the total allocated amount for the allocation students model
                                        $count_loan_items_awarded++;
                                        $available_budget_amount -=$allocation_plan_student_loan_items_model->total_amount_awarded;  //updating the allocation budget available budget value
                                    }
                                }
                            } else {
                                $allocation_plan_student_model->save();
                                $count_loan_items_awarded++;
                            }
                        } else {
                            //echo 'No LOAN ITEM cost indicated per programme<br/>';
                            $allocation_plan_student_model->comment .= '; No Programme Cost Items';
                            $allocation_plan_student_model->save();
                        }
                    }
                    ///counting the numner off male/feale awarded
                    if ($allocation_plan_student_model->total_allocated_amount > 0) {
                        // echo 'STUDENT-' . $allocation_plan_student_model->application_id . ' allocated loan<br/>';
                        ///adding counts for gender ration
                        $count_allocated_student++;
                        switch ($allocation_student->sex) {
                            case F:
                                $number_of_females_awarded++;
                                break;
                                
                            case M:
                                $number_of_males_awarded++;
                                break;
                        }
                        ///adding counts for cluster
                        if (isset($student_ratio['no_student_in_cluster']) && $student_ratio['no_student_in_cluster'] > 0) {
                            $number_student_in_awarded_cluster++;
                        }
                        if (isset($student_ratio['students_public_institution']) && isset($student_ratio['students_private_institution'])) {
                            if ($student_ratio['students_public_institution'] > 0 && $allocation_student->programme->learningInstitution->ownership = \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_GOVT) {
                                $number_students_awarded_in_public_institution++;
                            } else if ($student_ratio['students_private_institution'] > 0 && $allocation_student->programme->learningInstitution->ownership = \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_PRIVATE) {
                                $number_of_students_warded_in_private_institution++;
                            }
                        }
                    } else {
                        $allocation_plan_student_model->comment .=' ; No Loan Allocated';
                        $allocation_plan_student_model->save();
                        $count_allocated_student++;
                        //echo 'STUDENT-' . $allocation_plan_student_model->application_id . ' Not allocated loan<br/>';
                    }
                } else {
                    $allocation_plan_student_model->total_allocated_amount = 0;
                    if ($reached_maximum_students_for_allocation) {
                        $allocation_plan_student_model->comment .=' ; Maximum No of student allowed in to allocated reached';
                    }
                    //                    var_dump($allocation_plan_student_model->attributes);
                    //                    exit;
                    if ($allocation_plan_student_model->save()) {
                        $count_allocated_student++;
                    }
                }
                //////
            }
        }
        return $count_allocated_student; ///returns tr number of allocated student
        //        if ($count_loan_items_awarded) {
        //            return TRUE;
        //        }
        //        return FALSE;
    }
    
/*
    public function actionAllocateLocalFreshers()
    {
        $model = new AllocationHistory();
        $model->scenario = 'local-freshers'; // setting th scenario for validation of the allocation framework
        $model->student_type = AllocationHistory::STUDENT_TYPE_NORMAL; // setting defaultstudent type to normal
        $model->place_of_study = AllocationHistory::PLACE_TZ; // //setting detault place/country of study to be TZ for local normal student
        $model->academic_year_id = \backend\modules\allocation\models\AcademicYear::getCurrentYearID();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // /checking id thereis a loan amount allocated for the given academic year
            $loan_budget = AllocationBudget::getAllocationBudgetByAcademicYearApplicantCategoryStudyLevelPlaceOfStudy($model->academic_year_id, AllocationBudget::APPLICANT_CATEGORY_NORMAL, $model->study_level, AllocationBudget::PLACE_OF_STUDY_TZ);

            if ($loan_budget) {

                // //when budget available continue with other steps
                // /GET ALLOCATION FRAMEWORK==check it fromallocation plan scenatios table
                $allocation_execution_order = AllocationPlanScenario::getFrameworkExecutionOrderByFrameworkId($model->allocation_framework_id);
                // /fetch here the loan Item Priority setting based in the allocation framework
                $allocation_loan_items_priority = AllocationPlanLoanItem::getLoanItemsByAllocationFrameworkid($model->allocation_framework_id);
                // /validate if framwork exists
                if ($allocation_execution_order && $allocation_loan_items_priority) {
                    // /verify allocation execution order required items
                    $count_execution_order_items = count($allocation_execution_order);
                    $count_verified_execution_order_items = 0;
                    $special_groups = $clusters = $gender_setting = $student_ratio_in_institution = NULL;
                    // //setting current available budget
                    $available_budget_amount = $loan_budget->budget_amount;
                    // /total number of students eligible for loan in a given acadmic year
                    $total_no_students_eligible = Application::countEligibleFirstTimeApplicantsByAcademicYear($model->academic_year_id);

                    foreach ($allocation_execution_order as $execution_order_item) {

                        switch ($execution_order_item->allocation_scenario) {
                            // for allocating special groups
                            case AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP: // /allocate based on the special group configurations
                                $special_groups = AllocationPlanSpecialGroup::getSpecialGroupeByAllocationPlanID($model->allocation_framework_id);
                                if ($special_groups) {
                                    $count_verified_execution_order_items ++;
                                }

                                break;

                            case AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION: // /allocated based on student distribution matrix configurations

                                $clusters = AllocationPlanClusterSetting::getClusterSettingsByAlloationPlanID($model->allocation_framework_id); // Query here fromtable allocation_clusters order by clusters priority

                                $gender_setting = AllocationPlanGenderSetting::getGenderSettingsByAllocationPlanId($model->allocation_framework_id); // write function here to get data table allocation gender setting
                                $student_ratio_in_institution = AllocationPlanInstitutionTypeSetting::getInstitutionTypeSettingsByAllocationPlanId($model->allocation_framework_id); // / get the data for student ration based on the(pprivate/pubic institution)
                                if ($clusters or $gender_setting or $student_ratio_in_institution) {
                                    $count_verified_execution_order_items ++;
                                }

                                break;
                        }
                    }
                    if ($count_execution_order_items > 0 && ($count_execution_order_items == $count_verified_execution_order_items)) {
                        // getting current academic year
                        $current_cademic_year_id = \backend\modules\allocation\models\AcademicYear::getCurrentYearID();
                        $maximum_data_to_process = Yii::$app->params['allocation_maximum_data_to_process']; // /the maximum No of students that can be processed a one time in the allocation process
                                                                                                            // //STATING A TRANSACTION AND CREAITING THE ALLOCATION PLAN HISTORY IN THE TABLE
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {
                            // saving the alocation history model
                            $model->save();

                            // /LOOP WITHIN THE FRAMEWORK EXECUTION ORDER BASED ON
                            $success = 0; // count success allocationcases;
                            $error_sms = '';
                            $success_sms = '';
                            foreach ($allocation_execution_order as $execution_order) {
                                // checkingth type of execution ordercurrently executed
                                switch ($execution_order->allocation_scenario) {
                                    // for allocating special groups
                                    case AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP:
                                        // echo '########### SPECIAL GROUP ALLOCATION SCENARIO########<br/>';
                                        // ///get student special groups defined inthe allocation framework( table: allocation_plan_special_groups
                                        if ($special_groups) {
                                            // var_dump($special_groups);
                                            // /looping among the special groups
                                            foreach ($special_groups as $special_group) {
                                                // echo 'Group Criteria ID: ' . $special_group->allocation_group_criteria_id . '=' . $model->academic_year_id . '<br/>';
                                                $criteria = \backend\modules\allocation\models\Criteria::findOne($special_group->allocation_group_criteria_id);
                                                $criteria_fields = \backend\modules\allocation\models\CriteriaField::find()->select('criteria_field.criteria_id,source_table,source_table_field,operator,value,join_operator,')
                                                    ->join('INNER JOIN', 'criteria', 'criteria.criteria_id=criteria_field.criteria_id')
                                                    ->where([
                                                    'criteria_field.criteria_id' => $special_group->allocation_group_criteria_id,
                                                    'type' => 3,
                                                    'academic_year_id' => $model->academic_year_id,
                                                    'applicant_category_id' => $model->study_level
                                                ])
                                                    ->all();
                                                // var_dump($criteria_fields);
                                                if (is_object($criteria_fields)) {
                                                    $count = 1;
                                                    $count_objects = count($criteria_fields);
                                                    foreach ($criteria_fields as $field) {
                                                        $sql . $count = "(SELCT * FROM " . $field->source_table . " WHERE " . $field->source_table_field . " " . $field->operator . " '" . $field->value . "')";
                                                        if ($count_objects > 1 && ($count + 1 < $count_objects)) {
                                                            $sql . $count .= " " . $field->join_operator;
                                                        }
                                                        $count ++;
                                                    }
                                                }
                                                // COUNTING THE NUMBER OF STUDENTS QUALIFYING FOR THE ALLOCATION
                                                $count_students = Application::countLocalFreshersStudentForAllocationBySpecialGroupIdInCurrentAcademicYear($special_group->allocation_group_criteria_id, $model);

                                                /*
                                                 * if ($count_students) {
                                                 * ////loop among the sudent list to allocate the loan zmount based on needness until when it is over
                                                 * $index = $count_students / $maximum_data_to_process;
                                                 * if (!is_integer($index)) {
                                                 * $index = floor($index + 1);
                                                 * }
                                                 * $start_index = 0;
                                                 * $end_index = $maximum_data_to_process;
                                                 *
                                                 * for ($i = 1; $i <= $index; $i++) {
                                                 * /////get student per each special group and allocate loan
                                                 * /// Query here from application with commination on Admission student to get a clean data
                                                 * ///HERE Also check for contions to apply when getting the list of student.
                                                 * //check for admission(confirmed/vs non confirmed, transfer info( completed/not completed,
                                                 * //means testing information ( neednines, myfactor. ALWAYS ORDER STUDENT BASED ON NEEDINESS
                                                 * echo '######START INDEX QUERY=' . $start_index . '= END =' . $end_index;
                                                 * $students_for_allocation = Application::getLocalFreshersStudentForAllocationBySpecialGroupIdInCurrentAcademicYear($special_group->allocation_group_criteria_id, $model, $start_index, $end_index);
                                                 * /////loooping among thre sstudents received
                                                 * if ($this->processLocalFreshersLoan($model, $students_for_allocation, $allocation_loan_items_priority, $available_budget_amount, AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP)) {
                                                 * $transaction->commit();
                                                 * $start_index = ($i * $maximum_data_to_process) + 1;
                                                 * $end_index = ($start_index + $maximum_data_to_process) - 1;
                                                 * $success++;
                                                 * } else {
                                                 * $error_sms .= ' , Special Group Award/Allocation failed, Please check student data to be allocated';
                                                 * Yii::$app->session->setFlash('failure', $error_sms);
                                                 * $transaction->rollBack();
                                                 * }
                                                 * }
                                                 * } else {
                                                 * //return sms to the user that there are no student based on the criteria
                                                 * $error_sms .= " , No " . strtoupper(ApplicantCategory::getNameByID($model->study_level)) . " students found who match your Allocation Framework Special Group";
                                                 * Yii::$app->session->setFlash('failure', $error_sms);
                                                 * }
                                                 *
                                            }
                                        } else {
                                            $error_sms .= 'No Special groups list configured in the Framework';
                                            Yii::$app->session->setFlash('failure', $error_sms);
                                        }
                                        exit();
                                        break;

                                    // //for allocating loan based on stident distribution matrix
                                    case AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION:
                                        // echo '############## STD DISTR MATRIX ALLOCATION SCENARIO #####--';
                                        $student_ratio = array();
                                        // /MOVING AROUNG THE SETTINGS FOR STUDENT DISTRIBUTION MATRIS
                                        // COLLECTING INFORMATION FROM THE EISTING ALLOCATION FRAMEWORK if clusters setting exists
                                        if ($gender_setting) {
                                            $max_number_of_females_to_award = $total_no_students_eligible * ($gender_setting->female_percentage / 100);
                                            $max_number_of_males_to_award = $total_no_students_eligible * ($gender_setting->male_percentage / 100);
                                            if (! is_integer($max_number_of_males_to_award)) {
                                                $max_number_of_males_to_award = floor($max_number_of_males_to_award);
                                            }
                                            if (! is_integer($max_number_of_females_to_award)) {
                                                $max_number_of_females_to_award = floor($max_number_of_females_to_award + 1);
                                            }
                                            $student_ratio['students_female'] = $max_number_of_females_to_award;
                                            $student_ratio['students_male'] = $max_number_of_males_to_award;
                                        }
                                        // /collecting student ration in PUBLIC vs PRIVATE institutions
                                        if ($student_ratio_in_institution) {
                                            foreach ($student_ratio_in_institution as $institution_ration) {
                                                switch ($institution_ration->institution_type) {
                                                    case \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_GOVT:
                                                        $max_no_student_in_public_institution = $total_no_students_eligible * ($institution_ration->student_distribution_percentage / 100);
                                                        if (! is_integer($max_no_student_in_public_institution)) {
                                                            $max_no_student_in_public_institution = floor($max_no_student_in_public_institution + 1);
                                                        }
                                                        $student_ratio['students_public_institution'] = $max_no_student_in_public_institution;
                                                        break;

                                                    case \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_PRIVATE:
                                                        $max_no_student_in_provate_institution = $total_no_students_eligible * ($institution_ration->student_distribution_percentage / 100);
                                                        if (! is_integer($max_no_student_in_provate_institution)) {
                                                            $max_no_student_in_provate_institution = floor($max_no_student_in_provate_institution);
                                                        }
                                                        $student_ratio['students_private_institution'] = $max_no_student_in_provate_institution;
                                                        break;
                                                }
                                            }
                                        }
                                        // /WHEN CLUSTER SETTING EXIST, PROCESS STUDENT PER CLUSTER AND WITHIN CLUSTER CHECK STUDENT RATION SETTINGS
                                        // $clusters = AllocationPlanClusterSetting::getClusterSettingsByAlloationPlanID($model->allocation_framework_id); //Query here fromtable allocation_clusters order by clusters priority
                                        if ($clusters) {
                                            // //get students based on the cluster // loop clusters and get students nased on the available budget
                                            foreach ($clusters as $cluster) {
                                                // COUNTING THE NUMBER OF STUDENTS QUALIFYING FOR THE ALLOCATION PER CLUSTER
                                                $count_students = Application::countLocalFreshersStudentForAllocationByClusterIDAndCurrentAcademicYear($cluster->cluster_definition_id, $model);
                                                if ($count_students) {
                                                    // /echo '-----ALLOCATE BY CLUSTERS ---<br/>';
                                                    // //loop among the sudent list to allocate the loan zmount based on needness until when it is over
                                                    $index = $count_students / $maximum_data_to_process;
                                                    if (! is_integer($index)) {
                                                        $index = floor($index + 1);
                                                    }
                                                    $start_index = 0;
                                                    $end_index = $maximum_data_to_process;
                                                    // //setting up studenration per aech group starting from the clusters
                                                    // CHECKING STUDENT RATION CONFIGURATIONS BASED ON CLUSTER, GENDER AND INSTITUTION TYPE
                                                    $total_no_students_in_cluster = ($cluster->student_percentage_distribution / 100) * $total_no_students_eligible;
                                                    if (! is_integer($total_no_students_in_cluster)) {
                                                        $total_no_students_in_cluster = floor($total_no_students_in_cluster + 1);
                                                    }
                                                    $student_ratio['no_student_in_cluster'] = $total_no_students_in_cluster; // total no of student in a cluster
                                                    for ($i = 1; $i <= $index; $i ++) {
                                                        // ///get student per each special group and allocate loan
                                                        // / Query here from application with commination on Admission student to get a clean data
                                                        // /HERE Also check for contions to apply when getting the list of student.
                                                        // check for admission(confirmed/vs non confirmed, transfer info( completed/not completed,
                                                        // means testing information ( neednines, myfactor. ALWAYS ORDER STUDENT BASED ON NEEDINESS
                                                        // echo '######START INDEX QUERY=' . $start_index . '= END =' . $end_index . '<br/>---';
                                                        $students_for_allocation = Application::getLocalFreshersStudentForAllocationByClusterIDAndCurrentAcademicYear($cluster->cluster_definition_id, $model, $start_index, $end_index);
                                                        // /loooping among thre sstudents received
                                                        if ($this->processLocalFreshersLoan($model, $students_for_allocation, $allocation_loan_items_priority, $available_budget_amount, AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION, $student_ratio)) {
                                                            // $transaction->commit();
                                                            $start_index = ($i * $maximum_data_to_process) + 1;
                                                            $end_index = ($start_index + $maximum_data_to_process) - 1;
                                                            $success_sms .= 'Allocation based on Clusters Successful';
                                                            Yii::$app->session->setFlash('success', $success_sms);
                                                            $success ++;
                                                            $this->redirect([
                                                                'view',
                                                                'id' => $model->loan_allocation_history_id
                                                            ]);
                                                        } else {
                                                            $error_sms .= 'Allocation Based on Clusters failed, Please check';
                                                            Yii::$app->session->setFlash('failure', $error_sms);
                                                            // $transaction->rollBack();
                                                        }
                                                    }
                                                } else {
                                                    // return sms to the user that there are no student based on the criteria
                                                    $error_sms .= "No students found Matching Allocation Framework Cluster " . $cluster->clusterDefinition->cluster_name;
                                                    Yii::$app->session->setFlash('failure', $error_sms);
                                                }
                                            }
                                        } else {
                                            // /DEFAULT WHEN CLUSTERS SETTING DOESNOT EXIST, PROCESS STUDENT BASED ON INSTITUTION TYPE FOLLOWD BY GENDER SETTING
                                            if ($student_ratio_in_institution && ! $clusters) {
                                                // echo '---ALLOCATE BY INSTITUTION TYPE---';
                                                // /WHEN STUDENT RATION BY INSTITUTION TYPE IS SET WHILE CLUSTER SETTING DOESNOT EXIST
                                                // COLLECTING STUDENT RATIONS INFORMATION BASED ON INSTITUTION TYPE AND GENDER SETTING
                                                $student_ratio['no_student_in_cluster'] = NULL; // NO CLUSTER SETTING HENCE,TOTAL of student ALLOWED FOR ALLOCATION in a cluster IS NULL
                                            } else if ($gender_setting && ! $clusters && ! $student_ratio_in_institution) {
                                                // echo 'ALLOCATE BY STUDENT GENDER';
                                                // /WHEN NO CLUSTERS SETTING & NO STUDENT RATION PER INSTITUTION TYPE, PROCESS STUDENT BASED ON GENDER RATION ONLY
                                                $male_percentage = $gender_setting->male_percentage;
                                                $female_percentage = $gender_setting->female_percentage;
                                                $max_number_of_males_to_award = $total_no_students_eligible * ($male_percentage / 100);
                                                if (! is_integer($max_number_of_males_to_award)) {
                                                    $max_number_of_males_to_award = floor($max_number_of_males_to_award + 1);
                                                }
                                                $max_number_of_females_to_award = $total_no_students_eligible * ($female_percentage / 100);
                                                if (! is_integer($max_number_of_females_to_award)) {
                                                    $max_number_of_females_to_award = floor($max_number_of_females_to_award + 1);
                                                }
                                                $student_ratio = [
                                                    'students_female' => $max_number_of_females_to_award,
                                                    'students_male' => $max_number_of_males_to_award,
                                                    'no_student_in_cluster' => NULL, // total number of students that should be in the luster
                                                    'students_private_institution' => NULL, // total maximumnumber of student in public institution
                                                    'students_public_institution' => NULL // /total maximum no of studnt in private institutions
                                                ];
                                            }
                                            // /PROCESSING STUDENTS BASED INSTITUTION TYPE AND GEMDER SETTING

                                            if ($total_no_students_eligible) {
                                                // //loop among the sudent list to allocate the loan zmount based on needness until when it is over
                                                $index = $total_no_students_eligible / $maximum_data_to_process;
                                                if (! is_integer($index)) {
                                                    $index = floor($index + 1);
                                                }
                                                $start_index = 0;
                                                $end_index = $maximum_data_to_process;
                                                // echo 'TOTAL STRUDENTS -ELIGIBLE=' . $total_no_students_eligible . '----<br/>';
                                                for ($i = 1; $i <= $index; $i ++) {
                                                    // echo '######START INDEX QUERY=' . $start_index . '= END =' . $end_index . '<br/>---';

                                                    $students_for_allocation = Application::getLocalFreshersStudentForAllocationByCurrentAcademicYear(NULL, $model, $start_index, $end_index);
                                                    // //PROCESSING THE ALLOCATION STUDENTS AVAILABLE QUALIFYING FOR THE AWARD
                                                    if ($this->processLocalFreshersLoan($model, $students_for_allocation, $allocation_loan_items_priority, $available_budget_amount, AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION, $student_ratio)) {
                                                        // $transaction->commit();
                                                        $start_index = ($i * $maximum_data_to_process) + 1;
                                                        $end_index = ($start_index + $maximum_data_to_process) - 1;
                                                        $success_sms .= 'Allocation By  Gender or Institution Type Successful';
                                                        $success ++;
                                                        // $this->redirect(['view', 'id' => $model->loan_allocation_history_id]);
                                                    } else {
                                                        // echo '--FAILED CASE==<br/>';
                                                        $error_sms .= 'Allocation failed, Please check student data based on Gender or Institution type';
                                                        // Yii::$app->session->setFlash('failure', $sms);
                                                        // $transaction->rollBack();
                                                    }
                                                }
                                            }
                                            // /END PROCESSINF STUDENTD
                                        }
                                        break;
                                }
                            }
                            if ($success) {
                                $transaction->commit();
                                echo 'HUMUUUU';
                                $sms = 'Allocation Successful Please check the Allocation framework to see the list of student allocated';
                                Yii::$app->session->setFlash('success', $sms);
                                return $this->redirect([
                                    'view',
                                    'id' => $model->loan_allocation_history_id
                                ]);
                            } else {
                                
                                //exit();
                                return $this->redirect([
                                    'view',
                                    'id' => $model->loan_allocation_history_id
                                ]);

                                $transaction->rollBack();
                                $sms = 'Allocation Process failed Please check your data';
                                $sms .= '; ' . $error_sms;
                                Yii::$app->session->setFlash('failure', $sms);
                            }
                        } catch (\yii\base\Exception $e) {
                            // roll back the transaction in case there s somethign wrong
                            $error_sms = "System Error: " . $e . "occured";
                            Yii::$app->session->setFlash('failure', $error_sms);
                            $transaction->rollBack();
                            // throw $e;
                        }
                    } else {
                        // setting error sms for the case when there no budget allocated
                        Yii::$app->session->setFlash('failure', "Please make sure all the required Items for the allocation plan has been set/configured correctly");
                    }
                } else {
                    // setting error sms for the case when there no budget allocated
                    Yii::$app->session->setFlash('failure', "No Execution plan/order or Loan Item Priotity settings for the selected allocation plan/framework");
                }
            } else {
                // setting error sms for the case when there no budget allocated
                $error_sms = "No Budget allocated for " . strtoupper(ApplicantCategory::getNameByID($model->study_level) . ' Freshers') . " Student for this Academic year";
                Yii::$app->session->setFlash('failure', $error_sms);
            }
        }

        return $this->render('allocate', [
            'model' => $model,
            'tab' => 'tab1'
        ]);
    }

    /*
     * function to process local students Loan
     * $students_for_allocation = $stident models that need to be allocated loan
     * $allocationScenarion :type of allocation execution scenario (spceial groups or student distribution matrix)
     */
   /* function processLocalFreshersLoan($model, $students_for_allocation, $allocation_loan_items_priority, $available_budget_amount, $allocationScenario, $student_ratio = NULL)
    {
        $count_loan_items_awarded = 0; // /keep the counts of the itemd alocated for a student
        $minimum_allowed_loan = 5001; // /seting the minimum allowed loan amount for a student
        $minimum_allowed_TU = 2000; // /the minimum allowed loan for Tuition fee for a studen
        $minimum_allowed_BS = 1000; // / the minimum allowed loan for Books and Stationary
        $number_of_females_awarded = $number_of_males_awarded = 0; // /varibale will count students that are allocated loan in the alogorth
        $number_student_in_awarded_cluster = $numner_students_awarded_in_public_institution = $number_of_students_warded_in_private_institution = 0;
        $st = 1;
        foreach ($students_for_allocation as $allocation_student) {

            // echo '<br/>======STUDENT-' . $st . ' =' . $allocation_student->application_id . '<br/>';
            // echo '<pre/>';
            // var_dump($allocation_student->attributes);
            $st ++;
            // /INITILIZING THE ALLOCATION PLAN STUDENT MODEL
            $allocation_plan_student_model = new AllocationPlanStudent();
            $allocation_plan_student_model->allocation_plan_id = $model->allocation_framework_id;
            $allocation_plan_student_model->allocation_history_id = $model->loan_allocation_history_id;
            $allocation_plan_student_model->application_id = $allocation_student->application_id;
            $allocation_plan_student_model->academic_year_id = $model->academic_year_id;
            $allocation_plan_student_model->study_year = $allocation_student->current_study_year;
            $allocation_plan_student_model->student_fee = $allocation_student->student_fee;
            $allocation_plan_student_model->student_fee_factor = $allocation_student->fee_factor;
            $allocation_plan_student_model->student_myfactor = $allocation_student->myfactor;
            $allocation_plan_student_model->programme_cost = $allocation_student->programme_cost;
            $allocation_plan_student_model->student_ability = $allocation_student->ability;
            $allocation_plan_student_model->needness_amount = $allocation_student->needness;
            $allocation_plan_student_model->programme_id = $allocation_student->programme_id;
            $allocation_plan_student_model->allocation_type = AllocationPlanStudent::ALLOCATION_TYPE_FIRST_TIME;
            $allocation_plan_student_model->total_allocated_amount = 0;
            $allocation_plan_student_model->student_fee = $allocation_student->student_fee;
            // /////////////////////
            // ///////////////////////
            if ($allocation_plan_student_model->save()) {

                // //setting student needness
                switch ($allocationScenario) {
                    case AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP:
                        $student_needness = $allocation_student->programme_cost;
                        $reached_maximum_students_for_allocation = FALSE;
                        // echo'SPECIAL';
                        break;

                    case AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION:
                        $student_needness = $allocation_student->needness;
                        // ///CHECKING STUDENT RATIO BASED ON THE SETTING OF THE USED ALLOCATION PLAN
                        // /setting valudes based onthe cluster and institution type
                        // /VALIDATING IS MAX NUBER OF STUDENTIN CLUSTER HAS NOT REACHED
                        $reached_maximum_students_for_allocation = FALSE;
                        if (isset($student_ratio['no_student_in_cluster']) && $student_ratio['no_student_in_cluster'] > 0) {
                            if (($number_student_in_awarded_cluster + 1) > $student_ratio['no_student_in_cluster']) {
                                $reached_maximum_students_for_allocation = TRUE;
                                $allocation_plan_student_model->comment .= ' ; Reached Maximum number of student allowed in cluster';
                                // $allocation_plan_student_loan_items_model->total_amount_awarded = 0; // allocate zero forstuden
                            }
                        } else if (isset($student_ratio['students_public_institution']) && $student_ratio['students_public_institution'] > 0 && isset($student_ratio['students_private_institution']) && $student_ratio['students_private_institution'] > 0) {
                            if ($student_ratio['students_public_institution'] > 0 && $allocation_student->programme->learningInstitution->ownership = \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_GOVT) {
                                if (($number_students_awarded_in_public_institution + 1) > $student_ratio['students_public_institution']) {
                                    // $allocation_plan_student_loan_items_model->total_amount_awarded = 0; // allocate zero forstuden
                                    $reached_maximum_students_for_allocation = TRUE;
                                    $allocation_plan_student_model->comment .= ' ; Number of student exceed required ratio';
                                }
                            } else if ($student_ratio['students_private_institution'] > 0 && $allocation_student->programme->learningInstitution->ownership = \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_PRIVATE) {
                                if (($number_of_students_warded_in_private_institution + 1) > $student_ratio['students_private_institution']) {
                                    // $allocation_plan_student_loan_items_model->total_amount_awarded = 0; // allocate zero forstuden
                                    $reached_maximum_students_for_allocation = TRUE;
                                    $allocation_plan_student_model->comment .= ' ; Number of student exceed required ratio';
                                }
                            }
                        } else if (isset($student_ratio['students_male']) && $student_ratio['students_male'] > 0 && isset($student_ratio['students_female']) && $student_ratio['students_male'] > 0) {
                            // /checking if the student male and female ration ration has been set
                            switch ($allocation_student->sex) {
                                case F:
                                    $number_of_females_awarded ++;
                                    if (($number_of_females_awarded + 1) > $student_ratio['students_female']) {
                                        // $allocation_plan_student_loan_items_model->total_amount_awarded = 0;
                                        $allocation_plan_student_model->comment .= ' ; Maximum No of student allowed in gender exceded';
                                        $reached_maximum_students_for_allocation = TRUE;
                                    }
                                    break;

                                case M:
                                    if (($number_of_males_awarded + 1) > $student_ratio['students_male']) {
                                        // $allocation_plan_student_loan_items_model->total_amount_awarded = 0; // allocate zero forstuden
                                        $reached_maximum_students_for_allocation = TRUE;
                                        $allocation_plan_student_model->comment .= ' ; Maximum No of student allowed in gender exceded';
                                    }
                                    break;
                            }
                        }
                        break;

                    default:
                        $student_needness = $allocation_student->needness;
                        $reached_maximum_students_for_allocation = FALSE;
                        break;
                }

                // if ($reached_maximum_students_for_allocation) {
                // var_dump($allocation_plan_student_model->attributes);
                // }
                // echo '<br/>####BUDGET = Neediness=' . $student_needness . '= AVAILABLE BUDGET=' . $available_budget_amount . '<br/>';
                // ///looping among the loan items to be allocated to student
                if (! $reached_maximum_students_for_allocation && $student_needness <= $available_budget_amount) {
                    // echo '--NDANI ---- <br/>';

                    foreach ($allocation_loan_items_priority as $loan_item) {
                        // echo '##################LOOPING Loan Items Priority---<br/>';
                        // exit;
                        // getting student LoanItem Costs based on the student programme cost
                        $ProgrammeCost = \backend\modules\allocation\models\ProgrammeCost::getProgrammeLoanItemCostByAcademicYearProgrammeLoanItem($allocation_plan_student_model->academic_year_id, $allocation_student->programme_id, $loan_item->loan_item_id);
                        if ($ProgrammeCost) {
                            // /INITIALIZING THE ALLOCATION PLAN STUDENT LOAN ITEM MODEL
                            // initiating the allocation plan student loan items alocation distribution model
                            $allocation_plan_student_loan_items_model = new AllocationPlanStudentLoanItem();
                            $allocation_plan_student_loan_items_model->allocation_plan_student_id = $allocation_plan_student_model->allocation_plan_student_id;
                            $allocation_plan_student_loan_items_model->loan_item_id = $loan_item->loan_item_id;
                            $allocation_plan_student_loan_items_model->priority_order = $loan_item->priority_order;
                            $allocation_plan_student_loan_items_model->loan_award_percentage = $loan_item->loan_award_percentage;
                            $allocation_plan_student_loan_items_model->rate_type = $ProgrammeCost->rate_type;
                            $allocation_plan_student_loan_items_model->unit_amount = $ProgrammeCost->unit_amount;
                            $allocation_plan_student_loan_items_model->duration = $ProgrammeCost->duration;
                            // /THE TOTAL AMOUNT REQIURED TO ALLOCATE PER STUDENT
                            $total_amount_to_allocate = ($ProgrammeCost->unit_amount * $ProgrammeCost->duration); // ($loan_item->unit_amount * $loan_item->duration);
                                                                                                                  // echo '----<PROGRAMME LOAN ITEM COST ---><br/>';
                            if ($student_needness >= $minimum_allowed_loan && $available_budget_amount >= $total_amount_to_allocate) {
                                // /check Loan Items Specific Conditions for awarding
                                // /for special groups students their need ness is 100% the programme cost

                                if ($student_needness == $allocation_student->programme_cost) {
                                    // give the student each and everythign as required.
                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                } else if ($allocation_plan_student_model->total_allocated_amount < $student_needness && $available_budget_amount >= $total_amount_to_allocate) {
                                    // if($allocation_student->needness>$total_amount_to_allocate){
                                    $remaining_needness = ($student_needness - $allocation_plan_student_model->total_allocated_amount);
                                    switch ($loan_item->item_code) {
                                        case 'MA': // /meals and accomodation

                                            $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                            // echo '==MA==' . $total_amount_to_allocate . '<br/>';
                                            break;

                                        case 'TU': // Tution Fee

                                            if ($remaining_needness >= $minimum_allowed_TU) {
                                                if ($remaining_needness >= $total_amount_to_allocate) {
                                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                                } else {
                                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $remaining_needness;
                                                }
                                            } else {
                                                // /allocate zero if the minimum allowed TU is not reached
                                                $allocation_plan_student_loan_items_model->total_amount_awarded = 0;
                                                $allocation_plan_student_model->comment .= '; Needness is below Minimum allowed TU';
                                            }
                                            // echo '== TU=' . $allocation_plan_student_loan_items_model->total_amount_awarded . '<br/>';
                                            break;

                                        case 'BS': // Books & Stationary
                                            if ($remaining_needness >= $minimum_allowed_BS) {
                                                if ($remaining_needness >= $total_amount_to_allocate) {
                                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                                } else {
                                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $remaining_needness;
                                                }
                                            } else {
                                                // /allocate zero if the minimum allowed TU is not reached
                                                $allocation_plan_student_loan_items_model->total_amount_awarded = 0;
                                                $allocation_plan_student_model->comment .= '; Needness is below Minimum allowed BS';
                                            }
                                            // echo '== BS=' . $allocation_plan_student_loan_items_model->total_amount_awarded . '<br/>';
                                            break;

                                        default:

                                            if ($remaining_needness >= $total_amount_to_allocate) {
                                                $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                            } else {
                                                $allocation_plan_student_loan_items_model->total_amount_awarded = $remaining_needness;
                                            }
                                            // echo '==DEFAULT=' . $allocation_plan_student_loan_items_model->total_amount_awarded . '<br/>';
                                            break;
                                    }
                                }
                            } else {
                                // allocate only means and accomodation
                                if ($loan_item->item_code == 'MA' && $available_budget_amount >= $total_amount_to_allocate) {
                                    // do not alocate loan to students withNeedness less that or eaqual to 500,000/=
                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                    $allocation_plan_student_model->comment .= '; Needness is below the minimum Loan';

                                    // echo '==MA=' . $allocation_plan_student_loan_items_model->total_amount_awarded . ' - Need Below allowed, budget exist<br/>';
                                } else {
                                    // do not alocate loan to students if budgete remaing is less that total amount to allocate
                                    $allocation_plan_student_loan_items_model->total_amount_awarded = 0;
                                    $allocation_plan_student_model->comment .= '; Needness is below the minimum loan';

                                    // echo '==MA=' . $allocation_plan_student_loan_items_model->total_amount_awarded . ' - Need Below allowed loan<br/>';
                                }
                            }
                            if ($allocation_plan_student_loan_items_model->total_amount_awarded > 0) {
                                // var_dump($allocation_plan_student_loan_items_model->attributes) . '<br/>';
                                if ($allocation_plan_student_loan_items_model->save()) {
                                    // /reducing the available budget
                                    $allocation_plan_student_model->total_allocated_amount += $allocation_plan_student_loan_items_model->total_amount_awarded; // /updting the total allocated amount for student
                                    if ($allocation_plan_student_model->save()) { // /updating the total allocated amount for the allocation students model
                                        $count_loan_items_awarded ++;
                                        $available_budget_amount -= $allocation_plan_student_loan_items_model->total_amount_awarded; // updating the allocation budget available budget value
                                    }
                                }
                            } else {
                                $allocation_plan_student_model->save();
                                $count_loan_items_awarded ++;
                            }
                        } else {
                            // echo 'No LOAN ITEM cost indicated per programme<br/>';
                            $allocation_plan_student_model->comment .= '; No Programme Cost Items';
                            $allocation_plan_student_model->save();
                        }
                    }
                    // /counting the numner off male/feale awarded
                    if ($allocation_plan_student_model->total_allocated_amount > 0) {
                        // echo 'STUDENT-' . $allocation_plan_student_model->application_id . ' allocated loan<br/>';
                        // /adding counts for gender ration
                        $count_allocated_student ++;
                        switch ($allocation_student->sex) {
                            case F:
                                $number_of_females_awarded ++;
                                break;

                            case M:
                                $number_of_males_awarded ++;
                                break;
                        }
                        // /adding counts for cluster
                        if (isset($student_ratio['no_student_in_cluster']) && $student_ratio['no_student_in_cluster'] > 0) {
                            $number_student_in_awarded_cluster ++;
                        }
                        if (isset($student_ratio['students_public_institution']) && isset($student_ratio['students_private_institution'])) {
                            if ($student_ratio['students_public_institution'] > 0 && $allocation_student->programme->learningInstitution->ownership = \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_GOVT) {
                                $number_students_awarded_in_public_institution ++;
                            } else if ($student_ratio['students_private_institution'] > 0 && $allocation_student->programme->learningInstitution->ownership = \backend\modules\allocation\models\LearningInstitution::INSTITUTION_OWNER_PRIVATE) {
                                $number_of_students_warded_in_private_institution ++;
                            }
                        }
                    } else {
                        $allocation_plan_student_model->comment .= ' ; No Loan Allocated';
                        $allocation_plan_student_model->save();
                        $count_allocated_student ++;
                        // echo 'STUDENT-' . $allocation_plan_student_model->application_id . ' Not allocated loan<br/>';
                    }
                } else {
                    $allocation_plan_student_model->total_allocated_amount = 0;
                    if ($reached_maximum_students_for_allocation) {
                        $allocation_plan_student_model->comment .= ' ; Maximum No of student allowed in to allocated reached';
                    }
                    // var_dump($allocation_plan_student_model->attributes);
                    // exit;
                    if ($allocation_plan_student_model->save()) {
                        $count_allocated_student ++;
                    }
                }
                // ////
            }
        }
        return $count_allocated_student; // /returns tr number of allocated student
                                         // if ($count_loan_items_awarded) {
                                         // return TRUE;
                                         // }
                                         // return FALSE;
    }
*/
    public function actionAllocateLocalContinuing()
    {
        $model = new AllocationHistory();
        $model->load(Yii::$app->request->post());
        // $model->scenario='local-continuing';// setting the allocation scenario to be local contnuing
        // print_r(AllocationHistory::getFramework($model->study_level));
        //
        // exit();
        $model->student_type = AllocationHistory::STUDENT_TYPE_NORMAL;
        $model->place_of_study = AllocationHistory::PLACE_TZ;
        // $model->allocation_framework_id=1;
        // $model->allocation_framework_id=AllocationHistory::getFramework($model->study_level);
        $model->academic_year_id = \backend\modules\allocation\models\AcademicYear::getCurrentYearID();
        if ($model->validate() && $model->save()) {
            // /checking id thereis a loan amount allocated for the given academic year
            $loan_budget = AllocationBudget::getAllocationBudgetByAcademicYearApplicantCategoryStudyLevelPlaceOfStudy($model->academic_year_id, AllocationBudget::APPLICANT_CATEGORY_NORMAL, $model->study_level, AllocationBudget::PLACE_OF_STUDY_TZ);
            if ($loan_budget) {
                $available_budget_amount = $loan_budget->budget_amount - $loan_budget->budget_consumed;
                // /NOTE for Contuing Student each student has his/her own allocation plan used to allocated loan in previous year
                $count_students = Application::countLocalContunuingStudentForAllocationByAllocationModel($model);

                if ($count_students) {
                    $maximum_data_to_process = Yii::$app->module->params['allocation_maximum_data_to_process']; // /the maximum No of students that can be processed a one time in the allocation process
                                                                                                                // //loop among the sudent list to allocate the loan zmount based on needness until when it is over
                    $index = $count_students / $maximum_data_to_process;
                    if (! is_integer($index)) {
                        $index = floor($index + 1);
                    }
                    $start_index = 0;
                    $end_index = $maximum_data_to_process;
                    // //STATING A TRANSACTION AND CREAITING THE ALLOCATION PLAN HISTORY IN THE TABLE
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        // /looping the records to accomodate all the records returned
                        for ($i = 1; $i <= $index; $i ++) {
                            // ///get student per each special group and allocate loan
                            // / Query here from application with commination on Admission student to get a clean data
                            // check for admission(confirmed/vs non confirmed, transfer info( completed/not completed,
                            // check also means testing information ( neednines, myfactor. ALWAYS ORDER STUDENT BASED ON NEEDINESS
                            $students_for_allocation = Application::getLocalContunuingStudentForAllocationByAllocationModel($model, $start_index, $end_index);
                            // ///looping among thre students received

                            if ($this->processLocalContinuingLoan($model, $students_for_allocation, $available_budget_amount)) {
                                $transaction->commit();
                                $start_index = ($i * $maximum_data_to_process) + 1;
                                $end_index = ($start_index + $maximum_data_to_process) - 1;
                                $sms = 'Allocation Successful Please check the Allocation framework to see the list of student allocated';
                                Yii::$app->session->setFlash('success', $sms);
                                $this->redirect([
                                    'view',
                                    'id' => $model->loan_allocation_history_id
                                ]);
                            } else {
                                $sms = 'Allocation failed, Please check student data to be allocated';
                                Yii::$app->session->setFlash('failure', $sms);
                                $transaction->rollBack();
                            }
                        }
                    } catch (\yii\base\Exception $e) {
                        // roll back the transaction in case there s somethign wrong
                        $transaction->rollBack();
                        throw $e;
                    }
                } else {
                    $error_sms = "No " . strtoupper(ApplicantCategory::getNameByID($model->study_level) . ' Contuining') . " Student for this Academic year";
                    Yii::$app->session->setFlash('failure', $error_sms);
                }
            } else {
                // setting error sms for the case when there no budget allocated
                $error_sms = "No Budget allocated for " . strtoupper(ApplicantCategory::getNameByID($model->study_level) . ' Contuining') . " Student for this Academic year";
                Yii::$app->session->setFlash('failure', $error_sms);
            }
        }
        return $this->render('allocate', [
            'model' => $model,
            'tab' => 'tab2'
        ]);
    }

    public function processLocalContinuingLoan($model, $students_for_allocation, $available_budget_amount)
    {
        $count_loan_items_awarded = 0;
        $minimum_allowed_loan = 500001; // /seting the minimum allowed loan amount for a student
        $minimum_allowed_TU = 200000; // /the minimum allowed loan for Tuition fee for a studen
        $minimum_allowed_BS = 100000; // / the minimum allowed loan for Books and Stationary
        $count_loan_items_awarded = 0;

        foreach ($students_for_allocation as $allocation_student) {

            // /INITILIZING THE ALLOCATION PLAN STUDENT MODEL
            $allocation_plan_student_model = new AllocationPlanStudent();
            $allocation_plan_student_model->allocation_plan_id = AllocationHistory::getFramework($allocation_student->application_id);
            $allocation_plan_student_model->allocation_history_id = $model->loan_allocation_history_id;
            $allocation_plan_student_model->application_id = $allocation_student->application_id;
            $allocation_plan_student_model->academic_year_id = $model->academic_year_id;
            $allocation_plan_student_model->study_year = $allocation_student->current_study_year;
            $allocation_plan_student_model->student_fee = $allocation_student->student_fee;
            $allocation_plan_student_model->student_fee_factor = $allocation_student->fee_factor;
            $allocation_plan_student_model->student_myfactor = $allocation_student->myfactor;
            $allocation_plan_student_model->programme_cost = $allocation_student->programme_cost;
            $allocation_plan_student_model->student_ability = $allocation_student->ability;
            $allocation_plan_student_model->needness_amount = $allocation_student->needness;
            $allocation_plan_student_model->programme_id = $allocation_student->programme_id;
            $allocation_plan_student_model->allocation_type = AllocationPlanStudent::ALLOCATION_TYPE_BENEFICIARY;
            $allocation_plan_student_model->total_allocated_amount = 0;
            $allocation_plan_student_model->student_fee = $allocation_student->student_fee;

            if ($allocation_plan_student_model->save()) {
                // #################### find allocation plan ###############
                // $model_plan=AllocationPlanStudent::getstudentplan($allocation_student->application_id, $allocation_student->academic_year_id,$allocation_student->current_study_year);
                // ##################end find allocation plan #############
                // validate if student has examinations for the previous year
                $model_result = \backend\modules\allocation\models\AdmittedStudent::validateLastYearExamResults($allocation_student->f4indexno, $allocation_student->programme_id, $allocation_student->academic_year_id, $allocation_student->current_study_year);
                if (1 == 1) {
                    // ///looping among the loan items to be allocated to student
                    // #############get loan items priority ###################
                    $allocation_loan_items_priority = LoanItem::getLoanItemOrderCont($allocation_student->programme_id, $allocation_student->academic_year_id, $allocation_student->application_id);

                    $total_amount_allocated = 0;
                    // #######################end find loan item priority #############
                    foreach ($allocation_loan_items_priority as $loan_item) {
                        // getting student LoanItem Costs based on the student programme cost

                        $ProgrammeCost = \backend\modules\allocation\models\ProgrammeCost::getProgrammeLoanItemCostByAcademicYearProgrammeLoanItem($allocation_student->academic_year_id, $allocation_student->programme_id, $loan_item["loan_item_id"]);

                        if ($ProgrammeCost) {
                            // /INITIALIZING THE ALLOCATION PLAN STUDENT LOAN ITEM MODEL
                            // initiating the allocation plan student loan items alocation distribution model
                            $allocation_plan_student_loan_items_model = new AllocationPlanStudentLoanItem();
                            $allocation_plan_student_loan_items_model->allocation_plan_student_id = $allocation_plan_student_model->allocation_plan_student_id;
                            $allocation_plan_student_loan_items_model->loan_item_id = $loan_item["loan_item_id"];
                            $allocation_plan_student_loan_items_model->priority_order = $loan_item["priority_order"];
                            $allocation_plan_student_loan_items_model->loan_award_percentage = $loan_item["loan_award_percentage"];
                            $allocation_plan_student_loan_items_model->rate_type = $ProgrammeCost->rate_type;
                            $allocation_plan_student_loan_items_model->unit_amount = $ProgrammeCost->unit_amount;
                            $allocation_plan_student_loan_items_model->duration = $ProgrammeCost->duration;
                            // /THE TOTAL AMOUNT REQIURED TO ALLOCATE PER STUDENT
                            $total_amount_to_allocate = ($ProgrammeCost->unit_amount * $ProgrammeCost->duration);

                            // #######################check budget and needleness ################################
                            $remaining_needness = ($allocation_student->needness - $total_amount_to_allocate);
                            switch ($ProgrammeCost->loanItem->item_code) {
                                case 'MA': // /meals and accomodation
                                    $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                    break;

                                case 'TU': // Tution Fee
                                    if ($remaining_needness >= $minimum_allowed_TU) {
                                        if ($remaining_needness >= $total_amount_to_allocate) {
                                            $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                        } else {
                                            $allocation_plan_student_loan_items_model->total_amount_awarded = $remaining_needness;
                                        }
                                    } else {
                                        // /allocate as previous TU if the minimum allowed TU is not reached
                                        $previous_amount = 170002;
                                        $allocation_plan_student_loan_items_model->total_amount_awarded = $previous_amount;
                                    }
                                    break;
                                case 'BS': // Books & Stationary
                                    if ($remaining_needness >= $minimum_allowed_BS) {
                                        if ($remaining_needness >= $total_amount_to_allocate) {
                                            $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                        } else {
                                            $allocation_plan_student_loan_items_model->total_amount_awarded = $remaining_needness;
                                        }
                                    } else {
                                        // /allocate previous BS if the minimum allowed BU is not reached
                                        $previous_amount = 170001;
                                        $allocation_plan_student_loan_items_model->total_amount_awarded = $previous_amount;
                                    }
                                    break;
                                default:
                                    if ($remaining_needness >= $total_amount_to_allocate) {
                                        $allocation_plan_student_loan_items_model->total_amount_awarded = $total_amount_to_allocate;
                                    } else {
                                        $allocation_plan_student_loan_items_model->total_amount_awarded = $remaining_needness;
                                    }
                                    break;
                            }
                            if ($allocation_plan_student_loan_items_model->save(false)) {
                                $total_amount_allocated += $allocation_plan_student_loan_items_model->total_amount_awarded;
                                $count_loan_items_awarded += 1;
                            }
                        }
                    }

                    // }
                }
            }
            if ($count_loan_items_awarded) {
                // update allocation
                $model_update = AllocationPlanStudent::findone($allocation_plan_student_model->allocation_plan_student_id);
                $model_update->total_allocated_amount = $total_amount_allocated;
                $model_update->save();
            }
        }

        if ($count_loan_items_awarded) {

            return $allocation_plan_student_loan_items_model;
        }
        return FALSE;
    }

    /*
     * controller action to allocate loan to grant/schplarship student
     */
    public function actionAllocateGrantScholars()
    {
        $model = new AllocationHistory();
        $model->student_type = AllocationHistory::STUDENT_TYPE_GRANT;
    }

    /**
     * Displays a single AllocationHistory model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new \backend\modules\allocation\models\AllocationPlanStudentSearch();
        $searchModel->allocation_history_id = $model->loan_allocation_history_id;
        $model_students = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'model_students' => $model_students
        ]);
    }

    /**
     * Creates a new AllocationHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AllocationHistory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'id' => $model->loan_allocation_history_id
            ]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing AllocationHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'id' => $model->loan_allocation_history_id
            ]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing AllocationHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);

        if ($model->status == AllocationHistory::STATUS_DRAFT) {
            $model->status = AllocationHistory::STATUS_REVIEWED;
            $model->reviewed_at = Date('Y-m-d H:i:s', time());
            $model->reviewed_by = Yii::$app->user->id;
            $model->save();
        } else {
            $sms = 'Operation Failed';
            Yii::$app->session->setFlash('failure', $sms);
        }
        return $this->redirect([
            'view',
            'id' => $model->loan_allocation_history_id
        ]);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        if ($model->status == AllocationHistory::STATUS_REVIEWED) {
            $model->status = AllocationHistory::STATUS_APPROVED;
            $model->approved_at = Date('Y-m-d H:i:s', time());
            $model->approved_by = Yii::$app->user->id;
            $model->save();
        } else {
            $sms = 'Operation Failed';
            Yii::$app->session->setFlash('failure', $sms);
        }
        return $this->redirect([
            'view',
            'id' => $model->loan_allocation_history_id
        ]);
    }

    /**
     * Deletes an existing AllocationHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->status == AllocationHistory::STATUS_DRAFT) {
            $this->findModel($id)->delete();
        }
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the AllocationHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return AllocationHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AllocationHistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

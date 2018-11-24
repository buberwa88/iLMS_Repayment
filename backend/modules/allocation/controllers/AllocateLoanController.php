<?php

namespace backend\modules\allocation\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\allocation\models\AllocateLoan;
use \backend\modules\allocation\models\AllocationPlan;
use \backend\modules\allocation\models\AllocationBudget;
use backend\modules\allocation\models\AllocationPlanScenario;
use backend\modules\allocation\models\AllocationPlanSpecialGroup;
use backend\modules\allocation\models\AllocationPlanLoanItem;

//use common\components\Controller;
/**
 * AllocationController implements the CRUD actions for Allocation model.
 */
class AllocateLoanController extends Controller {

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
     * Lists all Allocation models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new AllocateLoan;
        $model->scenario = 'allocate_freshesher_loan';
        $model->academic_year = \backend\modules\allocation\models\AcademicYear::getCurrentYearID();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            ///checking id thereis a loan amount allocated for the given academic year
            $loan_budget = AllocationBudget::getAllocationBudgetByAcademicYearApplicantCategoryStudyLevelPlaceOfStudy($model->academic_year, AllocationBudget::APPLICANT_CATEGORY_NORMAL, $model->study_level, AllocationBudget::PLACE_OF_STUDY_TZ);
            if ($loan_budget) {
                ////when budget available continue with other steps
                ///GET ALLOCATION FRAMEWORK==check it fromallocation plan scenatios table
                $allocation_execution_order = AllocationPlanScenario::getFrameworkExecutionOrderByFrameworkId($model->allocation_framework);
                ///fect here the loan Item Priority setting based in the allocation framework
                $allocation_loan_items_priority = AllocationPlanLoanItem::getLoanItemsByAllocationFrameworkid($model->allocation_framework);
                ///validate if framwork exists
                if ($allocation_execution_order && $allocation_loan_items_priority) {
                    ///LOOP WITHIN THE FRAMEWORK EXECUTION ORDER BASED ON
                    foreach ($allocation_execution_order as $execution_order) {
                        //checkingth type of execution ordercurrently executed 
                        switch ($execution_order->allocation_scenario) {
                            //for allocating special groups
                            case AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP:
                                /////get student special groups defined inthe allocation framework( table: allocation_plan_special_groups
                                $allocation_special_groups = AllocationPlanSpecialGroup::getSpecialGroupeByAllocationPlanID($model->allocation_framework);
                                if ($allocation_special_groups) {
                                    ///loopamong the spcial groups
                                    foreach ($allocation_special_groups as $special_group) {
                                        /////get student per each special group and allocate loan
                                        /// Query here from application with commination on Admission student to get a clean data
                                        ///EHRE ALso check forcontions to apply when getting the list of student. 
                                        //check for admission(confirmed/vs non confirmed, transfer info( compled/not completed, 
                                        //means testing information ( neednines, myfactor. ALWAYS ORDER STUDENT BASED ON NEEDINESS
                                        $students = '';
                                        if ($students) {
                                            ////loop among the sudent list to allocate the loan zmount based on needness until when it is over   
                                        }
                                    }
                                }

                                /////get all 
                                break;

                            ////for allocating loan based on stident distribution matrix
                            case AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DICTRIBUTION:
                                ///GET ALL THE  SETTINGS FOR STUDENT DISTRIBUTION MATRIS
                                ///getting clusters
                                $allocation_clusters = ''; //Query here fromtable allocation_clusters order by clusters priority
                                $allocation_gender_setting = ''; // write function here to get data table allocation gender setting
                                $allocation_student_ration = ''; /// get the data for student ration based on the(pprivate/pubic institution)
                                ///Proceed with the steps as per the comments document
                                //checking if clusers setting exists
                                if($allocation_clusters) {
                                    ////get students based on the cluster // loop clusters and get students nased on the available budget 
                                }else if(!$allocation_clusters && $allocation_student_ration){
                                    
                                }

                                break;

                            default :

                                break;
                        }
                    }
                } else {
                    //setting error sms for the case when there no  budget allocated
                    Yii::$app->session->setFlash('failure', "No Execution plan/order has been set for the selected allocation plan/framework");
                }
            } else {
                //setting error sms for the case when there no  budget allocated
                Yii::$app->session->setFlash('failure', "No Budget has been allocated for the selected Student Level of study for the current academic year");
            }
        }
        return $this->render('index', ['model' => $model
        ]);
    }

    /**
     * Displays a single Allocation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionAllocationPlan() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $academic_year_id = (int) $parents[0];

                $data = AllocationPlan::find()->where(['academic_year_id' => $academic_year_id, 'allocation_plan_stage' => AllocationPlan::STATUS_ACTIVE])->asArray()->all();
                if ($data) {
                    foreach ($data as $data) {
                        array_push($out, ['id' => $data['allocation_plan_id'], 'name' => $data['allocation_plan_title']]);
                    }
                }
                echo \yii\helpers\Json::encode(['output' => $out]);
                return;
            }
        }
    }

}

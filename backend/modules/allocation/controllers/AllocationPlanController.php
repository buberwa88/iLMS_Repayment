<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AllocationPlan;
use backend\modules\allocation\models\AllocationPlanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\allocation\models\AllocationPlanScenario;
use backend\modules\allocation\models\AllocationPlanClusterSetting;
use backend\modules\allocation\models\AllocationPlanGenderSetting;
use backend\modules\allocation\models\AllocationPlanLoanItem;
use backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting;
use backend\modules\allocation\models\AllocationPlanSpecialGroup;

/**
 * AllocationPlanController implements the CRUD actions for AllocationPlan model.
 */
class AllocationPlanController extends Controller {

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
     * Lists all AllocationPlan models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AllocationPlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationPlan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $active = '';
        if (\Yii::$app->session['active_tab']) {
            $active = \Yii::$app->session['active_tab'];
        }
        if ($model) {

            $model_scenarios = \backend\modules\allocation\models\AllocationPlanScenario::getAllocationScenarionsByFrameworkId($model->allocation_plan_id);
//getting allocation special groups
            $model_special_group = \backend\modules\allocation\models\AllocationPlanSpecialGroup::getAllocationSpecialGroupsByFrameworkId($model->allocation_plan_id);

//getting plan cluster
            $model_clusters = \backend\modules\allocation\models\AllocationPlanClusterSetting::getAllocationPlanClustersById($id);
//getting programmes under the given scholarship
            $model_institutions_type = \backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting::getInstitutionTypeSettingsById($id);
//getting grant loan items
            $model_loan_item = \backend\modules\allocation\models\AllocationPlanLoanItem::getLoanItemsById($id);
            $model_gender_item = \backend\modules\allocation\models\AllocationPlanGenderSetting::getGenderSettingsById($id);

            return $this->render('view', [
                        'model' => $model, 'active' => $active,
                        'model_special_group' => $model_special_group,
                        'model_scenarios' => $model_scenarios,
                        'model_clusters' => $model_clusters,
                        'model_institutions_type' => $model_institutions_type,
                        'model_loan_item' => $model_loan_item,
                        'model_gender_item' => $model_gender_item
            ]);
        }
    }

    /**
     * Creates a new AllocationPlan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AllocationPlan();

        if ($model->load(Yii::$app->request->post())) {
            $model->allocation_plan_number = AllocationPlan::generateRandomString(99999999);
            $model->allocation_plan_stage = AllocationPlan::STATUS_INACTIVE;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->allocation_plan_id]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing AllocationPlan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->allocation_plan_stage == AllocationPlan::STATUS_INACTIVE && !$model->hasStudents() && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->allocation_plan_id]);
            } else {
                $sms = 'Operation Failed,Please check configurations';
                Yii::$app->session->setFlash('failure', $sms);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AllocationPlan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionActivate($id) {
        $model = $this->findModel($id);
        ///verifiying if the allocationplan has execuition onrder and has not beenclosed/inactive
        if ($model->allocationPlanScenarios && $model->allocationPlanLoanItems && $model->allocation_plan_stage == AllocationPlan::STATUS_INACTIVE) {
            foreach ($model->allocationPlanScenarios as $scenario) {
                switch ($scenario->allocation_scenario) {
                    case \backend\modules\allocation\models\AllocationPlanScenario::ALLOCATION_SCENARIO_SPECIAL_GROUP:
                        $model->scenario = 'special_group';
                        break;

                    case \backend\modules\allocation\models\AllocationPlanScenario::ALLOCATION_SCENARIO_STD_DISTRIBUTION:
                        $model->scenario = 'student_distribution';
                        break;
                }
            }
            if ($model->validate()) {
                $model->allocation_plan_stage = AllocationPlan::STATUS_ACTIVE;
                $model->save();
            } else {
                $sms = $model->errors;
//
//                var_dump($sms);
////                exit;
                Yii::$app->session->setFlash('failure', $sms['allocation_plan_id'][0]);
            }
        } else {
            $sms = 'Operation Failed, Please configure correctly all the required settings';
            Yii::$app->session->setFlash('failure', $sms);
        }
        return $this->redirect(['view', 'id' => $model->allocation_plan_id]);
    }

    public function actionDeActivate($id) {
        $model = $this->findModel($id);
        ///verifiying if the allocationplan has execuition onrder and has not beenclosed/inactive
        if ($model->allocationPlanScenarios && $model->allocationPlanLoanItems && $model->allocation_plan_stage == AllocationPlan::STATUS_ACTIVE) {
            $model->allocation_plan_stage = AllocationPlan::STATUS_INACTIVE;
            $model->save();
        } else {
            $sms = 'Operation Failed, Please configure correctly all the required settings';
            Yii::$app->session->setFlash('failure', $sms);
        }
        return $this->redirect(['view', 'id' => $model->allocation_plan_id]);
    }

    /**
     * Finds the AllocationPlan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AllocationPlan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AllocationPlan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddClusterSetting($id) {
        \Yii::$app->session['active_tab'] = 'atab3';
        $model = $this->findModel($id);
        $cluster = New \backend\modules\allocation\models\AllocationPlanClusterSetting();
        $cluster->allocation_plan_id = $model->allocation_plan_id;
        if (Yii::$app->request->post('AllocationPlanClusterSetting')) {
            $cluster->attributes = Yii::$app->request->post('AllocationPlanClusterSetting');
            if ($cluster->allocation_plan_id == $id) {
                try {
                    if ($cluster->save()) {

                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (yii\db\Exception $exception) {
                    if ($exception !== null) {
                        return $this->render('error', ['exception' => $exception]);
                    }
                }
            }
        }

        return $this->render('addClusters', [
                    'model' => $model, 'cluster' => $cluster
        ]);
    }

    public function actionAddInstitutionType($id) {
        \Yii::$app->session['active_tab'] = 'atab4';
        $model = $this->findModel($id);
        $institution = New \backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting();
        $institution->allocation_plan_id = $model->allocation_plan_id;
        if (Yii::$app->request->post('AllocationPlanInstitutionTypeSetting')) {
            $institution->attributes = Yii::$app->request->post('AllocationPlanInstitutionTypeSetting');
            if ($institution->allocation_plan_id == $id) {
                try {
                    if ($institution->save()) {

                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (yii\db\Exception $exception) {
                    if ($exception !== null) {
                        return $this->render('error', ['exception' => $exception]);
                    }
                }
            }
        }

        return $this->render('addInstitution', [
                    'model' => $model, 'institution' => $institution
        ]);
    }

    public function actionAddLoanItemSetting($id) {
        \Yii::$app->session['active_tab'] = 'atab5';
        $model = $this->findModel($id);
        $loan_item = New \backend\modules\allocation\models\AllocationPlanLoanItem();
        $loan_item->allocation_plan_id = $model->allocation_plan_id;
        if (Yii::$app->request->post('AllocationPlanLoanItem')) {
            $loan_item->attributes = Yii::$app->request->post('AllocationPlanLoanItem');

            if ($loan_item->allocation_plan_id == $id) {
                try {

                    $loan_item->unit_amount = 1; //tem fix. thiscolumn need to be removed
                    ///getting the item rate as per the configuation ofthe loan item
                    $loan_item->rate_type = \backend\modules\allocation\models\LoanItem::getItemRateByItemId($loan_item->loan_item_id);
                    if (!$loan_item->loan_award_percentage) {
                        $loan_item->loan_award_percentage = 100; // setting default awarding percent to be 100% required
                    }
                    if ($loan_item->save()) {

                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (yii\db\Exception $exception) {
                    if ($exception !== null) {
                        return $this->render('error', ['exception' => $exception]);
                    }
                }
            }
        }
        return $this->render('addLoanItem', [
                    'model' => $model, 'loan_item' => $loan_item
        ]);
    }

    /**
     * Creates a new AllocationFramework model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddScenario($id) {
        \Yii::$app->session['active_tab'] = 'atab1';
        $model_scenario = new \backend\modules\allocation\models\AllocationPlanScenario();
        $model = $this->findModel($id);
        if ($model->allocation_plan_stage == AllocationPlan::STATUS_INACTIVE) {
            if (Yii::$app->request->post('AllocationPlanScenario')) {
                $model_scenario->attributes = Yii::$app->request->post('AllocationPlanScenario');
                if ($id == $model_scenario->allocation_plan_id) {
                    if ($model_scenario->save()) {
                        return $this->redirect(['view', 'id' => $id]);
                    }
                }
            }
        } else {
            $sms = 'Operation Failed, Framework Status';
            Yii::$app->session->setFlash('failure', $sms);
        }

        return $this->render('addScenario', ['model_scenario' => $model_scenario, 'model' => $model]);
    }

    /**
     * Creates a new AllocationFramework model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddSpecialGroup($id) {
        \Yii::$app->session['active_tab'] = 'atab2';
        $model_special_group = new \backend\modules\allocation\models\AllocationPlanSpecialGroup();
        $model = $this->findModel($id);
        if ($model->allocation_plan_stage == AllocationPlan::STATUS_INACTIVE OR $model->allocation_plan_stage == AllocationPlan::STATUS_ACTIVE) {
            if (Yii::$app->request->post('AllocationPlanSpecialGroup')) {
                $model_special_group->attributes = Yii::$app->request->post('AllocationPlanSpecialGroup');
                if ($id == $model_special_group->allocation_plan_id) {
                    if ($model_special_group->save()) {
                        return $this->redirect(['view', 'id' => $id]);
                    }
                }
            }
        }
        return $this->render('addSpecialGroup', ['model_special_group' => $model_special_group, 'model' => $model]);
    }

    public function ActionCronConfiguration($id) {
        $model = $this->findModel($id);
        if ($model->allocation_plan_stage != AllocationPlan::STATUS_INACTIVE && ($model->allocation_plan_stage == AllocationPlan::STATUS_CLOSED OR $model->is_active == AllocationFramework::STATUS_ACTIVE)) {
            
        }
        echo 'Page Uner Construction';
    }

    /*
     * gets the list of columns for a prticular database table
     */

    public function actionTableColumns() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null && isset($parents[0])) {
                $table_name = trim($parents[0]);
                $data = Yii::$app->db->schema->getTableSchema($table_name)->columnNames;
                foreach ($data as $key => $value) {
                    array_push($out, ['id' => $value, 'name' => $value]);
                }

                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo \yii\helpers\Json::encode(['output' => '', 'selected' => '']);
    }

    /*
     * returns the possible values for a particular table column
     */

    public function actionColumnValues() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null && isset($parents[0]) && $parents[0] && isset($parents[1]) && $parents[1]) {
                $table_name = trim($parents[0]);
                $column_name = trim($parents[1]);
                $sql = "SELECT DISTINCT(" . $column_name . ") AS " . $column_name . " FROM " . $table_name;
                $data = Yii::$app->db->createCommand($sql)->queryAll();
                foreach ($data as $value) {
                    if ($value[$column_name]) {
                        array_push($out, ['id' => $value[$column_name], 'name' => $value[$column_name]]);
                    }
                }
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo \yii\helpers\Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionAddGenderSetting($id) {
        \Yii::$app->session['active_tab'] = 'atab6';
        $model = $this->findModel($id);
        $gender_item = New \backend\modules\allocation\models\AllocationPlanGenderSetting();
        $gender_item->allocation_plan_id = $model->allocation_plan_id;
        if (Yii::$app->request->post('AllocationPlanGenderSetting')) {
            $gender_item->attributes = Yii::$app->request->post('AllocationPlanGenderSetting');

            if ($gender_item->allocation_plan_id == $id) {
                try {
                    $gender_item->male_percentage = (100 - $gender_item->female_percentage);

                    if ($gender_item->save()) {

                        $sms = "Information Successful Added";
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
        return $this->render('addGenderSetting', [
                    'model' => $model, 'gender_item' => $gender_item, 'allocation_plan_id' => $id,
        ]);
    }

    public function actionUpdateGenderPlan($id) {
        \Yii::$app->session['active_tab'] = 'atab6';
        //$model = $this->findModel($id);
        $gender_item = \backend\modules\allocation\models\AllocationPlanGenderSetting::findOne(['allocation_plan_gender_setting_id' => $id]);
        $allocationPlan1 = $gender_item->allocation_plan_id;
        if ($gender_item->load(Yii::$app->request->post()) && $gender_item->validate()) {
            $gender_item->male_percentage = (100 - $gender_item->female_percentage);
            if ($gender_item->save()) {
                $sms = "Information Successful Updated";
                Yii::$app->getSession()->setFlash('success', $sms);
                $allocationPlan = $gender_item->allocation_plan_id;
                //return $this->redirect(['index']);
                return $this->redirect(['view', 'id' => $allocationPlan]);
            }
        } else {
            return $this->render('updateGenderPlan', [
                        'gender_item' => $gender_item, 'allocation_plan_id' => $allocationPlan1,
            ]);
        }
    }

    public function actionDeleteGenderPlan($id) {
        $gender_item = \backend\modules\allocation\models\AllocationPlanGenderSetting::findOne(['allocation_plan_gender_setting_id' => $id]);
        $allocationPlan1 = $gender_item->allocation_plan_id;
        $gender_item->delete();
        return $this->redirect(['view', 'id' => $allocationPlan1]);
    }

    public function actionDeletePlanLoanitem($id, $id2t) {
        $allocation_plan = \backend\modules\allocation\models\AllocationPlanLoanItem::findOne(['allocation_plan_id' => $id, 'loan_item_id' => $id2t]);
        $allocationPlan1 = $allocation_plan->allocation_plan_id;
        $allocation_plan->delete();
        return $this->redirect(['view', 'id' => $allocationPlan1]);
    }

    public function actionDeletePlanCluster($id) {
        $allocation_plan_cluster = \backend\modules\allocation\models\AllocationPlanClusterSetting::findOne(['allocation_plan_cluster_setting_id' => $id]);
        $allocationPlan1 = $allocation_plan_cluster->allocation_plan_id;
        $allocation_plan_cluster->delete();
        return $this->redirect(['view', 'id' => $allocationPlan1]);
    }

    public function actionDeletePlanSpecialgroup($id) {
        $allocation_plan_specialgroup = \backend\modules\allocation\models\AllocationPlanSpecialGroup::findOne(['special_group_id' => $id]);
        $allocationPlan1 = $allocation_plan_specialgroup->allocation_plan_id;
        $allocation_plan_specialgroup->delete();
        return $this->redirect(['view', 'id' => $allocationPlan1]);
    }

    public function actionDeletePlanInstittype($id, $type) {
        $allocation_plan_insttype = \backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting::findOne(['allocation_plan_id' => $id, 'institution_type' => $type]);
        $allocationPlan1 = $allocation_plan_insttype->allocation_plan_id;
        $allocation_plan_insttype->delete();
        return $this->redirect(['view', 'id' => $allocationPlan1]);
    }

    public function actionCloneAll($id) {
        $model = $this->findModel($id);
        $model_clone = new AllocationPlan;
        if ($model_clone->load(Yii::$app->request->post())) {
            $model_clone->attributes = $model->attributes;
            $model_clone->allocation_plan_number = AllocationPlan::generateRandomString(99999999);
            $model_clone->allocation_plan_stage = AllocationPlan::STATUS_INACTIVE;
            $model_clone->allocation_plan_title = Yii::$app->request->post('AllocationPlan')['allocation_plan_title'];
            $model_clone->academic_year_id = Yii::$app->request->post('AllocationPlan')['academic_year_id'];
            $model_clone->allocation_plan_desc = Yii::$app->request->post('AllocationPlan')['allocation_plan_desc'];
            ///getting execution order to clone
            $execution_order = AllocationPlanScenario::getFrameworkExecutionOrderByFrameworkId($model->allocation_plan_id);
            //getting loan items to clone
            $loan_item_settings = AllocationPlanLoanItem::getLoanItemsByAllocationFrameworkid($model->allocation_plan_id);
            if ($execution_order && $loan_item_settings) {
                if ($model_clone->save()) {
                    ///Cloning/processing allocation plan execution order
                    foreach ($execution_order as $execution_order) {
                        $AllocationPlanScenario = new AllocationPlanScenario();
                        $AllocationPlanScenario->attributes = $execution_order->attributes;
                        $AllocationPlanScenario->allocation_plan_id = $model_clone->allocation_plan_id;
                        $AllocationPlanScenario->save();
                    }

                    ///Cloning/processing allocation plan loan items
                    foreach ($loan_item_settings as $loan_item_setting) {

                        $AllocationPlanLoanItems = new AllocationPlanLoanItem();
                        $AllocationPlanLoanItems->attributes = $loan_item_setting->attributes;
                        $AllocationPlanLoanItems->allocation_plan_id = $model_clone->allocation_plan_id;
                        $AllocationPlanLoanItems->save();
                    }
                    //Cloning Special groups
                    $special_groups = AllocationPlanSpecialGroup::getSpecialGroupeByAllocationPlanID($model->allocation_plan_id);
                    if ($special_groups) {
                        foreach ($special_groups as $special_group) {
                            $AllocationPlanSpecialGroup = new AllocationPlanScenario();
                            $AllocationPlanSpecialGroup->attributes = $special_group->attributes;
                            $AllocationPlanSpecialGroup->allocation_plan_id = $model_clone->allocation_plan_id;
                            $AllocationPlanSpecialGroup->save();
                        }
                    }
                    ///Cloning/processing Clusters
                    $clusters = AllocationPlanClusterSetting::getClusterSettingsByAlloationPlanID($model->allocation_plan_id);
                    if ($clusters) {
                        foreach ($clusters as $cluster) {
                            $AllocationPlanCluster = new AllocationPlanClusterSetting();
                            $AllocationPlanCluster->attributes = $cluster->attributes;
                            $AllocationPlanCluster->allocation_plan_id = $model_clone->allocation_plan_id;
                            $AllocationPlanCluster->save();
                        }
                    }
                    ///Cloning/processing Student Ration in per Institution Type
                    $student_per_institution = AllocationPlanInstitutionTypeSetting::getInstitutionTypeSettingsByAllocationPlanId($model->allocation_plan_id);
                    if ($student_per_institution) {
                        foreach ($student_per_institution as $student_ration) {
                            $AllocationPlanInstitutionType = new AllocationPlanInstitutionTypeSetting();
                            $AllocationPlanInstitutionType->attributes = $student_ration->attributes;
                            $AllocationPlanInstitutionType->allocation_plan_id = $model_clone->allocation_plan_id;
                            $AllocationPlanInstitutionType->save();
                        }
                    }
                    ///Cloning/processing Gender Settings
                    $gender_setting = AllocationPlanGenderSetting::getGenderSettingsByAllocationPlanId($model->allocation_plan_id);
                    if ($gender_setting) {
                        $AllocationPlanGenderSetting = new AllocationPlanGenderSetting();
                        $AllocationPlanGenderSetting->attributes = $gender_setting->attributes;
                        $AllocationPlanGenderSetting->allocation_plan_id = $model_clone->allocation_plan_id;
                        $AllocationPlanGenderSetting->save();
                    }
                    return $this->redirect(['view', 'id' => $model_clone->allocation_plan_id]);
                } else {
                    $sms = 'Clone Operation Failed, Please try again';
                    Yii::$app->session->setFlash('failure', $sms);
                }
            } else {
                $sms = 'Clone Operation Failed, Please make sure the Framework cloned has required Configuration';
                Yii::$app->session->setFlash('failure', $sms);
            }
        }
        return $this->render('clonePlan', [
                    'model' => $model, 'model_clone' => $model_clone
        ]);
    }

}

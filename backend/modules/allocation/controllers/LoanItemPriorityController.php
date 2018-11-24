<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\LoanItemPriority;
use backend\modules\allocation\models\LoanItemPrioritySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

//use common\components\Controller;

/**
 * LoanItemPriorityController implements the CRUD actions for LoanItemPriority model.
 */
class LoanItemPriorityController extends Controller {

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
     * Lists all LoanItemPriority models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LoanItemPrioritySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoanItemPriority model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LoanItemPriority model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new LoanItemPriority();
        $model->scenario = 'create_update';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                    'success', 'Data Successfully Created!'
            );
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LoanItemPriority model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = 'create_update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                    'success', 'Data Successfully Updated!'
            );
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LoanItemPriority model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LoanItemPriority model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoanItemPriority the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LoanItemPriority::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//    public function actionLoanItems() {
    public function actionItems() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null && is_array($parents) && Count($parents) > 1) {
                $item_category = trim(isset($parents[0]) ? $parents[0] : NULL);
                $item_study_level = trim(isset($parents[1]) ? $parents[1] : NULL);
                if ($item_study_level && $item_category) {
                    $items = \backend\modules\allocation\models\LoanItem::getLoanItemsByItem($item_study_level, $item_category);
                    foreach ($items as $item) {
                        $data = ['id' => $item['loan_item_id'], 'name' => $item['item_name']];
                        array_push($out, $data);
                    }
                    echo \yii\helpers\Json::encode(['output' => $out]);
                    return;
                }
            }
        }
        echo \yii\helpers\Json::encode(['output' => '']);
    }

    public function actionClone() {
        $model = new LoanItemPriority();
        $model->scenario = 'clone_items_priority';
        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = $model->updated_by = Yii::$app->user->id;
            if ($model->validate()) {
                $Loan_items_priority = LoanItemPriority::getLoanItemsPriorityAcademicYearID($model->source_academic_year);
                $count_list = count($Loan_items_priority);
                $count_saved = 0;
                if ($Loan_items_priority) {
                    foreach ($Loan_items_priority as $loan_item_priority) {
                        $item_priority = new LoanItemPriority();
                        $item_priority->academic_year_id = $model->destination_academic_year;
                        $item_priority->loan_item_id = $loan_item_priority->loan_item_id;
                        $item_priority->priority_order = $loan_item_priority->priority_order;
                        $item_priority->study_level = $loan_item_priority->study_level;
                        $item_priority->loan_award_percentage = $loan_item_priority->loan_award_percentage;
                        $item_priority->created_by = Yii::$app->user->id;
                        if ($item_priority->save()) {
                            $count_saved++;
                        }
                    }
                }
                if ($count_saved) {
                    $sms = 'Clone Operation Successful, ' . $count_saved . ' Records out of ' . $count_list . ' have been Cloned';
                    Yii::$app->session->setFlash('success', $sms);
                    $model->attributes = NULL;
                } else {
                    $sms = 'Clone Operation failed, No Records has been Cloned';
                    Yii::$app->session->setFlash('failure', $sms);
                }
            }
        }
        return $this->render('cloneLoanItemPriority', [
                    'model' => $model
        ]);
    }

}

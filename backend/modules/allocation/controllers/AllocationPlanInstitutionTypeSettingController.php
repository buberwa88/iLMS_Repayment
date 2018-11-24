<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting;
use backend\modules\allocation\models\AllocationPlanInstitutionTypeSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AllocationPlanInstitutionTypeSettingController implements the CRUD actions for AllocationPlanInstitutionTypeSetting model.
 */
class AllocationPlanInstitutionTypeSettingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
     * Lists all AllocationPlanInstitutionTypeSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AllocationPlanInstitutionTypeSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationPlanInstitutionTypeSetting model.
     * @param integer $allocation_plan_id
     * @param integer $institution_type
     * @return mixed
     */
    public function actionView($allocation_plan_id, $institution_type)
    {
        return $this->render('view', [
            'model' => $this->findModel($allocation_plan_id, $institution_type),
        ]);
    }

    /**
     * Creates a new AllocationPlanInstitutionTypeSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AllocationPlanInstitutionTypeSetting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'allocation_plan_id' => $model->allocation_plan_id, 'institution_type' => $model->institution_type]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AllocationPlanInstitutionTypeSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $allocation_plan_id
     * @param integer $institution_type
     * @return mixed
     */
    public function actionUpdate($allocation_plan_id, $institution_type)
    {
        $model = $this->findModel($allocation_plan_id, $institution_type);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'allocation_plan_id' => $model->allocation_plan_id, 'institution_type' => $model->institution_type]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AllocationPlanInstitutionTypeSetting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $allocation_plan_id
     * @param integer $institution_type
     * @return mixed
     */
    public function actionDelete($allocation_plan_id, $institution_type)
    {
        $this->findModel($allocation_plan_id, $institution_type)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AllocationPlanInstitutionTypeSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $allocation_plan_id
     * @param integer $institution_type
     * @return AllocationPlanInstitutionTypeSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($allocation_plan_id, $institution_type)
    {
        if (($model = AllocationPlanInstitutionTypeSetting::findOne(['allocation_plan_id' => $allocation_plan_id, 'institution_type' => $institution_type])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

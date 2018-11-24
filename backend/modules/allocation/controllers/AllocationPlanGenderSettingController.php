<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AllocationPlanGenderSetting;
use backend\modules\allocation\models\AllocationPlanGenderSettingSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AllocationPlanGenderSettingController implements the CRUD actions for AllocationPlanGenderSetting model.
 */
class AllocationPlanGenderSettingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $this->layout="main_private";
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
     * Lists all AllocationPlanGenderSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AllocationPlanGenderSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationPlanGenderSetting model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AllocationPlanGenderSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AllocationPlanGenderSetting();
        //$model->scenario='add_allocation_gender_plan';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $allocation_plan_gender_setting_id=$model->allocation_plan_gender_setting_id;
            $male_percentage=(100 - $model->female_percentage);
            $model->updateMalePercent($male_percentage,$allocation_plan_gender_setting_id);
            $sms ="Information Successful Added";                       
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AllocationPlanGenderSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->load(Yii::$app->request->post())&& $model->save()) {
            $finalfemale_percentage=\backend\modules\allocation\models\AllocationPlanGenderSetting::findOne(['allocation_plan_gender_setting_id'=>$model->allocation_plan_gender_setting_id]);
            $finalfemale_percentage->male_percentage=(100 - $model->female_percentage);
            $finalfemale_percentage->save();
            $sms ="Information Successful Updated";                       
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
    } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AllocationPlanGenderSetting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AllocationPlanGenderSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AllocationPlanGenderSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AllocationPlanGenderSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

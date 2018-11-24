<?php

namespace backend\modules\repayment\controllers;

use Yii;
use backend\modules\repayment\models\EmployerMonthlyPenaltySetting;
use backend\modules\repayment\models\EmployerMonthlyPenaltySettingSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployerMonthlyPenaltySettingController implements the CRUD actions for EmployerMonthlyPenaltySetting model.
 */
class EmployerMonthlyPenaltySettingController extends Controller
{
    /**
     * @inheritdoc
     */
	 
	 public $layout="main_private";
	 
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
     * Lists all EmployerMonthlyPenaltySetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployerMonthlyPenaltySettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployerMonthlyPenaltySetting model.
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
     * Creates a new EmployerMonthlyPenaltySetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmployerMonthlyPenaltySetting();
        $model->created_at=date("Y-m-d H:i:s");
        $model->created_by=\Yii::$app->user->identity->user_id;
		$model->is_active=1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		$employer_type_id=$model->employer_type_id;
		$employer_mnthly_penalty_setting_id=$model->employer_mnthly_penalty_setting_id;
		$model->updateOldEmployerMonthlyPenaltySettings($employer_type_id,$employer_mnthly_penalty_setting_id);
		    $sms = '<p>Information Successful Added.</p>';
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EmployerMonthlyPenaltySetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->employer_mnthly_penalty_setting_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EmployerMonthlyPenaltySetting model.
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
     * Finds the EmployerMonthlyPenaltySetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployerMonthlyPenaltySetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployerMonthlyPenaltySetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

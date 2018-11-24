<?php

namespace backend\modules\report\controllers;

use Yii;
use backend\modules\report\models\ReportAccess;
use backend\modules\report\models\ReportAccessSearch;
//use yii\web\Controller;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportAccessController implements the CRUD actions for ReportAccess model.
 */
class ReportAccessController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public $layout = "main_private";

    /**
     * Lists all ReportAccess models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ReportAccessSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportAccess model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ReportAccess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ReportAccess();
        $created_by=Yii::$app->user->identity->user_id;
        $created_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {
            $user_role = $model->user_role;
            $array = $model->report_id;
            $array2 = $model->user_id;
            if(count($array) > 0){
            foreach ($array as $value) {
                $empModel = new ReportAccess();
                $empModel->user_role = $user_role;
                $empModel->report_id = $value;
                $empModel->created_by = $created_by;
                $empModel->created_at = $created_at;
                $resultsCount = ReportAccess::find()->where(['user_role' => $user_role, 'report_id' => $value])->count();
                if ($resultsCount == 0 && $user_role !='' && $value !='') {

                    // here for logs
                    $old_data = \yii\helpers\Json::encode($empModel->attributes);
                    $new_data = \yii\helpers\Json::encode($empModel->attributes);
                    //$model_logs = \common\models\base\Logs::CreateLogall($empModel->report_access_id, $old_data, $new_data, "report_access", "CREATE", 1);
                    //end for logs	
                    $empModel->save(false);
                }
        }}
            if(count($array) > 0){
            foreach ($array as $value2) {                
                foreach ($array2 as $value3) {
                $empModel2 = new ReportAccess();
                $empModel2->report_id = $value2;    
                $empModel2->user_id = $value3;
                $empModel2->created_by = $created_by;
                $empModel2->created_at = $created_at;
                $resultsCount2 = ReportAccess::find()->where(['report_id' => $value2, 'user_id' => $value3])->count();
                if ($resultsCount2 == 0 && $value3 !='' && $value2 !='') {

                    // here for logs
                    $old_data = \yii\helpers\Json::encode($empModel2->attributes);
                    $new_data = \yii\helpers\Json::encode($empModel2->attributes);
                    //$model_logs = \common\models\base\Logs::CreateLogall($empModel2->report_access_id, $old_data, $new_data, "report_access", "CREATE", 1);
                    //end for logs	
                    $empModel2->save(false);
                }
                }
            }
        }
            $sms = "<p>Information successful added</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ReportAccess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->report_access_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ReportAccess model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReportAccess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportAccess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ReportAccess::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

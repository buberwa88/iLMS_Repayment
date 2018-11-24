<?php

namespace backend\modules\report\controllers;

use Yii;
use backend\modules\report\models\PopularReport;
use backend\modules\report\models\PopularReportSearch;
use backend\modules\report\models\Report;
use backend\modules\report\models\ReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PopularReportController implements the CRUD actions for PopularReport model.
 */
class PopularReportController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = "main_private";
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
     * Lists all PopularReport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PopularReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PopularReport model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //$searchModel = new ReportSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel = new PopularReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => Report::findOne(['id'=>$id]),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new PopularReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*
    public function actionCreate()
    {
        $model = new PopularReport();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
     * 
     */
    
    public function actionCreate()
    {
        $model = new PopularReport();
        $created_by=Yii::$app->user->identity->user_id;
        $created_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {
            $array=$model->report_id;
foreach ($array as $value) {
$popularReportModel = new PopularReport();
$popularReportModel->user_id =$created_by;
$popularReportModel->report_id = $value;
$popularReportModel->rate = 1;
//$popularReportModel->created_at = $created_at;
$resultsCount=PopularReport::find()->where(['report_id'=>$value,'user_id'=>$created_by])->count();
if($resultsCount==0){

                  // here for logs
                        $old_data=\yii\helpers\Json::encode($popularReportModel->attributes);						
						$new_data=\yii\helpers\Json::encode($popularReportModel->attributes);
						//$model_logs=\common\models\base\Logs::CreateLogall($popularReportModel->id,$old_data,$new_data,"popular_report","CREATE",1);
				//end for logs	
$popularReportModel->save(false);
}                
} 
            
            $sms="<p>Operation Successful</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PopularReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PopularReport model.
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
     * Finds the PopularReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PopularReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PopularReport::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

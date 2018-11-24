<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\AllocationBatch;
use backend\modules\allocation\models\Allocation;
use backend\modules\allocation\models\AllocationSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * AllocationController implements the CRUD actions for Allocation model.
 */
class AllocationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
          $this->layout="default_main";
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
    public function actionIndex($id)
    {
        
        $searchModel = new AllocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
  public function actionBatchAllocatedSummary($id)
    {
        
        $searchModel = new AllocationSearch();
        $dataProvider = $searchModel->searchsummary(Yii::$app->request->queryParams,$id);

        return $this->render('indexsummary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /** 
     * Displays a single Allocation model.
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
     * Creates a new Allocation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Allocation();

        if ($model->load(Yii::$app->request->post())) {
            /*get list of student with status 0f 6 and neednes is
             *  equal of greater than min loan amount
             */
              $modelall=  \backend\modules\application\models\Application::find()->where(["allocation_status"=>6])->asArray()->all();
              print_r($modelall);
             //$model->save()
             // return $this->redirect(['view', 'id' => $model->allocation_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Allocation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->allocation_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Allocation model.
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
     * Finds the Allocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Allocation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Allocation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGettableColumnName() {

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $table_name = $parents[0];
                $out = Allocation::gettableColumnName($table_name);

                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
       //$out = Allocation::gettableColumnName(1);
    }
     public function actionGettableColumnNameall($tableId) {

                $out = [];
//        if (isset($_POST['depdrop_parents'])) {
//            $parents = $_POST['depdrop_parents'];
//            if ($parents != null) {
                //$table_name = $parents[0];
                $out = Allocation::gettableColumnName($tableId);

                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
//            }
//        }
       //$out = Allocation::gettableColumnName(1);
    }
   public function actionAllocationBatchDownload($allocation_batch_id) { 
   $modelall=  AllocationBatch::findOne($allocation_batch_id);
   $model= Yii::$app->db->createCommand("SELECT `firstname`, `middlename`,apl.application_id, `surname`,institution_name,institution_code,u.sex,current_study_year, `f4indexno`,apl.`programme_id`,SUM(`allocated_amount`) as amount_total,`allocation_batch_id`,programme_name,programme_code,pr.learning_institution_id FROM `user` u join applicant ap "
            . "  on u.`user_id`=ap.`user_id` join application apl "
            . "  on apl.`applicant_id`=ap.`applicant_id` "
            . "  join allocation alls on alls.`application_id`=apl.`application_id` join programme pr on pr.`programme_id`=apl.`programme_id` "
           . "   join `learning_institution` li on li.`learning_institution_id`=pr.`learning_institution_id`"
            . "  WHERE allocation_batch_id='{$allocation_batch_id}' group by alls.`application_id`,`allocation_batch_id` order by pr.learning_institution_id")->queryAll();
       $content=$this->render('../allocation-batch/allocation_batch_pdf', [
            'model' =>$model,
            'modelall' =>$modelall,
             
         ]);
         $pdf = Yii::$app->pdf;
         $pdf->content = $content;
     return $pdf->render(); 
       }
}

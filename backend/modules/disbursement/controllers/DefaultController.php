<?php

namespace backend\modules\disbursement\controllers;
use Yii;
//use yii\web\Controller;
use backend\modules\allocation\models\AllocationBatch;
use backend\modules\allocation\models\AllocationBatchSearch;
use backend\modules\allocation\models\AllocationSearch;
use backend\modules\application\models\ApplicationSearch;
use backend\modules\application\models\ApplicantSearch;
use common\components\Controller;
/**
 * Default controller for the `disbursement` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = "main_private";
    public function actionIndex()
    {
      
        return $this->render('index');
    }
    public function actionAllocationBatch()
    {
      
        $searchModel = new AllocationBatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('allocation-batch', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    
    }
     public function actionViewbatch($id)
    {
       
        return $this->render('allocationbatchprofile', [
            'model' => $this->findModelbatch($id),
        ]);
    }
    public function actionAllocatedStudent($id)
    {
        $this->layout="default_main"; 
        $searchModel = new AllocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('allocatedstudent', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
           'id'=>$id,
        ]);
    
    }
    protected function findModelbatch($id)
    {
        if (($model = AllocationBatch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
 public function actionNotification()
    {
  return $this->render('notification');
    }
  public function actionStudentBankAccount()
    {
         $this->layout="default_main"; 
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchbank(Yii::$app->request->queryParams);
  return $this->render('student_bank_account',
                             [
                             'searchModel' => $searchModel,
                             'dataProvider' => $dataProvider,
                           ]);
    }
   public function actionApproveStatus($id,$status)
    {
          $model= \backend\modules\allocation\models\AllocationBatch::findOne(["allocation_batch_id"=>$id]);
            $model->disburse_status=$status;
             
         
                          if($status==1){
                            $comment=" Verified" ;
                            $comment_all="Allocation Batch Ok";
                          }
                          else{
                        $comment=" UnVerified" ;  
                        $comment_all="Allocation Batch Mismatch with Original Batch";
                          }
                  $model->disburse_comment=$comment_all;
                  $model->update();
                  //print_r($model);
                  //exit();
             Yii::$app->getSession()->setFlash(
                                'success', "Data Successfully   $comment!"
                        );
       return $this->redirect(['allocation-batch','id'=>$id]);
    }
 public function actionApplicantProfile()
    {
        // $this->layout="default_main"; 
        $searchModel = new ApplicantSearch();
        $dataProvider = $searchModel->searchapplicant(Yii::$app->request->queryParams);
  return $this->render('applicant_list',
                             [
                             'searchModel' => $searchModel,
                             'dataProvider' => $dataProvider,
                           ]);
    }  
    public function actionViewprofile($id)
    {
       
        return $this->render('applicantprofile', [
            'model' => $this->findModelapplicant($id),
        ]);
    }
    protected function findModelapplicant($id)
    {
        if (($model = \backend\modules\application\models\Applicant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
  public function actionUpdateloanee($id)
    {
         $this->layout="default_main"; 
        
       $model =\backend\modules\application\models\Application::findone($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                   Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfuly Updated!'
                        );
            return $this->redirect(['updateloanee', 'id' => $model->application_id]);
        } else {
       return $this->render('updateloan', [
            'model' =>  $model,
        ]);
        }
    }
  public function actionMyallocatation($id)
    {
        $this->layout="default_main"; 
        $searchModel = new \backend\modules\allocation\models\AllocationSearch();
        $dataProvider = $searchModel->searchmyallocation(Yii::$app->request->queryParams,$id);
   return $this->render('myallocatation',
                             [
                             'searchModel' => $searchModel,
                             'dataProvider' => $dataProvider,
                           ]);
    }
}

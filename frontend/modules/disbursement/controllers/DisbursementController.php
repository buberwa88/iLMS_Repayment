<?php

namespace frontend\modules\disbursement\controllers;
use Yii;
use backend\modules\disbursement\models\DisbursementBatchSearch;
use backend\modules\disbursement\models\DisbursementSearch;
//use yii\web\Controller;

class DisbursementController extends \yii\web\Controller
{
     public $layout="main_hls_public";
    public function actionIndex() {

        $searchModel = new DisbursementBatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllocationBatch model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        return $this->render('profile', [
                    'model' =>  \backend\modules\disbursement\models\DisbursementBatch::findone(["disbursement_batch_id"=>$id,"learning_institution_id"=>Yii::$app->session["learn_institution_id"]]),
        ]);
    }
    public function actionDisbursed($id)
    {
         $this->layout="default_main"; 
        $searchModel = new DisbursementSearch();
        $dataProvider = $searchModel->searchhli(Yii::$app->request->queryParams,$id);

        return $this->render('disbursed_list', [
            'searchModel' => $searchModel,
            'id'=>$id,
            'dataProvider' => $dataProvider,
        ]);
    }
}

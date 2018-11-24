<?php

namespace frontend\modules\disbursement\controllers;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
use backend\modules\allocation\models\AllocationBatchSearch;
use Yii;
class AllocationController extends \yii\web\Controller
{
     /**
     * Lists all AllocationBatch models.
     * @return mixed
     */
        public $layout="main_hls_public";
    public function actionIndex() {

        $searchModel = new AllocationBatchSearch();
        $dataProvider = $searchModel->searchhli(Yii::$app->request->queryParams);

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
                    'model' => $this->findModel($id),
        ]);
    }

}

<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\RefundClaimant;
use frontend\modules\repayment\models\RefundClaimantSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RefundClaimantController implements the CRUD actions for RefundClaimant model.
 */
class RefundClaimantController extends Controller
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
     * Lists all RefundClaimant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefundClaimantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefundClaimant model.
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
     * Creates a new RefundClaimant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RefundClaimant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->refund_claimant_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RefundClaimant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->refund_claimant_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RefundClaimant model.
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
     * Finds the RefundClaimant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefundClaimant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefundClaimant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionNectadetails()
    {
        $sqlitem=0;
//  $index="S0750/0023/1891";
        #############check if this academic year exit or not
        /*
        $index = Yii::$app->request->post("registrationId") . "." . Yii::$app->request->post("year");

        $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
        $sqlitem = Yii::$app->db->createCommand("SELECT count(*) FROM `applicant` a join application app on a.`applicant_id`=app.`applicant_id` WHERE a.`f4indexno`='{$index}' AND `academic_year_id`='{$model_year->academic_year_id}'")->queryScalar();
*/
        #####################end check###################
        $f4indexno=Yii::$app->request->post("registrationId");
        $year=Yii::$app->request->post("year");
            $model = \frontend\modules\repayment\models\RefundNectaData::getNectaDataDetails($f4indexno,$year);
            if(count($model) > 0){
            // print_r($model);
            /*
            if (!is_array($model)) {
                return "<h4><font color='red'>" . $model . "</font></h4>";
            }
            */
             //return print_r($model);
            return $this->renderPartial('../loan-repayment/_necta_details', [
                'model' => $model
            ]);
        } else {
            $alert = "alert-error";
            $message = "F4 index number not found, please contact HESLB for assistance";
            return $this->renderPartial('../loan-repayment/_message', [
                'message' => $message,
                'alert' => $alert,
            ]);
        }
    }
}

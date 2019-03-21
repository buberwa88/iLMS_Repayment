<?php

namespace backend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\EmployerPenaltyPayment;
use frontend\modules\repayment\models\EmployerPenaltyPaymentSearch;
//use yii\web\Controller;
use \common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\repayment\models\EmployerSearch;
use \common\rabbit\Producer;

/**
 * EmployerPenaltyPaymentController implements the CRUD actions for EmployerPenaltyPayment model.
 */
class EmployerPenaltyPaymentController extends Controller
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
     * Lists all EmployerPenaltyPayment models.
     * @return mixed
     */
    public function actionPrintReceipt($id) {
        // get your HTML raw content without any layouts or scripts
        $htmlContent = $this->renderPartial('printReceiptEmployerPenalty',['id' =>$id]);

        // setup kartik\mpdf\Pdf component
        $pdf = Yii::$app->pdf;
        $pdf->content = $htmlContent;
        return $pdf->render();

        // return the pdf output as per the destination setting
        //return $pdf->render();
    }
}

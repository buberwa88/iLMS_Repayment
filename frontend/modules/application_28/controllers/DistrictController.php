<?php

namespace frontend\modules\application\controllers;

use Yii;
 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use common\components\Controller;
/**
 * DisbursementDependentController implements the CRUD actions for DisbursementDependent model.
 */
class DistrictController extends Controller
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
  public function actionDistrictName() {
          $out = [];
       if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $region_id =$parents[0];
                $out =  \common\models\District::getDistrict($region_id);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
     
    }
   public function actionWardName() {
          $out = [];
       if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                 //$region_id =$parents[0];
                 $district_id =$parents[0];
                $out =  \common\models\District::getWard($district_id);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
       $out =  \common\models\District::getWard(1);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
    }
}

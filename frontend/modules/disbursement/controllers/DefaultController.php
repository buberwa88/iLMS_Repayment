<?php

namespace frontend\modules\disbursement\controllers;

use yii\web\Controller;
/**
 * Default controller for the `disbursement` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout="main_hls_public";
  public function actionIndex()
    {
       
        return $this->render('index');
    }
   public function actionMyprofile()
    {
    
          $model=  \common\models\User::findOne(["user_id"=>\Yii::$app->user->identity->user_id,'login_type'=>4]);
        return $this->render('profilehli',['model'=>$model]);
    }
}

<?php

namespace frontend\modules\allocation\controllers;

use yii\web\Controller;

/**
 * Default controller for the `allocation` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
         $this->layout="main_tcu_public";
        return $this->render('index');
    }
   public function actionMyprofile()
    {
         $this->layout="main_tcu_public";
              $model=  \common\models\User::findOne(["user_id"=>\Yii::$app->user->identity->user_id,'login_type'=>3]);
        return $this->render('profilehli',['model'=>$model]);
    }
}

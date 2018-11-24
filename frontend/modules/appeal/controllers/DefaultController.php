<?php

namespace frontend\modules\appeal\controllers;

use yii\web\Controller;

/**
 * Default controller for the `appeal` module
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout="main_public_beneficiary";

    public function actionIndex()
    {
       
       return $this->redirect(['appeal/index']);
    }
}

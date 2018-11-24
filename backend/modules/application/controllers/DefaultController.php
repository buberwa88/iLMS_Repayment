<?php

namespace backend\modules\application\controllers;

use yii\web\Controller;

/**
 * Default controller for the `application` module
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
        //$this->layout="main_application";
        return $this->render('index');
    }
}

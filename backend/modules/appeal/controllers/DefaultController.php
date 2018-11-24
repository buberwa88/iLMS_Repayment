<?php

namespace backend\modules\appeal\controllers;
use yii\web\Controller;

/**
 * Default controller for the `complaint` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function behaviors()
    {
        $this->layout="main_private_main";
        
     
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
}

<?php

namespace backend\modules\report\controllers;

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
	 public $layout = "main_private";
    public function actionIndex()
    {
        return $this->render('index');
    }
}

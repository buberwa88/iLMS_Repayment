<?php
namespace console\controllers;

use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use yii\filters\VerbFilter;
date_default_timezone_set('Africa/Nairobi');

class TransactionController extends Controller {
               
      public function actionIndex($control_number, $billNumber,$date_control_received) {
		  echo $control_number."<br/>".$billNumber."<br/>".$date_control_received;
    }
}


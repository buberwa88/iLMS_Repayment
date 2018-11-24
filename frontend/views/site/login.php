<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
 
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
$this->title = '';
//$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOGIN</title>
<?= Html::cssFile("@web/login/londinium-theme.css");?>
<?= Html::cssFile("@web/login/styles.css");?>
</head>
<body class="full-width page-condensed">
    
    <div class="login-wrapper">
 <div class="form-box " id="login-box">
     <div class="popup-header">
                <span class="text-semibold">
                 <h3>LOGIN</h3>
                                                                                   
                </span>
                
            </div>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
       
     <div class="well">
                <div class="form-group has-feedback">
                     <?= $form->field($model, 'username') ?>
                    <i class="fa fa-user form-control-feedback"></i>
                </div>
         
                <div class="form-group has-feedback">
               <?= $form->field($model, 'password')->passwordInput() ?>
                  
                </div>
                <div class="row form-actions">
                    <div class="col-xs-6">
                        <div class="checkbox checkbox-success">
                            <label>
                                <input class="styled" type="checkbox">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-warning pull-right"><i class="fa   fa-forward"> </i> Login </button>
                    </div>
                   
                </div>
         
            </div>
 
    <?php ActiveForm::end(); ?>
 
</div>
       
    </div>
   
 
     
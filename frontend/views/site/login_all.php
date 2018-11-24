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
 
<div class="disbursement-create">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
<body class="full-width page-condensed">
    
    <div class="login-wrapper">
 <div class="form-box " id="login-box">
  
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
     <p>Please login with your username and password below.</p>
     <div class="well col-xs-6" >
                <div class="form-group has-feedback">
                     <?= $form->field($model, 'username') ?>
                  
                </div>
         
                <div class="form-group has-feedback">
               <?= $form->field($model, 'password')->passwordInput() ?>
                  
                </div>
                <div class="row form-actions">
                    <div class="col-xs-6">
                        <div class="checkbox checkbox-success">
                            
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
</body>
        </div>
 </div>
</div>
 
     
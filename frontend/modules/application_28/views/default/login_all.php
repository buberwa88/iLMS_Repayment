<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
$this->title = '';
//$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<body class="full-width page-condensed">
    
    <div class="login-wrapper">
 <div class="form-box " id="login-box">
   <div class="well col-lg-6 col-lg-12" >
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
     <p>Please login with your username and password below.</p>
   
                <div class="form-group has-feedback">
                     <?= $form->field($model, 'username')->textInput(['data-toggle' => 'tooltip',
                'data-placement' => 'top', 'title' => 'Username is  form 4 index number eg S0750.0023.2006']) ?>
                  
                </div>
         
                <div class="form-group has-feedback">
               <?= $form->field($model, 'password')->passwordInput() ?>
                  
                </div>
              <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'captchaAction'=>'/site/captcha',
                ]) ?>
                <div class="row form-actions">
                    <div class="col-lg-6 ">
                        <div class="checkbox checkbox-success">
                            <div class="col-xs-6">
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/password-recover'])?>" class="btn btn-default"><i class=""></i> Forgot Password?Click here to Reset</a>
                    </div>   
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
    
 
     
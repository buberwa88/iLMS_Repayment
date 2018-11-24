<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;



?>


  

<div class="site-login">

    <div class="row">

        <div  class="col-sm-6">
         
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <div style="color:#999;margin:1em 0"> If you forgot your password you can
<?php   echo Html::a('reset it', ['site/reset-password']); ?>
                . </div>
            <div class="form-group">
<?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
                <?php ActiveForm::end(); ?>
        </div>
        
        <div  class="col-sm-6">
          
    
        </div>

</div>
</div>

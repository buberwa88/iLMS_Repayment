<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;

$this->title = "Login | ILMS";
?>
<div class="login-wrapper">
    <div class="form-box" id="login-box">
        <div class="popup-header">
            <span class="text-semibold"><h3>LOGIN</h3></span>
        </div>
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="well" style="border-color:#AAA;">
            <div class="form-group has-feedback">
<?= $form->field($model, 'username')->textInput()  ?>
                <i class="fa fa-user form-control-feedback"></i>
            </div>
            <div class="form-group has-feedback">
<?= $form->field($model, 'password')->passwordInput()  ?>
                <i class="fa fa-lock form-control-feedback"></i>
            </div>
            <div class="row form-actions">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary pull-right">Login </button>
                </div>
            </div>
        </div>
<?php ActiveForm::end(); ?>
    </div>
</div>
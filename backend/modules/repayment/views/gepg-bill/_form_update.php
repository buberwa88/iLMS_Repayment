<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgBill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-bill-form">

    <?php $form = ActiveForm::begin(); ?>


	<?= $form->field($model, 'cancelled_reason')->textarea(['rows' => '3']) ?>

  

    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/gepg-bill/index'], ['class' => 'btn btn-warning']);
ActiveForm::end();
?>
</div>

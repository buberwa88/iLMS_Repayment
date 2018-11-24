<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationCycleStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-cycle-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'application_cycle_status_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'application_cycle_status_description')->textInput(['maxlength' => true]) ?>

      <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
      <?php
          echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
       ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
           ActiveForm::end();
          ?>
    </div>

</div>

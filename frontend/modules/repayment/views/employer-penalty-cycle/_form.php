<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerPenaltyCycle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employer-penalty-cycle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employer_id')->textInput() ?>

    <?= $form->field($model, 'repayment_deadline_day')->textInput() ?>

    <?= $form->field($model, 'penalty_rate')->textInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'duration_type')->dropDownList([ 'd' => 'D', 'w' => 'W', 'm' => 'M', 'y' => 'Y', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'cycle_type')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

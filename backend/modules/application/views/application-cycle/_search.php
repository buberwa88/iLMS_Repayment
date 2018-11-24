<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationCycleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-cycle-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'application_cycle_id') ?>
    
    <?= $form->field($model, 'application_cycle_status_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

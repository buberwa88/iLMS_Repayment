<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\GvtEmployeeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gvt-employee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gvt_employee') ?>

    <?= $form->field($model, 'vote_number') ?>

    <?= $form->field($model, 'vote_name') ?>

    <?= $form->field($model, 'Sub_vote') ?>

    <?= $form->field($model, 'sub_vote_name') ?>

    <?php // echo $form->field($model, 'check_number') ?>

    <?php // echo $form->field($model, 'f4indexno') ?>

    <?php // echo $form->field($model, 'first_name') ?>

    <?php // echo $form->field($model, 'middle_name') ?>

    <?php // echo $form->field($model, 'surname') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'NIN') ?>

    <?php // echo $form->field($model, 'employment_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'payment_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

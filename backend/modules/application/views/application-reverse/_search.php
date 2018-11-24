<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationReverseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-reverse-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'application_reverse_id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'comment') ?>

    <?= $form->field($model, 'reversed_by') ?>

    <?= $form->field($model, 'reversed_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

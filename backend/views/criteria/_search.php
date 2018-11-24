<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-criteria-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'criteria_id')->textInput(['placeholder' => 'Criteria']) ?>

    <?= $form->field($model, 'criteria_description')->textInput(['maxlength' => true, 'placeholder' => 'Criteria Description']) ?>

    <?= $form->field($model, 'criteria_origin')->textInput(['placeholder' => 'Criteria Origin']) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

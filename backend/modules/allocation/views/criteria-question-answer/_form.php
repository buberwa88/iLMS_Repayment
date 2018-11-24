<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaQuestionAnswer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="criteria-question-answer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'criteria_question_id')->textInput() ?>

    <?= $form->field($model, 'qresponse_source_id')->textInput() ?>

    <?= $form->field($model, 'response_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

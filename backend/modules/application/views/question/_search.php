<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QuestionSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="question-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'question_id') ?>

    <?= $form->field($model, 'question') ?>

    <?= $form->field($model, 'response_control') ?>

    <?= $form->field($model, 'response_data_type') ?>

    <?= $form->field($model, 'response_data_length') ?>

    <?php // echo $form->field($model, 'hint') ?>

    <?php // echo $form->field($model, 'qresponse_source_id') ?>

    <?php // echo $form->field($model, 'require_verification') ?>

    <?php // echo $form->field($model, 'verification_prompt') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

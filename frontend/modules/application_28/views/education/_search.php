<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\EducationSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="education-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'education_id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'level') ?>

    <?= $form->field($model, 'learning_institution_id') ?>

    <?= $form->field($model, 'registration_number') ?>

    <?php // echo $form->field($model, 'programme_name') ?>

    <?php // echo $form->field($model, 'programme_code') ?>

    <?php // echo $form->field($model, 'entry_year') ?>

    <?php // echo $form->field($model, 'completion_year') ?>

    <?php // echo $form->field($model, 'division') ?>

    <?php // echo $form->field($model, 'points') ?>

    <?php // echo $form->field($model, 'is_necta') ?>

    <?php // echo $form->field($model, 'class_or_grade') ?>

    <?php // echo $form->field($model, 'gpa_or_average') ?>

    <?php // echo $form->field($model, 'avn_number') ?>

    <?php // echo $form->field($model, 'under_sponsorship') ?>

    <?php // echo $form->field($model, 'sponsor_proof_document') ?>

    <?php // echo $form->field($model, 'olevel_index') ?>

    <?php // echo $form->field($model, 'alevel_index') ?>

    <?php // echo $form->field($model, 'institution_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

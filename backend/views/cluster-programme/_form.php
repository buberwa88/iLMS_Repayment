<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterProgramme */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cluster-programme-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'academic_year_id')->textInput() ?>

    <?= $form->field($model, 'cluster_definition_id')->textInput() ?>

    <?= $form->field($model, 'sub_cluster_definition_id')->textInput() ?>

    <?= $form->field($model, 'programme_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

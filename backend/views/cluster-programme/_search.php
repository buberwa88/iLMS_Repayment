<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterProgrammeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cluster-programme-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cluster_programme_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'cluster_definition_id') ?>

    <?= $form->field($model, 'sub_cluster_definition_id') ?>

    <?= $form->field($model, 'programme_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

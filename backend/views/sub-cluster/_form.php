<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\SubCluster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-cluster-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sub_cluster_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_cluster_desc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

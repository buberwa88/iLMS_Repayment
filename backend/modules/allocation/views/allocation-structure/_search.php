<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationStructureSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-allocation-structure-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_structure_id')->textInput(['placeholder' => 'Allocation Structure']) ?>

    <?= $form->field($model, 'structure_name')->textInput(['maxlength' => true, 'placeholder' => 'Structure Name']) ?>

    <?= $form->field($model, 'parent_id')->textInput(['placeholder' => 'Parent']) ?>

    <?= $form->field($model, 'order_level')->textInput(['placeholder' => 'Order Level']) ?>

    <?= $form->field($model, 'status')->textInput(['placeholder' => 'Status']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

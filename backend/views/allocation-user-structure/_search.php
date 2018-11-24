<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationUserStructureSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-allocation-user-structure-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'allocation_user_structure_id')->textInput(['placeholder' => 'Allocation User Structure']) ?>

    <?= $form->field($model, 'allocation_structure_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\modules\allocation\models\AllocationStructure::find()->orderBy('allocation_structure_id')->asArray()->all(), 'allocation_structure_id', 'allocation_structure_id'),
        'options' => ['placeholder' => 'Choose Allocation structure'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\modules\allocation\models\User::find()->orderBy('user_id')->asArray()->all(), 'user_id', 'username'),
        'options' => ['placeholder' => 'Choose User'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'status')->textInput(['placeholder' => 'Status']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

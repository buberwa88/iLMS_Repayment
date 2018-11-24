<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-complaint-category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'complaint_category_id')->textInput(['placeholder' => 'Complaint Category']) ?>

    <?= $form->field($model, 'complaint_category_name')->textInput(['maxlength' => true, 'placeholder' => 'Complaint Category Name']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput(['placeholder' => 'Status']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

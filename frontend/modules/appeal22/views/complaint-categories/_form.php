<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complaint-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'complaint_category_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList(['1'=>'Active', '0'=>'In Actve']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'pull-right btn btn-success ' : 'pull-right btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

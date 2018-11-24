<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sql')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sql_where')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sql_order')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sql_group')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'column1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'column2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'column3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'column4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'column5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condition1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condition2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condition3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condition4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condition5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'package')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

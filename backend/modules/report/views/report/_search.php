<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'file_name') ?>

    <?= $form->field($model, 'field1') ?>

    <?php // echo $form->field($model, 'field2') ?>

    <?php // echo $form->field($model, 'field3') ?>

    <?php // echo $form->field($model, 'field4') ?>

    <?php // echo $form->field($model, 'field5') ?>

    <?php // echo $form->field($model, 'type1') ?>

    <?php // echo $form->field($model, 'type2') ?>

    <?php // echo $form->field($model, 'type3') ?>

    <?php // echo $form->field($model, 'type4') ?>

    <?php // echo $form->field($model, 'type5') ?>

    <?php // echo $form->field($model, 'description1') ?>

    <?php // echo $form->field($model, 'description2') ?>

    <?php // echo $form->field($model, 'description3') ?>

    <?php // echo $form->field($model, 'description4') ?>

    <?php // echo $form->field($model, 'description5') ?>

    <?php // echo $form->field($model, 'sql') ?>

    <?php // echo $form->field($model, 'sql_where') ?>

    <?php // echo $form->field($model, 'sql_order') ?>

    <?php // echo $form->field($model, 'sql_group') ?>

    <?php // echo $form->field($model, 'column1') ?>

    <?php // echo $form->field($model, 'column2') ?>

    <?php // echo $form->field($model, 'column3') ?>

    <?php // echo $form->field($model, 'column4') ?>

    <?php // echo $form->field($model, 'column5') ?>

    <?php // echo $form->field($model, 'condition1') ?>

    <?php // echo $form->field($model, 'condition2') ?>

    <?php // echo $form->field($model, 'condition3') ?>

    <?php // echo $form->field($model, 'condition4') ?>

    <?php // echo $form->field($model, 'condition5') ?>

    <?php // echo $form->field($model, 'package') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

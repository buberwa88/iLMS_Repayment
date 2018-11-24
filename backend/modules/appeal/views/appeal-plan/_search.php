<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AcademicYear;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealPlanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-appeal-plan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'appeal_plan_id')->textInput(['placeholder' => 'Appeal Plan']) ?>

    <?= $form->field($model, 'academic_year_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(AcademicYear::find()->orderBy('academic_year_id')->asArray()->all(), 'academic_year_id', 'academic_year'),
        'options' => ['placeholder' => 'Choose Academic year'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'appeal_plan_title')->textInput(['maxlength' => true, 'placeholder' => 'Appeal Plan Title']) ?>
 
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

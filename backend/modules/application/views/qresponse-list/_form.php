<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QresponseList $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="qresponse-list-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'response' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Response...', 'maxlength' => 50]],

            'is_active' => ['type' => Form::INPUT_CHECKBOX, 'options' => ['placeholder' => 'Enter Is Active...']],

        ]

    ]);

   ?>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
    </div>
</div>

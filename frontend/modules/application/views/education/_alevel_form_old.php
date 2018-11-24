<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="education-form">

    <?php
    $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
         'enableClientValidation'=> false,
            ]);
    
     echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
              'institution_name' => [''=>'Primary School Name', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Institution Name...', 'maxlength' => 50]],
        ]
    ]);
    
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
             'entry_year' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Entry Year...']],
             'completion_year' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Completion Year...']],
                     ]
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add Primary Education') : Yii::t('app', 'Update Primary Education'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end();
    ?>

</div>

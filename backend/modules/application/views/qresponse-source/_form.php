<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QresponseSource $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="qresponse-source-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'source_table' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Source Table...', 'maxlength' => 100]],

            'source_table_value_field' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Source Value Field...', 'maxlength' => 100]],

            'source_table_text_field' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Source Text Field...', 'maxlength' => 100]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>

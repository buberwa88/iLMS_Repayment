<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\Notification $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'user_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter User ID...']],

            'subject' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Subject...', 'maxlength' => 150]],

            'notification' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Notification...','rows' => 6]],

            'date_created' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'date_read' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'is_read' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Is Read...']],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>

 
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
        'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Higher Learning Institution',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\LearningInstitution::getHigherLearningInstitution(), 'learning_institution_id', 'institution_name'),
                'options' => [
                    'prompt' => ' Select Higher Learning Institution',
                ],
            ],
        ],
    ]
]);
echo $form->field($model, 'programe_file')->widget(\kartik\file\FileInput::classname(), [
//    'options' => ['accept' => '.xls/*'],
]);
?>
<div class="text-right">
    <?= Html::submitButton('Import Data', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>

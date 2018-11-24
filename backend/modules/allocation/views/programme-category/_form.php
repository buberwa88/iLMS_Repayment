 
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'programme_category_name' => ['label' => 'Category Name', 'options' => ['placeholder' => 'Programme Category Name...']],
    ]
]);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'programme_category_desc' => ['label' => 'Description', 'options' => ['placeholder' => 'Description']],
    ]
]);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'is_active' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//            'label' => 'is_active',
            'options' => [
                'data' => \backend\modules\allocation\models\ProgrammeCategory::getStatusList(),
            ],
        ],
    ]
]);
?>
<div class="text-right">

    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);

    ActiveForm::end();
    ?>
    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
</div>

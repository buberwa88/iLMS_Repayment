 
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
        'group_name' => ['label' => 'Group Name', 'options' => ['placeholder' => 'Enter Group Name...']],
    ]
]);

echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'group_code' => ['label' => 'Group Code', 'options' => ['placeholder' => 'Group Code...']],
    ]
]);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'type' => Form::INPUT_TEXTAREA,
        'programme_group_desc' => [
            'options' => ['placeholder' => 'Group Description...']],
    ]
]);

echo Form::widget([// fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'study_level' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//            'label' => 'Level of Study',
            'options' => [
                'data' => yii\helpers\ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->asArray()->all(), 'applicant_category_id', 'applicant_category'),
                'options' => [
                    'prompt' => '--select--',
                ],
            ],
        ],
        'is_active' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//            'label' => 'is_active',
            'options' => [
                'data' => \backend\modules\allocation\models\ProgrammeGroup::getStatusList(),
            ],
        ],
    ]
]);
?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>

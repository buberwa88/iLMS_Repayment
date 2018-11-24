 
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
        'programme_group_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme Group',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\ProgrammeGroup::find()->where(['is_active'=>  backend\modules\allocation\models\ProgrammeGroup::STATUS_ACTIVE])->asArray()->all(), 'programme_group_id', 'group_name'),
                'options' => [
                    'prompt' => ' Select Programme Group',
                ],
            ],
        ],
    ]
]);

echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'programme_name' => ['label' => 'Programme Name', 
            'options' => ['placeholder' => 'Enter Programme Name']],
    ]
]);

echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'programme_code' => ['label' => 'Programme Code', 
            'options' => ['placeholder' => 'Enter Programme Code']],
    ]
]);

echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'years_of_study' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => Yii::$app->params['programme_years_of_study'],
                'options' => [
                    'prompt' => 'Select years of Study',
                ],
            ],
        ],
        'is_active' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
//            'label' => 'is_active',
            'options' => [
                'data' => \backend\modules\allocation\models\Programme::getStatusList(),
            ],
        ],
    ]
]);
//print_r($model->errors);
?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']); ?>
    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>

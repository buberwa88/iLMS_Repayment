<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
echo Form::widget([// fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'report_id' => ['type' => Form::INPUT_WIDGET,
        'label'=>'Report',    
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\report\models\Report::find()->orderBy('name')->all(), 'id', 'name'),
                'options' => [
                    'prompt' => '-- Select --',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true
                ],
            ],
        ],
        'user_role' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\report\models\Report::getUserRoles(), 'parent', 'parent'),
                'options' => [
                    'prompt' => '-- Select --',
                ],
//                'pluginOptions' => [
//                    'allowClear' => true,
//                    'multiple' => true
//                ],
            ],
        ],
        'user_id' => ['type' => Form::INPUT_WIDGET,
        'label'=>'User',    
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\common\models\User::findBySql("SELECT user_id, CONCAT(firstname,' ',middlename,' ',surname) AS username FROM user WHERE login_type=:login_type ORDER BY username ASC", [':login_type' => 5])->all(), 'user_id', 'username'),
                'options' => [
                    'prompt' => '-- Select --',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true
                ],
            ],
        ],
    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
</div>







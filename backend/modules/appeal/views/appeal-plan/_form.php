<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AcademicYear;


/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealPlan */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'AppealQuestion', 
        'relID' => 'appeal-question', 
        'value' => \yii\helpers\Json::encode($model->appealQuestions),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="appeal-plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>
 

    <?= $form->field($model, 'academic_year_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(AcademicYear::find()->orderBy('academic_year_id')->asArray()->all(), 'academic_year_id', 'academic_year'),
        'options' => ['placeholder' => 'Choose Academic year'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'appeal_plan_title')->textInput(['maxlength' => true, 'placeholder' => 'Appeal Plan Title']) ?>

    <?= $form->field($model, 'appeal_plan_desc')->textInput(['maxlength' => true, 'placeholder' => 'Appeal Plan Desc']) ?>
   <?= $form->field($model, 'status')->widget(\kartik\widgets\Select2::classname(), [
        'data' => [1=>'Active',0=>'InActive'],
        'options' => ['placeholder' => 'Choose Status'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('AppealQuestion'),
            'content' => $this->render('_formAppealQuestion', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->appealQuestions),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
    <div class="form-group">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if(Yii::$app->controller->action->id != 'create'): ?>
        <?= Html::submitButton('Save As New', ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
    <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

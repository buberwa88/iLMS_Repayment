<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use backend\modules\application\models\AttachmentDefinition;
use backend\modules\application\models\QresponseList;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QpossibleResponse $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="qpossible-response-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [

            //'question_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Question ID...']],

            'qresponse_list_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> yii\helpers\ArrayHelper::map(QresponseList::find()->where("is_active = 1 AND qresponse_list_id NOT IN (select qresponse_list_id from qpossible_response where question_id = {$question_id} AND qpossible_response_id <> '{$model->qpossible_response_id}' )")->all(), 'qresponse_list_id', 'response'),   'options' => ['prompt' => '']],

           // 'attachment_definition_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> yii\helpers\ArrayHelper::map(AttachmentDefinition::find()->where("is_active = 1")->all(), 'attachment_definition_id', 'attachment_desc'),   'options' => ['prompt' => '']],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>

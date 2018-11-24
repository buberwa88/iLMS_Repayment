<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use frontend\modules\application\models\AttachmentDefinition;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\ApplicantAttachment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="applicant-attachment-form">

    <?php 
    
    if($model->attachment_path == NULL || $model->attachment_path == ""){
        $label = 'Uploading '.AttachmentDefinition::findOne($model->attachment_definition_id)->attachment_desc;
    } else {
        $label = 'Modifying|Replacing '.AttachmentDefinition::findOne($model->attachment_definition_id)->attachment_desc;
    }
    $form = ActiveForm::begin(
            [
                'type' => ActiveForm::TYPE_VERTICAL,
                'options'=>[
                   'enctype' => 'multipart/form-data' 
                ]
            ]
            );
    
        echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'attachment_path' => ['type' => Form::INPUT_FILE, 'label'=>$label],

           

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Upload') : Yii::t('app', 'Upload'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>

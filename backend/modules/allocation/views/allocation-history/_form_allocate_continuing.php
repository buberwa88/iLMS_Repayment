<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use kartik\depdrop\DepDrop;
USE backend\modules\allocation\models\AllocationPlan;
?>
<div class="allocation-batch-create">
    <div class="panel panel-info">
        <div class="panel-body">
                <?php if (Yii::$app->session->hasFlash('failure')) { ?>
                <div class="alert alert alert-warning" role="alert" style="padding: 5px;">
                <?php echo Yii::$app->session->getFlash('failure'); ?>
                </div>
            <?php }
            ?>
            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'action' => ['/allocation/allocation-history/allocate-local-continuing']
            ]);
            echo Form::widget([ // fields with labels
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'academic_year_id' => ['type' => Form::INPUT_HIDDEN,
                    ],
                    'allocation_name' => ['type' => Form::INPUT_TEXT,
                        'options' => [
                            'placeholder' => ' Enter Unique name for the allocation you want to perform'
                        ],
                    ],
                    'description' => ['type' => Form::INPUT_TEXTAREA,
                        'label' => 'Description',
                        'options' => [
                            'placeholder' => ' Enter Summarised information about the allocation you want to perform'
                        ],
                    ],
                    'study_level' => ['type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => ArrayHelper::map(\backend\modules\allocation\models\ApplicantCategory::find()->asArray()->all(), 'applicant_category_id', 'applicant_category'),
                        'options' => [
                            'prompt' => '--select--'
                        ],
                    ],
                ]
            ]);
            ?>
            <div class="text-right">
                <?= Html::submitButton('Award Loan', ['class' => 'btn btn-primary']) ?>
                <?php
                ActiveForm::end();
                ?>
            </div>

        </div>

    </div>
</div>
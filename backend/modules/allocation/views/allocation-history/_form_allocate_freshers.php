<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use kartik\depdrop\DepDrop;
USE backend\modules\allocation\models\AllocationPlan;
?>
<div class="allocation-freshers-create">
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
                        'action' => ['/allocation/allocation-history/allocate-local-freshers']
            ]);
            echo Form::widget([// fields with labels
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
                    'allocation_framework_id' => ['type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => ArrayHelper::map(AllocationPlan::find()->where(['academic_year_id' => $model->academic_year_id, 'allocation_plan_stage' => AllocationPlan::STATUS_ACTIVE])->asArray()->all(), 'allocation_plan_id', 'allocation_plan_title'),
                        'label' => 'Framework to Use',
                        'options' => [
                            'prompt' => '--select--'
                        ],
                    ],
                    'study_level' => ['type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => ArrayHelper::map(\backend\modules\allocation\models\ApplicantCategory::find()->asArray()->all(), 'applicant_category_id', 'applicant_category'),
                        'options' => [
                            'prompt' => '--select--'
                        ],
                    ],
//                    'place_of_study' => [
//                        'label' => 'Country of Study',
//                        'type' => Form::INPUT_WIDGET,
//                        'widgetClass' => \kartik\select2\Select2::className(),
//                        'options' => [
//                            'data' => backend\modules\allocation\models\AllocationBudget::getPlaceOfStudies(),
//                            'options' => [
//                                'prompt' => '--select --',
//                            ],
//                        ],
//                    ],
//                    'student_type' => ['type' => Form::INPUT_WIDGET,
//                        'widgetClass' => \kartik\select2\Select2::className(),
//                        'options' => [
//                            'data' => backend\modules\allocation\models\LoanItem::getStudentsType(),
//                            'options' => [
////                                'id' => 'student-type-id',
//                                'prompt' => '--select--'
//                            ],
//                        ],
//                    ],
                ]
            ]);
            ?>
            <div class="text-right">
                <?= Html::submitButton('Process Loan Allocation', ['class' => 'btn btn-primary']) ?>
                <?php
                ActiveForm::end();
                ?>
            </div>

        </div>

    </div>
</div>
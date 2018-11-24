<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
?>
<div class="panel panel-info">
    <div class="panel-heading">
        Institution  Detail
    </div>
    <div class="panel-body">
        <?php
           if(!$model->isNewRecord&&$model->ward_id>0){
       $modelz=  \backend\modules\disbursement\models\Ward::findOne($model->ward_id);
         
       $model->district_id=$modelz->district_id;
       ################find region Id ##############
       
        $modelr= \common\models\District::findOne($modelz->district_id);
        $model->region_id=$modelr->region_id;
         }
        echo Form::widget([ // fields with labels
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'institution_type' => ['type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\select2\Select2::className(),
                    'label' => 'Institution Type',
                    'options' => [
                        'data' => backend\modules\allocation\models\LearningInstitution::getInstitutionTypes(),
                        'options' => [
                            'prompt' => 'Institution Type',
                        ],
                    ],
                ],
                'country' => ['type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\select2\Select2::className(),
                    'label' => 'Country',
                    'options' => [
                        'data' => ArrayHelper::map(\frontend\modules\application\models\Country::find()->asArray()->all(), 'country_code', 'country_name'),
                        'options' => [
                            'prompt' => ' Select Parent',
                        ],
                    ],
                ],
                'ownership' => ['type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\select2\Select2::className(),
                    'label' => 'Ownership',
                    'options' => [
                        'data' => \backend\modules\allocation\models\LearningInstitution::getOwneshipsList(),
                        'options' => [
                            'prompt' => '-- Select --',
                        ],
                    ],
                ],
                'institution_name' => ['label' => 'Institution Name', 'labelSpan' => 4, 'options' => ['placeholder' => 'Institution Name', 'labelSpan' => 4]],
                'institution_code' => ['label' => 'Institution Code', 'options' => ['placeholder' => 'Institution Code...']],
                'parent_id' => ['type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\select2\Select2::className(),
                    'label' => 'Parent Name',
                    'options' => [
                        'data' => ArrayHelper::map(\backend\modules\allocation\models\LearningInstitution::getHigherLearningInstitution(), 'learning_institution_id', 'institution_name'),
                        'options' => [
                            'prompt' => ' Select Parent Institution',
                        ],
                    ],
                ],
                'phone_number' => ['label' => 'Institution Phone', 'options' => ['placeholder' => 'Institution Phone']],
                'email' => ['label' => 'Institution email', 'options' => ['placeholder' => 'Institution email']],
                'physical_address' => ['label' => 'Institution Address', 'options' => ['placeholder' => 'Institution Address']],
                                'region_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Region',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'region_id', 'region_name'),
                    'options' => [
                        'prompt' => 'Select Region ',
                        //'id'=>'region_Id'
                    ],
                ],
            ],
    'district_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'District',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' =>  ArrayHelper::map(\common\models\District::find()->where(['region_id'=>$model->region_id])->all(), 'district_id', 'district_name'),
                      'options' => [
                        'prompt' => 'Select District ',
                       // 'id'=>'district_id'
                    ],
                    'pluginOptions' => [
                        'depends' => ['learninginstitution-region_id'],
                        'placeholder' => 'Select ',
                        'url' => Url::to(['/allocation/district/district-name']),
                    ],
                ],
            ],
              'ward_id' => ['type' => Form::INPUT_WIDGET,
               // 'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Ward',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' =>  ArrayHelper::map(backend\modules\application\models\Ward::find()->where(['district_id'=>$model->district_id])->all(), 'ward_id', 'ward_name'),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['learninginstitution-district_id'],
                        'placeholder' => 'Select ',
                        'url' => Url::to(['/allocation/district/ward-name']),
                    ],
                ],
            ],
//                'ward_id' => ['type' => Form::INPUT_WIDGET,
//                    'widgetClass' => \kartik\select2\Select2::className(),
//                    'label' => 'Ward',
//                    'options' => [
//                        'data' => ArrayHelper::map(\backend\modules\application\models\Ward::find()->asArray()->all(), 'ward_id', 'ward_name'),
//                        'options' => [
//                            'prompt' => ' Select Ward',
//                        ],
//                    ],
//                ],
                'bank_account_number' => ['label' => 'Bank Account Number', 'options' => ['placeholder' => 'Bank Account Number']],
                'bank_account_name' => ['label' => 'Bank Account Name', 'options' => ['placeholder' => 'Bank Account Name']],
                'is_active' => ['type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\select2\Select2::className(),
                    'label' => 'Institution Status',
                    'options' => [
                        'data' => \backend\modules\allocation\models\LearningInstitution::getStatusList(),
                    ],
                ],
            ]
        ]);
        ?>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        Contact Personal Detail
    </div>
    <div class="panel-body">
        <?php
        echo Form::widget([ // fields with labels
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'cp_firstname' => ['label' => 'Contact First Name', 'options' => ['placeholder' => 'Contact First Name']],
            // 'entered_by_applicant'=>['label'=>'Institution Address', 'options'=>['placeholder'=>'Institution Address']],
            ]
        ]);
        echo Form::widget([ // fields with labels
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'cp_middlename' => ['label' => 'Contact Middle Name', 'options' => ['placeholder' => 'Contact Middle Name']],
            // 'entered_by_applicant'=>['label'=>'Institution Address', 'options'=>['placeholder'=>'Institution Address']],
            ]
        ]);
        echo Form::widget([ // fields with labels
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'cp_surname' => ['label' => 'Contact Surname', 'options' => ['placeholder' => 'Contact Surname']],
            //    'entered_by_applicant'=>['label'=>'Institution Address', 'options'=>['placeholder'=>'Institution Address']],
            ]
        ]);

        echo Form::widget([ // fields with labels
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'cp_email_address' => ['label' => 'Contact Email Address', 'options' => ['placeholder' => 'Contact Email Address']],
            //    'entered_by_applicant'=>['label'=>'Institution Address', 'options'=>['placeholder'=>'Institution Address']],
            ]
        ]);
        echo Form::widget([ // fields with labels
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'cp_phone_number' => ['label' => 'Contact Phone Number', 'options' => ['placeholder' => 'Contact Phone Number'], 'columnOptions' => ['colspan' => 2]],
            //  'entered_by_applicant'=>['label'=>'Institution Address', 'options'=>['placeholder'=>'Institution Address']],
            ]
        ]);
        ?>
    </div>
</div>
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

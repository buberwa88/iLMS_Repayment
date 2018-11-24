 

<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use kartik\detail\DetailView;
use kartik\tabs\TabsX;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var app\models\Students $model
 * @var yii\widgets\ActiveForm $form
 */
?>


<div class="users-form">
    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]);



    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [
//                'role' => ['type' => Form::INPUT_WIDGET,
//                //'staticValue' => [1=>''],
//                'widgetClass' => \kartik\select2\Select2::className(),
//                'label' => 'Role',
//                'options' => [
//                    'data' =>  ArrayHelper::map(\app\models\AuthItem::find()->where(['type' => 1])->asArray()->all(), 'name', 'description'),
//                    'options' => [
//                        'prompt' => '',
//                    // 'disabled' => $model->isNewrecord ? false : true,
//                    ],
//                ],
//            ],

            'financial_year' => ['type' => Form::INPUT_WIDGET,
                'staticValue' => 'TZA',
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Country',
                'options' => [

                    'data' => [1 => 'TZA'],
                    'options' => [
                        'prompt' => '',
                    // 'disabled' => $model->isNewrecord ? false : true,
                    ],
                ],
            ],
//            'region_code' => [
//                'type' => Form::INPUT_WIDGET,
//                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
//                'label' => 'Region',
//                'widgetClass' => DepDrop::className(),
//                'options' => [
//                     //'data' => [$model->region_code => app\models\RegionTcra::find()->where("code = {$model->region_code}")->one()->region],
//                    //'disabled' => $model->isNewrecord ? false : true,
//                    'pluginOptions' => [
//                        'depends' => ['findduplicates-country_code'],
//                        'placeholder' => 'All Regions',
//                        'url' => Url::to(['/users/region']),
//                    ],
//                ],
//                'columnOptions' => ['id' => 'region_code'],
//            ],
//            'district_code' => [
//                'type' => Form::INPUT_WIDGET,
//                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
//                'label' => 'District',
//                'widgetClass' => DepDrop::className(),
//                'options' => [
//                    //'data' => [$model->district_code => \app\models\DistrictTcra::find()->where(" code = {$model->district_code}")->one()->district],
//                    //'disabled' => $model->isNewrecord ? false : true,
//                    'pluginOptions' => [
//                        'depends' => ['findduplicates-region_code'],
//                        'placeholder' => 'All District',
//                        'url' => Url::to(['/users/district']),
//                    ],
//                ],
//                'columnOptions' => ['id' => 'district_code'],
//            ],
//            'ward_code' => [
//                'type' => Form::INPUT_WIDGET,
//                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
//                'label' => 'Ward',
//                'widgetClass' => DepDrop::className(),
//                'options' => [
//                    //'data' => [$model->ward_code => \app\models\WardTcra::find()->where(" code = {$model->ward_code}")->one()->ward],
//                    //'disabled' => $model->isNewrecord ? false : true,
//                    'pluginOptions' => [
//                        'depends' => ['findduplicates-district_code'],
//                        'placeholder' => 'All Wards',
//                        'url' => Url::to(['/users/ward']),
//                    ],
//                ],
//                'columnOptions' => ['id' => 'ward_code'],
//            ],
        ],
    ]);

 


   
   
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'SEARCH...') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);

    ActiveForm::end();
    ?>

</div>
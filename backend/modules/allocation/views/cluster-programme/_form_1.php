
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

;

use wbraganca\dynamicform\DynamicFormWidget;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'dynamic-form']);

echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['in', 'is_current', [0, 1]])->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'id' => 'academic_year',
                    'placeholder' => '--select--'
                ],
            ],
        ],
        'programme_category_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme Category',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\ProgrammeCategory::find()->asArray()->all(), 'programme_category_id', 'programme_category_name'),
                'options' => [
                    'prompt' => 'Select Programme Category',
                    'id' => 'programme_category'
                ],
            ],
        ]
    ]
]);
?>
<?php
//Adding programme priority setup
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Programe Cost - Year# " + (index + 1))
    });
});

//jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
//    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
//        jQuery(this).html("Programe Cost - Year# " + (index + 1))
//    });
//});
';
$this->registerJs($js);
?>
<div style="margin: 1%;">
    <?php
    if ($model) {
        ?>  
        <?php
        \wbraganca\dynamicform\DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            // 'limit' => $model->years_of_study,
            // the maximum times, an element can be cloned (default 999)
            'min' => 0, //  (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $models[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'programme_group_id', 'programme_id',
                'programme_priority'
            ],
        ]);
        ?>
        <div class="panel panel-default" style="clear: both">
            <div class="panel-heading">
                <span class="panel-title-address">Programmes List</span>
                <button type="button" style="margin-bottom: 2%;padding:0.3%;font-size:13px"class="pull-right add-item btn btn-success btn-xs">
                    <i class="fa fa-plus"></i> Add Programme
                </button>
            </div>
            <div class="panel-body" style="margin: 0;">
                <div class="clearfix"></div>
                <div class=" container-items   panel-default" style="clear: both;"><!-- widgetBody -->
                    <!--<div class=" container-items">-->
                    <div class="item row">
                        <div class="col-sm-5">
                            <?php
                            echo \kartik\builder\Form::widget([ // fields with labels
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'programme_group_id' => ['type' => Form::INPUT_TEXT,
                                        'options' => [
                                            'id' => 'academic_year',
                                            'placeholder' => '--select--'
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
                        </div>

                        <div class="col-sm-4">
                            <?php
                            echo \kartik\builder\Form::widget([ // fields with labels
                                'model' => $model,
                                'form' => $form,
                                'attributes' => [
                                    'programme_priority' => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'options' => [
                                            'data' => Yii::$app->params['cluster_priority_order_list'],
                                            'options' => [
                                                'prompt' => '-- select --'
                                            ]
                                        ],
                                    ]],
                            ]);
                            ?>
                        </div>

                        <div class="col-sm-1">
                            <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        </div>

                    </div><!-- end:row -->

                    <!--</div>-->
                </div>
            </div>
        </div>
        <?php
        DynamicFormWidget::end();
        ?>

        <?php
    }
    ?>
</div>
<div class="text-right">
    <?= $form->field($model, 'cluster_definition_id')->label(FALSE)->hiddenInput(["value" => $model->isNewRecord ? $cluster_id : $model->cluster_definition_id]) ?>

    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['index', 'id' => $cluster_id], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>

</div>

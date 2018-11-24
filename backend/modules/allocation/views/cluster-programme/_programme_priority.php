<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use \kartik\builder\Form;
use yii\helpers\ArrayHelper;

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
            'min' => 0, //  (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $models[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'programme_group_id',
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
                                'columns' => 1,
                                'attributes' => [
                                    'programme_priority' => ['type' => Form::INPUT_TEXT,
                                        'options' => [
                                            'placeholder' => '--select--'
                                        ],
                                    ],
                                ]
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
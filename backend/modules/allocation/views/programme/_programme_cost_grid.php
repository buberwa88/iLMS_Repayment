<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Address: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Address: " + (index + 1))
    });
});
';
$this->registerJs($js);
?>
<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <?= $form->field($cost, 'academic_year_id')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>
    <?php
    \wbraganca\dynamicform\DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $model_cost[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'loan_item_id',
            'rate_type',
            'unit_amount',
            'duration',
        ],
    ]);
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add address</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items">
            <?php
            if ($model->years_of_study > 0) {
                for ($year_id = 1; $year_id <= $model->years_of_study; $year_id++) {
                    ?>  
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <span class="panel-title-address">Programe Cost - Year #<?php echo $year_id; ?></span>
                            <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (!$model_cost->isNewRecord) {
                                echo Html::activeHiddenInput($cost, "[{$year_id}]programme_id");
                                echo Html::activeHiddenInput($cost, "[{$year_id}]programme_type");
                            }
                            ?>
                            <div class="row">

                                <div class="col-sm-2">
                                    <?= $form->field($cost, "[{$year_id}]loan_item_id")->textInput(['maxlength' => true]) ?>

                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($cost, "[{$year_id}]rate_type")->textInput(['maxlength' => true]) ?>

                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($cost, "[{$year_id}]unit_amount")->textInput(['maxlength' => true]) ?>

                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($cost, "[{$year_id}]duration")->textInput(['maxlength' => true]) ?>

                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($cost, "[{$year_id}]year_of_study")->textInput(['maxlength' => true]) ?>

                                </div>
                            </div><!-- end:row -->

                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

    </div>
    <?php DynamicFormWidget::end(); ?>
    <div class="text-right">
        <?= Html::submitButton($model_cost->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
        ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        ActiveForm::end();
        ?>
    </div>
</div>
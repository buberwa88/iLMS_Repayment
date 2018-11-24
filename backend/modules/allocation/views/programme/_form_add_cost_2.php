<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Programe Cost - Year# " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Programe Cost - Year# " + (index + 1))
    });
});
';
$this->registerJs($js);
?>
<div style="margin: 1%;">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row col-md-3" style="margin: 0.5%;margin-left: 0;clear: both;float: left">
        <?php
        // necessary for update action.
        if (!$model_cost->isNewRecord) {
            echo Html::activeHiddenInput($cost, "[{$year_id}]programme_id");
            echo Html::activeHiddenInput($cost, "[{$year_id}]programme_type");
        }
        ?>
        <?= $form->field($cost, 'academic_year_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->where(['is_current' => 1])->asArray()->all(), 'academic_year_id', 'academic_year')); ?>
    </div>
    <?php
    \wbraganca\dynamicform\DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => $model->years_of_study,
        // the maximum times, an element can be cloned (default 999)
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
            'year_of_study'
        ],
    ]);
    ?>

    <div class="panel panel-default">

        <div class="panel-body container-items">

            <?php
            if ($model->years_of_study > 0) {
                for ($year_id = 1; $year_id <= $model->years_of_study; $year_id++) {
                    ?>  
                    <div class="item panel panel-default" style="clear: both"><!-- widgetBody -->
                        <div class="panel-heading">
                            <span class="panel-title-address">Programe Cost - Year #<?php echo $year_id; ?></span>
                            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Item</button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">

                            <div class="row">

                                <div class="col-sm-5">
                                    <?= $form->field($cost, "[{$year_id}]loan_item_id")->dropDownList(\yii\helpers\ArrayHelper::map(\backend\modules\allocation\models\LoanItem::getLoanItemsByItem($model->programmeGroup->study_level, $category), 'loan_item_id', 'item_name'), ['prompt' => '--select--']); ?>

                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($cost, "[{$year_id}]rate_type")->dropDownList(\backend\modules\allocation\models\LoanItem::getItemRates(), ['prompt' => '--select--']); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($cost, "[{$year_id}]unit_amount")->textInput(['maxlength' => true]) ?>

                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($cost, "[{$year_id}]duration")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>

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
        <?= Html::submitButton($cost->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
        ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        ActiveForm::end();
        ?>
    </div>
</div>
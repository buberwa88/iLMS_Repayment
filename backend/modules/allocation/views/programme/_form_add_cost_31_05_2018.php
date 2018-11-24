<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
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

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="item row">
        <div class="col-sm-10">
            <?= $form->field($cost, 'programme_id')->dropDownList(ArrayHelper::map(backend\modules\allocation\models\Programme::find()->asArray()->all(), 'programme_id', 'programme_name'), ['selected' => $model->programme_id, 'readonly' => TRUE, "disabled" => "disabled"]); ?>
        </div>
    </div>
    <div class="item row">
        <div class="col-sm-5">
            <?= $form->field($cost, 'academic_year_id')->dropDownList(ArrayHelper::map(\common\models\AcademicYear::find()->where(['is_current' => 1])->asArray()->all(), 'academic_year_id', 'academic_year'),['prompt'=>'-- select --']); ?>
        </div>

        <div class="col-sm-5">
            <?= $form->field($cost, 'year_of_study')->dropDownList(Yii::$app->params['programme_years_of_study'],['prompt'=>'-- select --']); ?>
        </div>
    </div>


    <?php
    if ($model->years_of_study > 0) {
        $possible_loan_items = \backend\modules\allocation\models\LoanItem::getLoanItemsByItem($model->programmeGroup->study_level, $cost->item_category);
        ?>
        <?php
        \wbraganca\dynamicform\DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => count($possible_loan_items), // the maximum times, an element can be cloned (default 999)
            'min' => 1, //  (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $cost,
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
        <div class="panel panel-default" style="clear: both">
            <div class="panel-heading">
                <span class="panel-title-address">Loan Items Cost</span>
                <button type="button" style="margin-bottom: 2%;padding:0.3%;font-size:13px"class="pull-right add-item btn btn-success btn-xs">
                    <i class="fa fa-plus"></i> Add/Set Loan Item Cost
                </button>
            </div>
            <div class="panel-body" style="margin: 0;">
                <div class="clearfix"></div>

                <div class=" container-items   panel-default" style="clear: both;"><!-- widgetBody -->
                    <!--<div class=" container-items">-->
                    <div class="item row">
                        <div class="col-sm-5">
                            <?= $form->field($cost, "loan_item_id[]")->dropDownList(\yii\helpers\ArrayHelper::map($possible_loan_items, 'loan_item_id', 'item_name'), ['prompt' => '--select--']); ?>
                        </div>
                        <div class="col-sm-2">
                            <?= $form->field($cost, "rate_type[]")->dropDownList(\backend\modules\allocation\models\LoanItem::getItemRates(), ['prompt' => '--select--']); ?>
                        </div>
                        <div class="col-sm-2">
                            <?= $form->field($cost, "unit_amount[]")->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-2">
                            <?= $form->field($cost, "duration[]")->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>

                        </div>

                    </div><!-- end:row -->

                    <!--</div>-->
                </div>
            </div>
        </div>
        <?php DynamicFormWidget::end(); ?>

        <?php
    }
    ?>
</div>

</div>

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
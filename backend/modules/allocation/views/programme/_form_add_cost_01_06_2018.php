<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
//use wbraganca\dynamicform\DynamicFormWidget;
/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="customer-form">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="item row">
        <div class="col-sm-10">            
            <?= $form->field($cost, 'programme_id')->label(FALSE)->hiddenInput(["value" =>$programme_id]) ?>
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
   <div class="row">
   <div class="panel panel-default">
        <div class="panel-body" style="margin: 0;">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                //'limit' => 1, // the maximum times, an element can be cloned (default 999)
                //'limit' => count($possible_loan_items),
                'min' =>1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $ProgrammeCost[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                'loan_item_id',
                'rate_type',
                'unit_amount',
                'duration',
                'year_of_study'
                ],
            ]); ?>

           
                <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($ProgrammeCost as $i => $ProgrammeCost2): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Loan Items Cost</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body"> 
                        <div class="item row">
                            <div class="col-sm-5">                            
                                <?= $form->field($ProgrammeCost2, "[{$i}]loan_item_id")->dropDownList(ArrayHelper::map(backend\modules\allocation\models\LoanItem::find()->asArray()->all(), 'loan_item_id', 'item_name'), ['prompt' => '--select--']); ?>
                        </div>
                        <div class="col-sm-2">
                            <?= $form->field($ProgrammeCost2, "[{$i}]rate_type")->dropDownList(\backend\modules\allocation\models\LoanItem::getItemRates(), ['prompt' => '--select--']); ?>
                        </div>
                        <div class="col-sm-2">
                            <?= $form->field($ProgrammeCost2, "[{$i}]unit_amount")->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-2">
                            <?= $form->field($ProgrammeCost2, "[{$i}]duration")->textInput(['maxlength' => true]) ?>
                        </div>
                
            <?php endforeach; ?>
            </div>
                        </div>
            <?php DynamicFormWidget::end(); ?>
                                
    </div>
       </div>
    </div>
    </div>
       </div>
    <div class="text-right">        
		<?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        <?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['index','id'=>$programme_id], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $loan_item,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'allocation_plan_id' => ['type' => Form::INPUT_HIDDEN,
        ],
        'loan_item_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where(['is_active'=>  backend\modules\allocation\models\LoanItem::STATUS_ACTIVE])->asArray()->all(), 'loan_item_id', 'item_name'),
                'options' => [
                    'placeholder' => '-- Select --',
                ],
            ],
        ],
        'priority_order' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => Yii::$app->params['priority_order_list'],
                'options' => [
                    'prompt' => '-- Select --',
                ],
            ],
        ],
//        'rate_type' => ['type' => Form::INPUT_WIDGET,
//            'widgetClass' => \kartik\select2\Select2::className(),
//            'options' => [
//                'data' => backend\modules\allocation\models\LoanItem::getItemRates(),
//                'options' => [
//                    'prompt' => '-- Select --',
//                    'id' => 'rate_type',
//                ],
//            ],
//        ], 
//        'duration' => ['type' => Form::INPUT_TEXT,
//            'label' => 'No. of Days',
//            'options' => [
//                'id' => 'rate_duration',
//            ],
//        ],
//        'unit_amount' => ['type' => Form::INPUT_TEXT,
//            'options' => [
//                'prompt' => '-- Select --',
//                'multiple' => TRUE,
//            ],
//        ],
        'loan_award_percentage' => ['type' => Form::INPUT_TEXT,
           'label'=> 'Minimum Loan Award %', 
            'options' => [
//                'prompt' => '-- Select --',
            ],
        ],
    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($loan_item->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/allocation/allocation-plan/view','id'=>$model->allocation_plan_id], ['class' => 'btn btn-warning        ']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
         alert("Handler for .change() called.");
    int rate_type = ('#rate_type').value();
    int daily_rate = "<?php echo backend\modules\allocation\models\LoanItem::RATE_DAILY ?>";
    int annual_rate = "<?php echo backend\modules\allocation\models\LoanItem::RATE_YEARLY ?>";
     switch (rate_type) {
        case daily_rate:
             ('#rate_duration').show();
             break;
        default:
                ('#rate_duration').hide();
            }
           
        });
    
   
//ON CHANGE
 $("#rate_type").change(function () {
       
       
    });



</script>

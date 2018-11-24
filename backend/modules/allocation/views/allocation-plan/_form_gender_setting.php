<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $gender_item,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'allocation_plan_id' => ['type' => Form::INPUT_HIDDEN,
        ],
         'female_percentage' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => '-- Select --',
                'multiple' => TRUE,
            ],
        ],

    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($gender_item->isNewRecord ? 'Create' : 'Update', ['class' => $gender_item->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/allocation/allocation-plan/view','id'=>$allocation_plan_id], ['class' => 'btn btn-warning        ']) ?>
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

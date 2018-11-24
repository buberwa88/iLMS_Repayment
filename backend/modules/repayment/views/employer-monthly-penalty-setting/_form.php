<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerMonthlyPenaltySetting */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
	 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
	            'employer_type_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Employer Type:',
                'options' => [
                    'data' =>ArrayHelper::map(backend\modules\repayment\models\EmployerType::findBySql('SELECT * FROM `employer_type` WHERE is_active="1"')->asArray()->all(), 'employer_type_id', 'employer_type'),
                    'options' => [
                        'prompt' => 'Select Employer Type',
                    ],
                ],
            ],
            'payment_deadline_day_per_month'=>['label'=>'Payment Deadline Day Per Month:', 'options'=>['placeholder'=>'Payment Deadline Day Per Month:']],'penalty'=>['label'=>'Penalty(%):', 'options'=>['placeholder'=>'Penalty(%):']],			
    ]
]);
?>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?php 
		echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
		echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employer-monthly-penalty-setting/index'], ['class' => 'btn btn-warning']);?>

    <?php ActiveForm::end(); ?>

</div>

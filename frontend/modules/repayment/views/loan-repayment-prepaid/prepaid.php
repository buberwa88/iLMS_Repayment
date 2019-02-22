 <?php
 
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\date\DatePicker;
use kartik\detail\DetailView;
use frontend\modules\repayment\models\EmployerSearch;
/*
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
 * 
 */

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


//$this->params['breadcrumbs'][] = $this->title;
        $loggedin=Yii::$app->user->identity->user_id;
        $employer2=EmployerSearch::getEmployer($loggedin);
        $employerID=$employer2->employer_id;
$resultsPrepaid=\frontend\modules\repayment\models\LoanRepaymentPrepaid::getTotalAmountPrepaid($employerID);
$totalAMOUNT=$resultsPrepaid->monthly_amount;
$bill_number=$resultsPrepaid->bill_number;
$beneficiariesCount=\frontend\modules\repayment\models\LoanRepaymentPrepaid::getTotalBeneficiariesUnderPrePaid($employerID);
$countPendingPayment=\frontend\modules\repayment\models\LoanRepaymentPrepaid::getPendingPaymentPrepaid($employerID);
$detailsPendingPayment=\frontend\modules\repayment\models\LoanRepaymentPrepaid::getGetPendingPayment($employerID);
$bill_numberPayment=$detailsPendingPayment->bill_number;
$control_number=$detailsPendingPayment->control_number;
$amountWaitingPayment=$detailsPendingPayment->monthly_amount;
if($countPendingPayment > 0){
$this->title = 'Waiting for Payment';
}else{
$this->title = 'Pre-Paid';	
}
$this->params['breadcrumbs'][] = $this->title;
$controlNumberPaid='95257';
\frontend\modules\repayment\models\LoanRepayment::updatePaymentAfterGePGconfirmPaymentDonePrePaid($controlNumberPaid);
$resultsUnconsumed=\frontend\modules\repayment\models\LoanRepaymentPrepaid::checkForCofrmedPaymentNotConsumed($employerID);
\frontend\modules\repayment\models\LoanRepayment::createAutomaticBillsPrepaid();
?>
<div class="appleal-default-index">
<div class="panel panel-info">
<div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body"> 
						<?php if($beneficiariesCount==0 && $countPendingPayment==0 && $resultsUnconsumed==0){ ?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'enableClientValidation' => TRUE]); ?>
                <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'payment_date')->label('From')->widget(DatePicker::classname(), [
           'name' => 'payment_date', 	
    'options' => ['placeholder' => 'Enter date (yyyy-mm-dd)',
                  'todayHighlight' => true,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
       </div>
        <div class="col-md-6">
           <?php
                            echo Form::widget([// fields with labels
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'totalMonths' => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => 'Total Months',
                                        'options' => [
                                            'data' => \frontend\modules\repayment\models\LoanRepaymentPrepaid::getTotalMonths(),
                                            'options' => [
                                                'prompt' => '-- Select --',
                                            ],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                            ]]);
                            ?>
       </div>
    </div>
                <div class="text-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Process' : 'Process', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
				<?php ActiveForm::end(); ?>
<br/><br/>
<?php } ?>

<?php if($countPendingPayment > 0 && $resultsUnconsumed==0){ ?>
	<?php
    $attributes = [            

			[
                'columns' => [

                    [
                        'label' => 'Bill Number',
                        'value'  => call_user_func(function ($data) use($bill_numberPayment) {
                 return $bill_numberPayment;
            }, $model),
                        'labelColOptions'=>['style'=>'width:10%'],
                        'valueColOptions'=>['style'=>'width:20%'],
                    ],
                    [
                        'label' => 'Control Number',
                        'value'  => call_user_func(function ($data) use($control_number){

                return $control_number;
							
            }, $model),
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],					
                 [
                        'label' => 'Total Amount',
                        'value'  => call_user_func(function ($data) use($amountWaitingPayment){

                return $amountWaitingPayment;
							
            }, $model),
                        'labelColOptions'=>['style'=>'width:10%'],
                        'valueColOptions'=>['style'=>'width:20%'],
						'format'=>['decimal',2],
                    ],					
                ],
            ],
				
        ];
		echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);
	?>
<?php } ?>
<?php if($beneficiariesCount > 0 && $countPendingPayment==0 && $resultsUnconsumed==0){ ?>
	<?php
    $attributes = [            

			[
                'columns' => [

                    [
                        'label' => 'Bill Number',
                        'value'  => call_user_func(function ($data) use($bill_number) {
                 return $bill_number;
            }, $model),
                        'labelColOptions'=>['style'=>'width:10%'],
                        'valueColOptions'=>['style'=>'width:20%'],
                    ], 
                 [
                        'label' => 'Total Amount',
                        'value'  => call_user_func(function ($data) use($totalAMOUNT){

                return $totalAMOUNT;
							
            }, $model),
                        'labelColOptions'=>['style'=>'width:10%'],
                        'valueColOptions'=>['style'=>'width:20%'],
						'format'=>['decimal',2],
                    ],
                    [
                        'label' => 'Total Beneficiaries',
                        'value'  => call_user_func(function ($data) use($beneficiariesCount){

                return $beneficiariesCount;
							
            }, $model),
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',0],
                    ],					
                ],
            ],
				
        ];
		echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);

	?>
</br/>
<div class="text-right">
		<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'action' => ['/repayment/loan-repayment-prepaid/confirm-paymentprepaid'],]); ?>
		<?= $form->field($model, 'bill_number')->label(false)->hiddenInput(['value'=>$bill_number,'readOnly'=>'readOnly']) ?>
<?= Html::submitButton($model->isNewRecord ? 'Click here to confirm for payment' : 'Click here to confirm for payment', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick'=>'return  check_status()']) ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['cancel-prepaid','bill_number'=>$bill_number], ['class' => 'btn btn-warning']);
?>

</div>
<?php ActiveForm::end(); ?>
<br/><br/>			
<?php } ?>
<?php if($beneficiariesCount > 0 && $countPendingPayment==0 && $resultsUnconsumed==0){ ?>
				<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'employer_id',
            //'applicant_id',
            //'loan_summary_id',
			//'payment_date',
			[
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
            ],
			
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],
			
		    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
            ],
			[
                'attribute'=>'payment_date',
				'label'=>'Pay Month',
                'format'=>'raw',
                'value'=>function($model)
            {
             return date("Y-m",strtotime($model->payment_date));                    
            },
            ],
            //'monthly_amount',
			[
            'attribute'=>'monthly_amount',
            'label'=>'Amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->monthly_amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],
            // 'payment_date',
            // 'created_at',
            // 'created_by',
            // 'bill_number',
            // 'control_number',
            // 'receipt_number',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'receipt_date',
            // 'date_receipt_received',
            // 'payment_status',
            // 'cancelled_by',
            // 'cancelled_at',
            // 'cancel_reason',
            // 'gepg_cancel_request_status',
            // 'monthly_deduction_status',
            // 'date_deducted',

            //['class' => 'yii\grid\ActionColumn'],
        ],
		'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
    ]); ?>
<?php } ?>
<?php if($beneficiariesCount == 0 && $countPendingPayment==0 && $resultsUnconsumed > 0){ ?>
				<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'employer_id',
            //'applicant_id',
            //'loan_summary_id',
			//'payment_date',
			[
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
            ],
			
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],
			
		    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
            ],
			[
                'attribute'=>'payment_date',
				'label'=>'Pay Month',
                'format'=>'raw',
                'value'=>function($model)
            {
             return date("Y-m",strtotime($model->payment_date));                    
            },
            ],
            //'monthly_amount',
			[
            'attribute'=>'monthly_amount',
            'label'=>'Amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->monthly_amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],
            // 'payment_date',
            // 'created_at',
            // 'created_by',
            // 'bill_number',
            // 'control_number',
            // 'receipt_number',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'receipt_date',
            // 'date_receipt_received',
            // 'payment_status',
            // 'cancelled_by',
            // 'cancelled_at',
            // 'cancel_reason',
            // 'gepg_cancel_request_status',
            // 'monthly_deduction_status',
            // 'date_deducted',

            //['class' => 'yii\grid\ActionColumn'],
        ],
		'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
    ]); ?>
<?php } ?>
	<br/>
</div>
       </div>
	    </div>
<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenaltyPayment */
/* @var $form yii\widgets\ActiveForm */
$totalAmount=frontend\modules\repayment\models\EmployerPenaltyPayment::getTotalPenaltyAmount($employerID);
$paidAmount=frontend\modules\repayment\models\EmployerPenaltyPayment::getTotalPenaltyAmountPaid($employerID);
$outstandingAmount=$totalAmount-$paidAmount;
?>

<div class="employer-penalty-payment-form">

    
	
	<?php
    $attributes = [            

			[
                'columns' => [

                    [
                        'label' => 'Total Amount',
                        'value'  => call_user_func(function ($data) use($totalAmount) {
                 return $totalAmount;
            }, $model),
                        'labelColOptions'=>['style'=>'width:15%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',2],
                    ], 
                 [
                        'label' => 'Amount Paid',
                        'value'  => call_user_func(function ($data) use($paidAmount) {
							if($paidAmount==''){
							return 0;	
							}else{
                return $paidAmount;
							}
            }, $model),
                        'labelColOptions'=>['style'=>'width:12%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',2],
                    ],					
                ],
            ],
			[
                'columns' => [

                    [
                        'label' => 'Outstanding Amount',
                        'value'  => call_user_func(function ($data) use($outstandingAmount) {
                return $outstandingAmount;
            }, $model),
                        'labelColOptions'=>['style'=>'width:5%'],
                        'valueColOptions'=>['style'=>'width:30%'],
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
	
	
	<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
	<?php if($outstandingAmount > 0){ ?>
	<div class="row" style="width:50%;">
        <div class="col-md-4">
            <?= $form->field($model, 'amount')->textInput(['value'=>$outstandingAmount,'readOnly'=>'readOnly']) ?>
       </div>
        <div class="col-md-6">
		<?php
		/*
           [
            'header' => 'Actions',  
            'format'=>'raw',
            'value' => function ($data){
                    return  Html::a('Adjust Amount',['loan-repayment-detail/update-new-payment-amount','id'=>$data->loan_repayment_detail_id],['data-toggle'=>"modal",'data-target'=>"#adjustAmount",'data-title'=>"Adjust Amount",'class' => 'btn btn-success',]
                );
                }
        ],
		*/
		?>
       </div>
    </div>
	
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Click here to confirm for payment' : 'Click here to confirm for payment', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::begin([
    'id' => 'adjustAmountPenalty',
    'header' => '<h4 class="modal-title">...</h4>',
]);
 
//echo '...';
 
Modal::end();
?>
<?php
    $this->registerJs("
    $('#adjustAmountPenalty').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
?>

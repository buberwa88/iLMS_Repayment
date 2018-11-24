<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = "Information of loan beneficiary";
$this->params['breadcrumbs'][] = ['label' => 'All Loanees', 'url' => ['all-loanees']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
	<?php
    $attributes = [
            [
                'group' => true,
                'label' => '',
                'rowOptions' => ['class' => 'info'],
                'format'=>'raw',
            ],
			
			
			[
                'columns' => [
				     [
            'label'=>'Form IV Indexno',
            'value'  => call_user_func(function ($data) {
			 $educationDetails = array();	
                $num=0;				
				foreach ($data->applications as $appEduDetails) {						
						foreach ($appEduDetails->educations as $appeducation) {
						//$educationDetails[] = $appeducation->application_id;
						$educationDetails =$appeducation->olevel_index;
                        }						
                    }
					return $educationDetails;
            }, $model),
			'labelColOptions'=>['style'=>'width:20%'],
            'valueColOptions'=>['style'=>'width:30%'],
            //'filter' => Lookup::items('SubjectType'),
        ],

                    [
                        'label' =>'Full Name',
                        'value' => $model->user->firstname.", ".$model->user->middlename." ".$model->user->surname,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],		
                    
                ],
            ],
			
			
            [
                'columns' => [

                    [
                        'label' => 'Sex',
                        'value'  => call_user_func(function ($data) {
			            if($data->sex=='M'){
						$sexV="Male";
						}else if($data->sex=='F'){
						$sexV="Female";
						}else{
						$sexV="Not Set";
						}
                return $sexV;
            }, $model),
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
	
			[
            'label'=>'University',
            'value'  => call_user_func(function ($data) {
			 $institutionDetails = array();	
             $num=0;
			 foreach ($data->applications as $appEduDetails2) {						
						foreach ($appEduDetails2->educations as $appLearningIns) {
						//$educationDetails[] = $appeducation->application_id;
						$institutionDetails =$appLearningIns->learningInstitution->institution_name;
                        }						
                    }
                return $institutionDetails;
            }, $model),
			'labelColOptions'=>['style'=>'width:20%'],
            'valueColOptions'=>['style'=>'width:30%'],
            //'filter' => Lookup::items('SubjectType'),
        ],
                    
                ],
            ],

			[
                'columns' => [

                    [
                        'label' => 'Disbursement',
                        'value'  => call_user_func(function ($data) {
                return \common\models\LoanBeneficiary::getPrinciplePlusReturn($data->applicant_id);
            }, $model),
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',2],
                    ],
	
			[
            'label'=>'Return',
            'value'  => call_user_func(function ($data) {
                return \common\models\LoanBeneficiary::getAmountReturned($data->applicant_id);
            }, $model),
			'labelColOptions'=>['style'=>'width:20%'],
            'valueColOptions'=>['style'=>'width:30%'],
			'format'=>['decimal',2],
            //'filter' => Lookup::items('SubjectType'),
        ],
                    
                ],
            ],
			[
                'columns' => [

                    [
                        'label' => 'Repayment',
                        'value'  => call_user_func(function ($data) {
                return \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($data->applicant_id);
            }, $model),
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',2],
                    ],
	
			[
            'label'=>'Principal',
            'value'  => call_user_func(function ($data) {
                return backend\modules\repayment\models\LoanSummaryDetail::getTotalPrincipleLoanOriginal($data->applicant_id);
            }, $model),
			'labelColOptions'=>['style'=>'width:20%'],
            'valueColOptions'=>['style'=>'width:30%'],
			'format'=>['decimal',2],
            //'filter' => Lookup::items('SubjectType'),
        ],
                    
                ],
            ],
			[
                'columns' => [

                    [
                        'label' => 'VRF',
                        'value'  => call_user_func(function ($data) {
                return backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($data->applicant_id);
            }, $model),
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',2],
                    ],
	
			[
            'label'=>'Penalty',
            'value'  => call_user_func(function ($data) {
                return backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($data->applicant_id);
            }, $model),
			'labelColOptions'=>['style'=>'width:20%'],
            'valueColOptions'=>['style'=>'width:30%'],
			'format'=>['decimal',2],
            //'filter' => Lookup::items('SubjectType'),
        ],
                    
                ],
            ],
			[
                'columns' => [

                    [
                        'label' => 'LAF',
                        'value'  => call_user_func(function ($data) {
                return backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($data->applicant_id);
            }, $model),
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',2],
                    ],
	
			[
            'label'=>'Refund',
            'value'  => call_user_func(function ($data) {
                return backend\modules\repayment\models\refund::getTotalRefundPerBeneficiary($data->applicant_id);
            }, $model),
			'labelColOptions'=>['style'=>'width:20%'],
            'valueColOptions'=>['style'=>'width:30%'],
			'format'=>['decimal',2],
            //'filter' => Lookup::items('SubjectType'),
        ],
                    
                ],
            ],
			[
                'columns' => [

                    [
                        'label' => 'Balance',
                        'value'  => call_user_func(function ($data) {
               return \frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($data->applicant_id);
            }, $model),
                        'labelColOptions'=>['style'=>'width:20%'],
						'format'=>['decimal',2],
                        //'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    
                ],
            ],
			
            [
                'columns' => [

                    [
					    'label' => 'Passport Photo',
                        'value'=>  Html::img(Yii::$app->params['front'].$model->user->passport_photo, ['width'=>'100','height'=>'100']),
                        'labelColOptions'=>['style'=>'width:20%'],					
                        'format'=>'raw',
                        
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
	<p>
        
		<?= $this->render('_formProcessPrint', [
        'model' =>$modelLoanBeneficiary,'applicant_id'=>$model->applicant_id,
    ]) ?>
        
    </p>
	<?php								
echo TabsX::widget([
    'items' => [  	
        [
            'label' => 'Application Details',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-beneficiary/view-applications-details','applicant_id'=>$model->applicant_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],		
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?>

</div>
    </div>
</div>

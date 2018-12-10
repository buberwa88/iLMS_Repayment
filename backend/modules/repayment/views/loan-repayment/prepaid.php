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
$this->title = 'Pre-payment';	
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
                     'attribute' => 'employer_id',
                        'label'=>"Employer",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->employer->employer_name;
                        },
            ],
			
            [
                     'attribute' => 'bill_number',
                        'label'=>"Bill Number",
                        'value' => function ($model) {
                            return $model->bill_number;
                        },
            ],
			
		    [
                     'attribute' => 'control_number',
                        'label'=>"Control Number",
                        'value' => function ($model) {
                            return $model->control_number;
                        },
            ],
			
            //'monthly_amount',
			[
            'attribute'=>'monthly_amount',
            'label'=>'Total Amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return frontend\modules\repayment\models\LoanRepaymentPrepaid::getTotalAmountUnderBillPrepaid($model->employer_id,$model->bill_number);
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],
			[
            'attribute'=>'totalBeneficiaries',
            'label'=>'Beneficiaries',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return \frontend\modules\repayment\models\LoanRepaymentPrepaid::getTotalBeneficiariesUnderPrePaidheslb($model->employer_id,$model->bill_number);
            }, 
            ],
			[
                'attribute'=>'payment_date',
				'label'=>'From Month',
                'format'=>'raw',
                'value'=>function($model)
            {
             return date("Y-m",strtotime(frontend\modules\repayment\models\LoanRepaymentPrepaid::getstartPrePaidheslb($model->employer_id,$model->bill_number)));                    
            },
            ],
			[
                'attribute'=>'payment_date2',
				'label'=>'To Month',
                'format'=>'raw',
                'value'=>function($model)
            {
             return date("Y-m",strtotime(frontend\modules\repayment\models\LoanRepaymentPrepaid::getEndPrePaidheslb($model->employer_id,$model->bill_number)));                    
            },
            ],
			[
                     'attribute' => 'payment_status',
                        'value' => function ($model) {
                                   if($model->payment_status ==1){
                                     return Html::label("Paid", NULL, ['class'=>'label label-success']);
                                    }else{
                                        return Html::label("Pending", NULL, ['class'=>'label label-warning']);
                                    }
                        },
                        'format' => 'raw'
                    ],
			 ['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',
                         'buttons' => [

            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view'),
                ]);
            },

          ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/loan-repayment/view-prepaid&bill_number='.$model->bill_number.'&employer_id='.$model->employer_id;
                return $url;
            }
          }
			],
        ],
		'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
    ]); ?>
</div>
       </div>
	    </div>